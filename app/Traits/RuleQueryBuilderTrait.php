<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

trait RuleQueryBuilderTrait
{

    public function queryBuilder($table, $query)
    {
        $user = getCurrentUser();
        $recordRule = DB::table('record_rules')
                        ->join('role_record_rules', 'role_record_rules.record_rule_id', 'record_rules.id')
                        ->whereIn('role_record_rules.role_id', $user->roles->pluck('id'))
                        ->whereIn('record_rules.table', $table ?? [])
                        ->select(
                            'rule',
                            'link'
                        )
                        ->get();

        foreach ($recordRule as $row) {
            $rule = $row->rule ?? '';
            $links = explode(',', $row->link ?? '*');
            $isFound = false;
            for($i=0; $i< count($links); $i++)
            {
                if(request()->routeIs($links[$i]))
                {
                    $isFound = true;
                    break;
                }
            }

            if(!$isFound) continue;

            $curPositions = "";
            $currDepartments = "";
            $currCompanies = "";
            $currSites = "";
            if(getCurrentUser()->employee) {
                $curPositions = implode(",", getCurrentUser()->employee->currentPositions->pluck('position_id')->toArray() ?? []);
                $currDepartments = implode(",", getCurrentUser()->employee->currentDepartments->pluck('department_id')->toArray() ?? []);
                $currCompanies = implode(",", getCurrentUser()->employee->currentCompanies->pluck('company_id')->toArray() ?? []);
                $currSites = implode(",", getCurrentUser()->employee->currentSites->pluck('site_id')->toArray() ?? []);    
            }

            $rule = str_replace(
                [
                    '@currUser',
                    '@currEmployee',
                    '@currPositions',
                    '@currDepartments',
                    '@currCompanies',
                    '@currSites',
                    '@currPosition',
                    '@currDepartment',
                    '@currCompany',
                    '@currSite',
                ], 
                [
                    getCurrentUser()->id ?? '', 
                    getCurrentUser()->employee->id ?? '', 
                    $curPositions,
                    $currDepartments,
                    $currCompanies,
                    $currSites,
                    getCurrentUser()->employee->position->position_id ?? '', 
                    getCurrentUser()->employee->department->department_id ?? '', 
                    getCurrentUser()->employee->company->company_id ?? '',
                    getCurrentUser()->employee->site->site_id ?? '',
                ], 
                $rule
            );

            while ($rule != '') {
                $pos = $this->getClosedBracket($rule);
    
                $q = substr($rule, 0, $pos+1);
                if(Str::startsWith($q, '@andgroup(')) {
                    $q = substr($q, 10, $pos-10);
                    $query = $query->where(function($qr) use ($q)
                    {
                        $qr = $this->recursive($q, $qr);
                    });
    
                } else if(Str::startsWith($q, '@orgroup(')) {
                    $q = substr($q, 9, $pos-9);
                    $query = $query->orWhere(function($qr) use ($q)
                    {
                        $qr = $this->recursive($q, $qr);
                    });
    
                } else if(Str::startsWith($q, '@and(')) {
                    $q = substr($q, 5, $pos-5);
                    $q = explode(';', $q);
                    if($q[1] == 'in') {
                        $query->whereIn($q[0], explode(',', $q[2]));
                    } else if($q[1] == 'notin') {
                        $query->whereNotIn($q[0], explode(',', $q[2]));
                    } else {
                        $query->where($q[0], $q[1], $q[2]);
                    }
    
                } else if(Str::startsWith($q, '@or(')) {
                    $q = substr($q, 4, $pos-4);
                    $q = explode(';', $q);
                    if($q[1] == 'in') {
                        $query->orWhereIn($q[0], explode(',', $q[2]));
                    } else if($q[1] == 'notin') {
                        $query->orWhereNotIn($q[0], explode(',', $q[2]));
                    } else {
                        $query->orWhere($q[0], $q[1], $q[2]);
                    }
                }
    
                $rule = substr($rule, $pos+1, strlen($rule)-1);
            }
        }

        return $query;
    }

    public function recursive($rule, $query) {
        $data = array();

        while ($rule != '') {
            $pos = $this->getClosedBracket($rule);
            $q = substr($rule, 0, $pos+1);
            if(Str::startsWith($q, '@andgroup(')) {
                $q = substr($q, 10, $pos-10);
                $query = $query->where(function($qr) use ($q)
                {
                    $qr = $this->recursive($q, $qr);
                });

            } else if(Str::startsWith($q, '@orgroup(')) {
                $q = substr($q, 9, $pos-9);
                $query = $query->orWhere(function($qr) use ($q)
                {
                    $qr = $this->recursive($q, $qr);
                });

            } else if(Str::startsWith($q, '@and(')) {
                $q = substr($q, 5, $pos-5);
                $q = explode(';', $q);

                if($q[1] == 'in') {
                    array_push($data, $query->whereIn($q[0], explode(',', $q[2])));
                } else if($q[1] == 'notin') {
                    array_push($data, $query->whereNotIn($q[0], explode(',', $q[2])));
                } else {
                    array_push($data, $query->where($q[0], $q[1], $q[2]));
                }

            } else if(Str::startsWith($q, '@or(')) {
                $q = substr($q, 4, $pos-4);
                $q = explode(';', $q);
                if($q[1] == 'in') {
                    array_push($data, $query->orWhereIn($q[0], explode(',', $q[2])));
                } else if($q[1] == 'notin') {
                    array_push($data, $query->orWhereNotIn($q[0], explode(',', $q[2])));
                } else {
                    array_push($data, $query->orWhere($q[0], $q[1], $q[2]));
                }
            }

            $rule = substr($rule, $pos+1, strlen($rule)-1);
        }
        return $data;
    }

    function getClosedBracket($string)
    {
        if (strpos($string, '(') == -1) {
            return -1;
        }
        $stack = 1;
        for ($i = strpos($string, '(') + 1; $i < strlen($string); $i++) {
            switch ($string[$i]) {
            case '(':
                $stack++;
                break;
            case ')':
                if (--$stack == 0) {
                    return $i;
                }
                break;
            }
        }
        return -1;
    }

}
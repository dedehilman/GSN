<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

trait RuleQueryBuilderTrait
{

    public function queryBuilder($table, $query)
    {
        if(!$table) {
            $table = array();
            array_push($table, $query->from);
            for ($i=0; $i < count($query->joins); $i++) { 
                array_push($table, $query->joins[$i]->table);
            }
        }

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
			
			$currAfdelinks = "";
			$afdelinks = DB::table("afdelinks")->where('estate_id', getCurrentUser()->userDetail->clinic->estate->id ?? null)->get();
			foreach ($afdelinks as $afdelink) {
				if($currAfdelinks != "") {
					$currAfdelinks = $currAfdelinks.',';
				}
				
				$currAfdelinks = $currAfdelinks.$afdelink->id;
			}

            $rule = str_replace(
                [
                    '@currUser',
                    '@currMedicalStaff',
                    '@currClinic',
					'@currEstate',
					'@currAfdelinks',
                ], 
                [
                    getCurrentUser()->id ?? '', 
                    getCurrentUser()->userDetail->id ?? '', 
                    getCurrentUser()->userDetail->clinic->id ?? '',
					getCurrentUser()->userDetail->clinic->estate->id ?? '',
					$currAfdelinks,
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
                        $query->whereIn($q[0], explode(',', $this->getValue($q[2])));
                    } else if($q[1] == 'notin') {
                        $query->whereNotIn($q[0], explode(',', $this->getValue($q[2])));
                    } else {
                        $query->where($q[0], $q[1], $this->getValue($q[2]));
                    }
    
                } else if(Str::startsWith($q, '@or(')) {
                    $q = substr($q, 4, $pos-4);
                    $q = explode(';', $q);
                    if($q[1] == 'in') {
                        $query->orWhereIn($q[0], explode(',', $this->getValue($q[2])));
                    } else if($q[1] == 'notin') {
                        $query->orWhereNotIn($q[0], explode(',', $this->getValue($q[2])));
                    } else {
                        $query->orWhere($q[0], $q[1], $this->getValue($q[2]));
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
                    array_push($data, $query->whereIn($q[0], explode(',', $this->getValue($q[2]))));
                } else if($q[1] == 'notin') {
                    array_push($data, $query->whereNotIn($q[0], explode(',', $this->getValue($q[2]))));
                } else {
                    array_push($data, $query->where($q[0], $q[1], $this->getValue($q[2])));
                }

            } else if(Str::startsWith($q, '@or(')) {
                $q = substr($q, 4, $pos-4);
                $q = explode(';', $q);
                if($q[1] == 'in') {
                    array_push($data, $query->orWhereIn($q[0], explode(',', $this->getValue($q[2]))));
                } else if($q[1] == 'notin') {
                    array_push($data, $query->orWhereNotIn($q[0], explode(',', $this->getValue($q[2]))));
                } else {
                    array_push($data, $query->orWhere($q[0], $q[1], $this->getValue($q[2])));
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

    function getValue($value) {
        if(Str::startsWith($value, 'clinicEstate:') || Str::startsWith($value, 'clinicAfdelink:')) {
            $valueArr = explode(',', str_replace('clinicAfdelink:','',str_replace('clinicEstate:','',$value)));
            $valueTmp = "";
            foreach ($valueArr as $index => $val) {
                $clinic = DB::table("clinics")->where('id', $val)->first();
                if($clinic) {
                    if($valueTmp == "") {
                        $valueTmp = $clinic->estate_id;
                    } else {
                        $valueTmp = $valueTmp.','.$clinic->estate_id;
                    }
                }
            }

            if(Str::startsWith($value, 'clinicAfdelink:') && $valueTmp != "") {
                $valueArr = explode(',', $valueTmp);
                $valueTmp = "";
                foreach ($valueArr as $index => $val) {
                    $afdelink = DB::table("afdelinks")->where('estate_id', $val)->first();
                    if($afdelink) {
                        if($valueTmp == "") {
                            $valueTmp = $afdelink->id;
                        } else {
                            $valueTmp = $valueTmp.','.$afdelink->id;
                        }
                    }
                }
            }

            $value = $valueTmp;
        }

        return $value;
    }

}
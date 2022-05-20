<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

trait MenuBuilderTrait
{

    public function buildMenu()
    {
        $menus = [];
        foreach (Auth::user()->roles as $role) {
            foreach ($role->menus as $menu) {
                array_push($menus, $menu->id);
            }
        }

        $data = array();
        $referrals = Menu::whereNull('parent_id')
                        ->where('display', '1')
                        ->whereIn('id', $menus)
                        ->orderBy('sequence', 'ASC')
                        ->get();
        
        $output = '';

        for ($i = 0; $i < count($referrals); $i++) {
            array_push($data, array(
                    'id'=> $referrals[$i]->id,
                    'title'=> $referrals[$i]->title,
                    'class'=> $referrals[$i]->class,
                    'nav_header'=> $referrals[$i]->nav_header,
                    'link'=> $referrals[$i]->link,
                    'children' => $this->recursiveTree($referrals[$i]->code, $menus),
                )
            );
        }
        
        return $data;
    }

    function recursiveTree($referral_ids, $menus)
    {
        $data = array();
        $referrals = Menu::where('parent_id', $referral_ids)
                        ->where('display', '1')
                        ->whereIn('id', $menus)
                        ->orderBy('sequence', 'ASC')
                        ->get();

        for ($i = 0; $i < count($referrals); $i++) {
            array_push($data, array(
                    'id'=> $referrals[$i]->id,
                    'title'=> $referrals[$i]->title,
                    'class'=> $referrals[$i]->class,
                    'nav_header'=> $referrals[$i]->nav_header,
                    'link'=> $referrals[$i]->link,
                    'children' => $this->recursiveTree($referrals[$i]->code, $menus),
                )
            );
        }
        
        return $data;
    }
    
}
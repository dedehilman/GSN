<?php
use Illuminate\Support\Facades\Auth;
use App\Models\Parameter;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\AppearanceSetting;

function getCurrentUser()
{
    return Auth::user();
}

function getAppearance()
{
    $appearance = getCurrentUser()->appearance ?? null;
    if(!$appearance) {
        $appearance = AppearanceSetting::where('type', 'global')->first();
    }
    return $appearance;
}

function getMenu($menus)
{
    $output = '';
    $outputOthers = '';
    if($menus)
    {
        foreach ($menus as $index => $menu) {
            if(count($menu['children']) == 0) {
                if($menu['nav_header'] == '1')
                {
                    if((getAppearance()->layout ?? 'sidebar-mini') == 'sidebar-mini') {
                        $output .= '<li class="nav-header">'.Str::upper(Lang::get($menu['title'])).'</li>';
                    }
                }
                else
                {
                    $links = explode(',', $menu['link']);
                    $is_active = false;
                    for($i=0; $i< count($links); $i++)
                    {
                        if(request()->routeIs($links[$i]))
                        {
                            $is_active = true;
                            break;
                        }
                    }    
                    $link = '#';
                    if(count($links) > 0 && $links[0] != '')
                    {
                        if(Route::has($links[0]))
                        {
                            $link = Route($links[0]);
                        }
                    }
                    if((getAppearance()->layout ?? 'sidebar-mini') == 'sidebar-mini') {
                        $output .= '<li class="nav-item"><a href="'.$link.'" class="nav-link '.($is_active ? 'active' : '').'"><i class="'.$menu['class'].'"></i><p>'.Lang::get($menu['title']).'</p></a></li>';    
                    } else {
                        if($index > 5) {
                            if((getAppearance()->navbar_show_icon ?? '0') == '0') {
                                $outputOthers .= '<li><a href="'.$link.'" class="dropdown-item '.($is_active ? 'active' : '').'">'.Lang::get($menu['title']).'</a></li>';    
                            } else {
                                $outputOthers .= '<li><a href="'.$link.'" class="dropdown-item '.($is_active ? 'active' : '').'"><i class="'.$menu['class'].' d-inline" style="margin-right: 10px;"></i>'.Lang::get($menu['title']).'</a></li>';
                            }
                        } else {
                            if((getAppearance()->navbar_show_icon ?? '0') == '0') {
                                $output .= '<li class="nav-item"><a href="'.$link.'" class="nav-link '.($is_active ? 'active' : '').'">'.Lang::get($menu['title']).'</a></li>';    
                            } else {
                                $output .= '<li class="nav-item"><a href="'.$link.'" class="nav-link '.($is_active ? 'active' : '').'"><i class="'.$menu['class'].' d-inline" style="margin-right: 10px;"></i>'.Lang::get($menu['title']).'</a></li>';    
                            }    
                        }
                    }
                }
            } else {
                $links = explode(',', $menu['link']);
                $is_active = false;
                for($i=0; $i< count($links); $i++)
                {
                    if(request()->routeIs($links[$i]))
                    {
                        $is_active = true;
                        break;
                    }
                }
                if((getAppearance()->layout ?? 'sidebar-mini') == 'sidebar-mini') {
                    $output .= '<li class="nav-item has-treeview '.($is_active ? 'menu-open' : '').'"><a href="#" class="nav-link '.($is_active ? 'active' : '').'"><i class="'.$menu['class'].'"></i><p>'.Lang::get($menu['title']).'<i class="right fas fa-angle-left"></i></p></a><ul class="nav nav-treeview">';
                    $output .= getOutput($menu['children']);
                    $output .= '</ul></li>';    
                } else {
                    if($index > 5) {
                        if((getAppearance()->navbar_show_icon ?? '0') == '0') {
                            $outputOthers .= '<li class="dropdown-submenu dropdown-hover"><a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle '.($is_active ? 'active' : '').'">'.Lang::get($menu['title']).'</a><ul class="dropdown-menu border-0 shadow">';
                        } else {
                            $outputOthers .= '<li class="dropdown-submenu dropdown-hover"><a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle '.($is_active ? 'active' : '').'"><i class="'.$menu['class'].' d-inline" style="margin-right: 10px;"></i>'.Lang::get($menu['title']).'</a><ul class="dropdown-menu border-0 shadow">';
                        }
                        $outputOthers .= getOutput($menu['children']);
                        $outputOthers .= '</ul></li>';
                    } else {
                        if((getAppearance()->navbar_show_icon ?? '0') == '0') {
                            $output .= '<li class="nav-item dropdown"><a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle '.($is_active ? 'active' : '').'">'.Lang::get($menu['title']).'</a><ul class="dropdown-menu border-0 shadow">';
                        } else {
                            $output .= '<li class="nav-item dropdown"><a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle '.($is_active ? 'active' : '').'"><i class="'.$menu['class'].' d-inline" style="margin-right: 10px;"></i>'.Lang::get($menu['title']).'</a><ul class="dropdown-menu border-0 shadow">';
                        }
                        $output .= getOutput($menu['children']);
                        $output .= '</ul></li>';        
                    }
                }
            }
        }    
    }

    if($outputOthers) {
        $output .= '<li class="nav-item dropdown"><a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">'.Lang::get("Other").'</a><ul class="dropdown-menu border-0 shadow">';
        $output .= $outputOthers;
        $output .= '</ul></li>';    
    }
    return $output;
}

function getOutput($menus)
{
    $output = '';
    foreach ($menus as $menu) {
        if(count($menu['children']) == 0) {
            if($menu['nav_header'] == '1')
            {
                if((getAppearance()->layout ?? 'sidebar-mini') == 'sidebar-mini') {
                    $output .= '<li class="nav-header">'.Str::upper(Lang::get($menu['title'])).'</li>';
                }
            }
            else
            {
                $links = explode(',', $menu['link']);
                $is_active = false;
                for($i=0; $i< count($links); $i++)
                {
                    if(request()->routeIs($links[$i]))
                    {
                        $is_active = true;
                        break;
                    }
                }    
                $link = '#';
                if(count($links) > 0 && $links[0] != '')
                {
                    if(Route::has($links[0]))
                    {
                        $link = Route($links[0]);
                    }
                }
                if((getAppearance()->layout ?? 'sidebar-mini') == 'sidebar-mini') {
                    $output .= '<li class="nav-item"><a href="'.$link.'" class="nav-link '.($is_active ? 'active' : '').'"><i class="'.$menu['class'].'"></i><p>'.Lang::get($menu['title']).'</p></a></li>';    
                } else {
                    if((getAppearance()->navbar_show_icon ?? '0') == '0') {
                        $output .= '<li><a href="'.$link.'" class="dropdown-item '.($is_active ? 'active' : '').'">'.Lang::get($menu['title']).'</a></li>';    
                    } else {
                        $output .= '<li><a href="'.$link.'" class="dropdown-item '.($is_active ? 'active' : '').'"><i class="'.$menu['class'].' d-inline" style="margin-right: 10px;"></i>'.Lang::get($menu['title']).'</a></li>';    
                    }
                }
            }
        } else {
            $links = explode(',', $menu['link']);
            $is_active = false;
            for($i=0; $i< count($links); $i++)
            {
                if(request()->routeIs($links[$i]))
                {
                    $is_active = true;
                    break;
                }
            }
            if((getAppearance()->layout ?? 'sidebar-mini') == 'sidebar-mini') {
                $output .= '<li class="nav-item has-treeview '.($is_active ? 'menu-open' : '').'"><a href="#" class="nav-link '.($is_active ? 'active' : '').'"><i class="'.$menu['class'].'"></i><p>'.Lang::get($menu['title']).'<i class="right fas fa-angle-left"></i></p></a><ul class="nav nav-treeview">';
            } else {
                if((getAppearance()->navbar_show_icon ?? '0') == '0') {
                    $output .= '<li class="dropdown-submenu dropdown-hover"><a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle '.($is_active ? 'active' : '').'">'.Lang::get($menu['title']).'</a><ul class="dropdown-menu border-0 shadow">';
                } else {
                    $output .= '<li class="dropdown-submenu dropdown-hover"><a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle '.($is_active ? 'active' : '').'"><i class="'.$menu['class'].' d-inline" style="margin-right: 10px;"></i>'.Lang::get($menu['title']).'</a><ul class="dropdown-menu border-0 shadow">';
                }
            }
            $output .= getOutput($menu['children']);
            $output .= '</ul></li>';
        }
    }    
    return $output;
}

function getEnvironmentValue($key)
{

    $envFile = app()->environmentFilePath();
    $str = file_get_contents($envFile);

    if ($key != '') {
        $keyPosition = strpos($str, "{$key}=");
        $endOfLinePosition = strpos($str, "\n", $keyPosition);
        $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

        if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
            return "";
        } else {
            $data = explode('=', $oldLine);
            if(count($data) > 1) {
                $result = "";
                $search   = array("\r\n", "\n", "\r");
                $replace = '';
                for ($i=1; $i < count($data) ; $i++) { 
                    if($i == 1) {
                        $result.= str_replace($search, $replace, $data[$i]);
                    } else {
                        $result.= "=".str_replace($search, $replace, $data[$i]);
                    }
                }
                return $result;
            }
            return "";
        }
    }
    return "";
}

function getParameter($key) {
    $parameter = Parameter::where('key', $key)->first();
    if($parameter) {
        return $parameter->value;
    }

    return null;
}

function getNotifications()
{
    $user = getCurrentUser();
    return $user->unreadNotifications;
}

function getRouteTypes()
{
    $routeTypes = ["LEAVE", "OVERTIME"];
    return $routeTypes;
}

function getNotificationTypes()
{
    $notificationTypes = ["MAIL", "APPLICATION", "WHATSAPP"];
    return $notificationTypes;
}

function getNodeTypes()
{
    $nodeTypes = ["START", "APPLICANT", "APPROVER", "START_BRANCH", "END_BRANCH", "END", "NOTIFICATION"];
    return $notificationTypes;
}

function getNodeOwnerTypes()
{
    $nodeOwnerTypes = ["ALL", "EMPLOYEE", "POSITION", "POSITION_ORGANIZATION_OF_APPLICANT", "RULE", "APPLICANT"];
    return $nodeOwnerTypes;
}

function getWorkflowTrigger()
{
    $notificationTypes = ["SUBMITTED", "APPROVED", "REJECTED", "SENDBACKED", "APPROVED_END"];
    return $notificationTypes;
}

function getWorkflowRecipient()
{
    $notificationTypes = ["APPLICANT", "APPROVER", "ALL_PREV_APPROVER"];
    return $notificationTypes;
}

function formatBytes($size, $precision = 2)
{
    if ($size > 0) {
        $size = (int) $size;
        $base = log($size) / log(1024);
        $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    } else {
        return $size;
    }
}

function getUplNo()
{
    return Carbon::now()->isoFormat("YYYYMMDDkkmmss");
}

function getAge($birthDate) {
    if($birthDate) {
        $age = Carbon::parse($birthDate)->diff(Carbon::now())->y;
        return $age;
    }

    return null;
}

function hasPermission($permission) {
    $user = getCurrentUser();
    if($user) {
        return $user->can($permission);
    }

    return false;
}
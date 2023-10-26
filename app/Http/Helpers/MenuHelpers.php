<?php

namespace App\Http\Helpers;

use App\Menu;
use App\MenuAccess;
use App\StockGudang;
use Illuminate\Support\Facades\Auth;

class MenuHelpers {
    public static function Permissions(){
        $user = Auth::user();
        $access = MenuAccess::where('userid',  $user->id)->pluck('menuid');
        $menus = Menu::whereIn('id', $access)->orderBy('urutan')->get();
        $usermenu = ['Dashboard' => 'dashboard'];
        foreach($menus as $menu){
            $menuGroup = $menu->title;
            $group = $menu;
            if($menu->group != 0){
                $group = Menu::find($menu->group);
                $menuGroup = $group->title;
            }

            if($menu->group == 0){
                $val = $menu->pathname;
                if($menu->has_sub == 1){
                    $val = [];
                }
                $usermenu[$menu->title] = $val;
            } else {
                $route = $group->pathname.'.'.$menu->pathname;
                if(isset($usermenu[$menuGroup]) && is_array($usermenu[$menuGroup]))
                {
                    $usermenu[$menuGroup][$menu->title] =  $route;
                }
                else {
                    $usermenu[$menuGroup] = [
                        $menu->title => $route
                    ];
                }
            }
        }
        return $usermenu;
    }
}

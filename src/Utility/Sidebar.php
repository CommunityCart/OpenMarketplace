<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/21/17
 * Time: 5:47 PM
 */

namespace App\Utility;

class Sidebar
{
    public static $Menu = array();

    public static function setMenu($menuArray)
    {
        Sidebar::$Menu = $menuArray;
    }

    public static function addMenuGroup($menu, $role)
    {
        Sidebar::$Menu[$role][] = $menu;
    }

    public static function addMenuToMenuGroup($menu, $role, $menuGroupTitle)
    {
        for($x = 0; $x < count(Sidebar::$Menu[$role]); $x++) {

            if(Sidebar::$Menu[$role][$x]['type'] == 'group' && Sidebar::$Menu[$role][$x]['group'] == $menuGroupTitle) {

                foreach($menu as $title => $menuSet) {

                    Sidebar::$Menu[$role][$x]['menu'][$title] = $menuSet;
                }
            }
        }
    }

    public static function addSubMenuToMenuInMenuGroup($menu, $role, $menuGroupTitle, $menuTitle)
    {
        for($x = 0; $x < count(Sidebar::$Menu[$role]); $x++) {

            if(Sidebar::$Menu[$role][$x]['type'] == 'group' && Sidebar::$Menu[$role][$x]['group'] == $menuGroupTitle) {

                Sidebar::$Menu[$role][$x]['menu'][$menuTitle]['menu'] = $menu;
            }
        }
    }

    public static function buildMenu($currentPath, $role = 'visitor')
    {
        $menuHtml = '<ul id="nav-menu" class="sidebar-menu" data-api="tree" data-accordion=1 data-widget="tree">';

        foreach(Sidebar::$Menu[$role] as $menuItem)
        {
            switch($menuItem['type'])
            {
                case 'header':
                    $menuHtml .= Sidebar::buildHeader($menuItem);
                    break;
                case 'link':
                    $menuHtml .= Sidebar::buildLink($currentPath, $menuItem);
                    break;
                case 'group':
                    $menuHtml .= Sidebar::buildGroup($currentPath, $menuItem);
                    break;
            }
        }

        $menuHtml .= '</ul>';

        return $menuHtml;
    }

    private static function buildHeader($menuItem)
    {
        $header = '<li class="header">' . strtoupper($menuItem['header']) . '</li>';

        return $header;
    }

    private static function buildLink($currentPath, $menuItem)
    {
        $isActive = '';

        if ($currentPath == $menuItem['path']) {

            $isActive = 'class="active"';
        }

        $link = '<li ' . $isActive . '><a href="' . $menuItem['path'] . '"><i class="fa-left-icon fa ' . $menuItem['icon'] . '"></i><span>' . $menuItem['link'] . '</span></a></li>';

        return $link;
    }

    private static function buildGroup($currentPath, $menuItem)
    {
        if (Sidebar::isMenuActive($currentPath, $menuItem['menu'])) {

            $second_class = 'active';
            $isActive = 'active';
        } else {

            $second_class = 'non-active';
            $isActive = $menuItem['css'];
        }

        if (Sidebar::doesMenuContainSubMenus($menuItem['menu'])) {

            $isActive .= ' treeview';
        }

        $group = '';
        if (isset($menuItem['path'])) {

            $group .= '<li class="' . $isActive . '"><a href="' . $menuItem['path'] . '"><i class="fa-left-icon fa ' . $menuItem['icon'] . ' ' . $second_class . '"></i><span class="' . $second_class . '">' . $menuItem['group'] . '</span>';
        }
        else {

            $group .= '<li class="' . $isActive . '"><a href="#"><i class="fa-left-icon fa ' . $menuItem['icon'] . ' ' . $second_class . '"></i><span class="' . $second_class . '">' . $menuItem['group'] . '</span>';
        }
        $group .= '<span class="pull-right-container"></span></a>';
        $group .= '<ul class="treeview-menu">';

        foreach ($menuItem['menu'] as $item => $items) {

            $menuTitle = $item;
            $menuPath = $items['path'];
            $menuIcon = $items['icon'];

            $isActive = '';

            if ($currentPath == $items['path']) {

                $isActive = 'active';
            }

            $group .= '<li class="' . $isActive . '"><a href="' . $menuPath . '"><i class="fa-left-icon fa ' . $menuIcon . '"></i><span>' . $menuTitle . '</span></a>';


            if(isset($items['menu'])) {

                $group .= Sidebar::buildSubMenus($currentPath, $items);
            }

            $group .= '</li>';
        }

        $group .= '</ul></li>';

        return $group;
    }

    private static function buildSubMenus($currentPath, $menuItems)
    {
        $isActive = '';

        $subMenu = '<ul class="treeview-menu">';

        foreach($menuItems['menu'] as $itemKey => $itemValue) {

            if($currentPath == $itemValue['path']) {

                $isActive = 'active';
            }

            $menuTitle = $itemKey;
            $menuPath = $itemValue['path'];
            $menuIcon = $itemValue['icon'];

            $subMenu .= '<li class="' . $isActive . '"><a href="' . $menuPath . '"><i class="fa-left-icon fa ' . $menuIcon . '"></i><span>' . $menuTitle . '</span></a>';

            if(isset($itemValue['menu']) && $currentPath == $itemValue['path']) {

                $subMenu .= Sidebar::buildSubMenus($currentPath, $itemValue);
            }

            $subMenu .= '</li>';
        }

        $subMenu .= '</ul>';

        return $subMenu;
    }

    private static function doesMenuContainSubMenus($menuItems)
    {
        foreach($menuItems as $menuTitle => $menuValues) {

            if(isset($menuValues['menu'])) {

                return true;
            }
        }
    }

    private static function isMenuActive($currentPath, $menuItems)
    {
        foreach ($menuItems as $menuSet => $menuItem) {

            if (isset($menuItem['path']) && $currentPath == $menuItem['path']) {

                return true;
            }

            if (isset($menuItem['menu'])) {

                $isActive = self::isMenuActive($currentPath, $menuItem['menu']);

                if ($isActive == true) {

                    return true;
                }
            }
        }
    }
}
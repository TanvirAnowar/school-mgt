<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/18/14
 * Time: 5:46 PM
 */

class Menu {

    private static function getUserType()
    {
        $user = Authenticate::check();
        return $user->user_type;
    }

    protected static function getConfig()
    {
       return require_once 'app/config/menu.php';
    }

    public static function getMenu($data = array())
    {
        $uri = self::getUri();
        $optionAttendance = Option::getData('attendance_default');

        $config = self::getConfig();
        if(!empty($config))
        {
            if(count($data)>0)
            {
                // sub menu here
                echo '<ul class="sub" style="display:block;">';
                foreach($data as $menu => $option)
                {


                    if(!empty($option['access']))  // check that user have access to sub-route
                    {
                        $routeAccess = strtolower($option['access']);
                        $userType = strtolower(self::getUserType());
                        if(!preg_match('/'.$userType.'/',$routeAccess))
                            continue;
                    }else{
                        continue;
                    }

                    $route = explode("/",$option['route']);
                    echo '<li ';
                    if(isset($uri[1]) && ($uri[1] == $route[1]))
                        echo 'class="active"';
                    echo '>';

                    if(isset($option['child']) && (count($option['child'])>0)){
                        echo '<a href="javascript:;">'.$menu.'</a>';
                        self::getMenu($option['child']);
                    }else{
                        if(strtolower($optionAttendance) != 'automatic'){
                            if(preg_match('/automatic/',$option['route']))
                                continue;
                            echo '<a href="'.url($option['route']).'">'.$menu.'</a>';
                        }else{
                            echo '<a href="'.url($option['route']).'">'.$menu.'</a>';
                        }

                    }
                    echo '</li>';
                }
                echo '</ul>';

            }else{

                echo '<ul class="sidebar-menu" id="nav-accordion">';
                foreach($config as $menu => $option)
                {

                    if(!empty($option['access']))  // check that user have access to route
                    {
                        $routeAccess = strtolower($option['access']);
                        $userType = strtolower(self::getUserType());
                        if(!preg_match('/'.$userType.'/',$routeAccess))
                            continue;
                    }else{
                        continue;
                    }

                    if(isset($option['child']) && (count($option['child'])>0)){
                        echo '<li class="sub-menu dcjq-parent-li"><a ';
                        if(isset($uri[0]) && ($uri[0] == $option['route']))
                            echo 'class="active"';
                        echo ' href="javascript:;"><i class="fa '.$option['icon'].'"></i><span>'.$menu.'</span></a>';
                        self::getMenu($option['child']);

                    }else{
                        echo '<li><a ';
                        if(isset($uri[0]) && ($uri[0] == $option['route']))
                            echo 'class="active"';
                        echo ' href="'.url($option['route']).'"><i class="fa '.$option['icon'].'"></i><span>'.$menu.'</span></a>';
                    }

                    echo '</li>';

                }
                echo '</ul>';
            }
        }
    }

    public static function setUri($data)
    {
        Session::put('Uri',$data);
    }

    public static function getUri()
    {
        $uri = Session::get('Uri');
        if($uri != '')
        {
            return explode('/',$uri);
        }
        return 0;
    }
}

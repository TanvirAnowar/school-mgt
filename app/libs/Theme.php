<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/16/14
 * Time: 3:58 PM
 */

class Theme {

    protected static $theme = 'bucket';

    public static function make($view,$viewModel=array())
    {

        $template = 'templates.'.self::$theme;

        try{
            // For vendor specific custom changed view
            return View::make('templates.custom.'.$view, $viewModel);

        }catch(Exception $ex)
        {
            // For Default view
            return View::make($template.'.'.$view, $viewModel);
        }

    }

    public static function getLayout()
    {
        return 'templates.'.self::$theme.'.'.self::$theme;
    }

    public static function getTheme()
    {
        return Request::root() . '/public/themes/'.self::$theme.'/';
    }


} 
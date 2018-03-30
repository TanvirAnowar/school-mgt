<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/18/14
 * Time: 2:30 PM
 */

class Authenticate {



    public static function login($user,$pass)
    {

        try{
            $user =  User::where('username',$user)->where('password',md5($pass))->first();
            if($user)
            {

                Session::put('user',$user);

                return 1;
            }else{
                return 0;
            }
        }catch(Exception $e)
        {
            throw new DbConnectionException('<h3 style="text-align:center;color:tomato;">Db connection failed. Please contact with provider to check is db running?</h3>');
        }


    }


    public static function check()
    {
        $user = Session::get('user');

        if(empty($user))
        {
            header('Location:'.Request::root());
            exit();
        }
        else
        {
            return $user;
        }
    }

    public static function hasSession()
    {
        return Session::get('user');
    }

    public static function getUserType()
    {
        $user = Session::get('user');

        if(!empty($user))
        {
           return $user->user_type;
        }
        return null;
    }


} 
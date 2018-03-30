<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/13/14
 * Time: 2:38 PM
 */

class Helpers {

    /**
     * Render last query
     * @param $print
     * @return mixed
     */
    public static function LastQuery($print=1)
    {
        $queries = DB::getQueryLog();
        $last_query = end($queries);
        if($print)
            echo'<pre>'. print_r($last_query);
        else
            return $last_query;
    }

    /**
     * Debug data
     * @param $data
     * @param string $msg
     * @param int $flag
     */
    public static function debug($data,$die=0,$msg='',$flag=0)
    {
        echo '<pre>';
        echo 'Debuging...';
        if(!empty($msg))
        {
            echo '<br/>'.$msg;
        }
        echo '<br/>';

        if($flag){
            var_dump($data);
        }else{
            print_r($data);
        }

        echo '</pre>';
        if($die==1)
            die();
    }

    public static function getRequesterIP($ip = null)
    {
        if($ip != $_SERVER['REMOTE_ADDR'])
            return false;
        else{
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * set custom representation format for date or time
     * @param $format
     * @param $date
     * @return bool|string
     */
    public static function dateTimeFormat($format,$date)
    {
        return date($format,strtotime($date));
    }

    /**
     * add Success, Warning  or Error Message
     * @param $status
     * @param $msg
     * @return mixed
     */
    public static function addMessage($status,$msg)
    {
        $errorMessage = new ErrorMessage($status,$msg);
        $user = Session::get('user');

        return Session::put($user->username.'_'.$user->user_id.'_msg',$errorMessage->toArray());

    }

    /**
     * get Success, Warning or Error Message
     * @return string
     */
    public static function getMessage()
    {
        $user = Session::get('user');
        $message = Session::get($user->username.'_'.$user->user_id.'_msg');

        if(!empty($message) && $message['status'] == 200)       // for success
        {
            return '<div class="alert alert-success fade in">
                                <button type="button" class="close close-sm" data-dismiss="alert">
                                    <i class="fa fa-times"></i>
                                </button>
                                <strong>Success !</strong> '.$message['message'].'
                            </div>';
        }else if(!empty($message) && $message['status'] == 400){        // for warning
            return '<div class="alert alert-warning fade in">
                                <button type="button" class="close close-sm" data-dismiss="alert">
                                    <i class="fa fa-times"></i>
                                </button>
                                <strong>Warning!</strong> '.$message['message'].'
                            </div>';

        }else if(!empty($message) && $message['status'] == 500){       // for error
            return '<div class="alert alert-block alert-danger fade in">
                                <button type="button" class="close close-sm" data-dismiss="alert">
                                    <i class="fa fa-times"></i>
                                </button>
                                <strong>Sorry !</strong> '.$message['message'].'
            </div>';
        }
    }

    /**
     * clear any message stored in session
     * @return mixed
     */
    public static function clearMessage()
    {
        $user = Session::get('user');
        return Session::put($user->username.'_'.$user->user_id.'_msg',array());
    }


    public static function showMessage()
    {
        echo self::getMessage();
        self::clearMessage();
    }


    public static function processMessage($data,$template)
    {
        foreach ($data as $k => $arr) {
            $template = preg_replace('/{' . $k . '}/', $data[$k], $template);
        }
        return $template;
    }



} 
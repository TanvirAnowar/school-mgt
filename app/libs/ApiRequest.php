<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/6/14
 * Time: 2:39 PM
 */

class ApiRequest {

    public static $POST='POST';

    public static $GET='GET';

    public static function getApiResponse($url,$postfields,$type)
    {
        $ch = curl_init();

        if($type=='POST'){

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        }else{
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        }
        $response = trim(curl_exec($ch));

        curl_close($ch);
        return $response;
    }

} 
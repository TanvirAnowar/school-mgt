<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/10/14
 * Time: 2:58 PM
 */

class Carbon51 {

    private $client_id;
    private $key;
    public static $SMS_MASKING;
    public static $BASE;


    public function __construct(){
        $this->client_id = Config::get('sms.client_id');
        $this->key = Config::get('sms.key');
        self::$SMS_MASKING = Config::get('sms.SMS_MASKING');
        self::$BASE = Config::get('sms.base');
    }

    public function loginapi()
    {

        error_reporting(E_ALL);

        $url = self::$BASE.'authenticate';

        $postfields = '?clientid='.$this->client_id.'&key='.$this->key;
        $type="GET";
        $login = $this->getApiResponse($url, $postfields, $type);
        Session::put('api_state',$login);

        return $login;
    }
	
	public function logoutapi($accessToken)
	{
		$url = self::$BASE.'remove_access_token';
        $postfields = array('clientid'=>$this->client_id,'accesstoken'=>$accessToken,'key'=>$this->key);
        $type="POST";

		$this->getApiResponse($url, $postfields, $type);
		Session::forget('api_state');
	}

    public function hasSession()
    {
        $api_state = Session::get('api_state');
        $stateObj = json_decode($api_state);

        if(!empty($stateObj) && !empty($stateObj->expire_time)){

            if(time() > $stateObj->expire_time)
            {
                return $this->loginapi();
            }else{

                return $api_state;
            }

        }else{

            return $this->loginapi();
        }
    }


    public function getAccessToken($api_login_state){
        $stateObj = json_decode($api_login_state);
        return $stateObj->access_token;
    }

    public function getRefreshToken($accessToken)
    {
        $api_state = $this->request_refresh_token($accessToken);
        return $api_state;
    }


    public function request_access_token()
    {
        error_reporting(E_ALL);
        $url = self::$BASE.'get_access_token';
        $postfields = '?clientid='.$this->client_id.'&key='.$this->key;
        $type="GET";
        return $this->getApiResponse($url, $postfields, $type);
    }

    public function request_refresh_token($accessToken)
    {
        error_reporting(E_ALL);
        $url = self::$BASE.'get_refresh_token';
        $postfields = '?clientid='.$this->client_id.'&accesstoken='.$accessToken;
        $type="GET";
        return $this->getApiResponse($url, $postfields, $type);
    }

    public function sent_message_request($accessToken,$refreshToken,$message)
    {

        $url = self::$BASE.'save_message_to_queue';
        $postfields = array('clientid'=>$this->client_id,'accesstoken'=>$accessToken,'refreshtoken'=>$refreshToken,'message'=>$message);
        $type="POST";

        return $this->getApiResponse($url, $postfields, $type);
    }

    public function get_daily_sms_count($access_token,$date)
    {
        $url = self::$BASE.'get_client_daily_sms_count';
        $postfields = array('clientid'=>$this->client_id,'accesstoken'=>$access_token,'date'=>$date);
        $type="POST";

        return $this->getApiResponse($url,$postfields, $type);

    }



    private function getApiResponse($url,$postfields,$type)
    {
        $ch = curl_init();

        if($type=='POST'){

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        }else{

            curl_setopt($ch, CURLOPT_URL, $url.$postfields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        }
        $response = trim(curl_exec($ch));

        curl_close($ch);
        return $response;
    }
} 
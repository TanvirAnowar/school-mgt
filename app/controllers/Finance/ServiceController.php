<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/6/14
 * Time: 2:30 PM
 */

class ServiceController extends BaseController{

    public function index()
    {

    }

    /**
     * Post Action
     * @param head_name
     * @param head_type
     * @param target_amount
     * @return string
     */
    public function createHead()
    {
        $response = array();
        if(Request::isMethod('POST'))           // framework depended check , could be changeable as per framework functionality
        {
            $head_name = Input::get('head_name');
            $head_type = Input::get('head_type');
            $parent_head = Input::get('parent_head');
            $acc_type = Input::get('acc_type');
            $accountHead = AccountHead::firstOrNew(array('head_name'=>$head_name,'head_type'=>$head_type,'acc_type'=>$acc_type,'parent_head'=>$parent_head));

            if(!$accountHead->exists)
            {

                $accountHead->save();
                $response['status'] = 200;
                $response['message'] = 'Head saved success fully';
                $response['insert_id'] = $accountHead->acc_head_id;
            }else{
                $response['status'] = 400;
                $response['message'] = 'Head already exist';
            }
        }else{
            $response['status'] = 500;
            $response['message'] = 'Bad Request';
        }
        return json_encode($response);
    }

    public function getHeads()
    {
        return AccountHead::where('deleted_at',0)->get();
    }

    public function createAccount()
    {
        $response = array();
        if(Request::isMethod('post'))
        {
            $account_owner_name = Input::get('account_owner_name');
            $account_status = Input::get('account_status');
            $account_opening_balance = Input::get('account_opening_balance');
            $account_opening_date = Input::get('account_opening_date');
            $accountUser = AccountUser::firstOrNew(array('acc_name'=>$account_owner_name,'acc_type'=>$account_status));
            if(!$accountUser->exists)
            {
                $accountUser->opening_balance = $account_opening_balance;
                $accountUser->opening_date = $account_opening_date;
                $accountUser->save();
                $response['status'] = 200;
                $response['message'] = 'Head saved success fully';
                $response['insert_id'] = $accountUser->acc_user_id;
            }else{
                $response['status'] = 400;
                $response['message'] = 'Head already exist';
            }
        }else{
            $response['status'] = 500;
            $response['message'] = 'Bad Request';
        }
        return json_encode($response);
    }

    public function getAccounts()
    {
        return AccountUser::where('deleted_at',0)->get();
    }
} 
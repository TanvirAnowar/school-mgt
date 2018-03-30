<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 7/8/14
 * Time: 3:22 PM
 */

class Discussion extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "discussions";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'discussion_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('subject','details','sender_id','status','attachment');

    public function Comments()
    {
        return $this->hasMany('Comment','discussion_id')->where('type','Comment');
    }

    public function Users($users)
    {
        $userNames = array();
        foreach($users as $user)
        {
            $userObj = User::find($user);
            $userNames[] = $userObj->username;
        }
        return $userNames;
    }

} 
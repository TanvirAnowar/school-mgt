<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/6/14
 * Time: 5:32 PM
 */

class MessageGroup extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "message_groups";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'group_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('group_name','group_type','group_color');


    public function getMessageGroupDetail()
    {
       return $this->hasMany('MessageGroupDetail','group_id');
    }
} 
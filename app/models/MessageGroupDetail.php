<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/6/14
 * Time: 5:37 PM
 */

class MessageGroupDetail extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "message_group_details";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('group_id','name','number');


    public function getMessageGroup()
    {
        return $this->belongsTo('MessageGroup','group_id','group_id');
    }


} 
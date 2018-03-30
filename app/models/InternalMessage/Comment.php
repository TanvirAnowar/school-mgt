<?php

/**
 * Description of Comment
 *
 * @author Tanvir Anowar
 */
class Comment extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "comments";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'comment_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('sender_id','receiver_id','message','type','read_status','attachment');

    public function Discussion()
    {
        return $this->belongsTo('Discussion','discussion_id','discussion_id');
    }

    public function User()
    {
        return $this->belongsTo('User','sender_id','id');
    }
}

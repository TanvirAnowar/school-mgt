<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/17/14
 * Time: 2:35 PM
 */

class SmsDayLimit extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "sms_day_limit";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'sms_day_limit_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('sent_to','sent_date');
} 
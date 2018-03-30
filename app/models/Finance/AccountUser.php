<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/6/14
 * Time: 12:23 PM
 */

class AccountUser extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "acc_users";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'acc_user_id';

    /**
     * Soft delete
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('user_id', 'acc_name','acc_type','opening_balance','opening_date');
} 
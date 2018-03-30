<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/6/14
 * Time: 12:23 PM
 */

class AccountDue extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "acc_dues";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'acc_due_id';

    /**
     * Soft delete
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('acc_transaction_id','acc_transaction_code','user_id', 'due_amount', 'status');
}
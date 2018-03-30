<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/6/14
 * Time: 12:50 PM
 */

class AccountBalanceSheet extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "acc_balancesheets";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'acc_balancesheet_id';

    /**
     * Soft delete
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('user_id', 'open_date', 'end_date','details');
} 
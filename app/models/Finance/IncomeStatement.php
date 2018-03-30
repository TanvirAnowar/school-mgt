<?php
/**
 * Created by PhpStorm.
 * User: Tanvir AnowarC51
 * Date: 1/18/15
 * Time: 11:55 AM
 */

class IncomeStatement extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "income_statements";



    /**
     * @var array  only attributes that can be fill-able
     */

    protected $fillable = array('year','month','income_statement','search_by','date_from','date_to','total_expenses','total_incomes', 'total', 'profit_loss');



} 
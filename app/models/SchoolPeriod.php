<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/27/14
 * Time: 12:50 PM
 */

class SchoolPeriod extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table="period";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'period_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('period_name','class_id','section_id','period_status','period_details');

    /**
     * get list of distinct period
     * @return mixed
     */
    public static function getPeriodSuggestions()
    {
        return DB::table("period")->select('period_name')->distinct()->get();
    }



} 
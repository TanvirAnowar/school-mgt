<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/27/14
 * Time: 4:06 PM
 */

class ClassesPeriod extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table="classes_period";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'classes_period_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('period_id','class_id','section_id');


    /**
     * Get the period
     * @return mixed
     */
    public function getPeriod()
    {
        return $this->belongsTo('SchoolPeriod','period_id','period_id');
    }

    /**
     * Get the class
     * @return mixed
     */
    public function getClass()
    {
        return $this->belongsTo('SchoolClass','class_id','class_id');
    }

    /**
     * Get the section
     * @return mixed
     */
    public function getSection()
    {
        return $this->belongsTo('SchoolSection','section_id','section_id');
    }

} 
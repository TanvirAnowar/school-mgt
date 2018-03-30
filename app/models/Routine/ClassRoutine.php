<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 8/11/14
 * Time: 10:39 AM
 */

class ClassRoutine extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table="class_routine";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'routine_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('class_id','day','group_id','period_no','section_id','session','shift_id','subject_id','teacher_id');
} 
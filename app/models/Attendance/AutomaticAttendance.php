<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/16/14
 * Time: 2:56 PM
 */

class AutomaticAttendance extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "attendance_automatic";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('student_id','class_id','section_id','in','out','attendance_date','term');

} 
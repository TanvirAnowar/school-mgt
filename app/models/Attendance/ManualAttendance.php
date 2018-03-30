<?php

/**
 * Description of Attendance
 *
 * @author Tanvir Anowar
 */
class ManualAttendance extends Eloquent {

    /**
     * Table Name
     * @var string
     */
    protected $table = "attendance_manual";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('student_id','class_id','section_id','attendance_date','term');


}
    
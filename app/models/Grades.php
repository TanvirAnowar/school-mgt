<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 3/16/14
 * Time: 5:27 PM
 */

class Grades extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "grades";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'grade_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('class_id','grade','point','mark');


    /**
     * Aptitude Grades markings
     * @return array
     */
    public static function aptitudeGrades()
    {
        return array('A'=>10,'B'=>8,'C'=>6,'D'=>4,'E'=>'2','F'=>0);
    }

    /**
     * Get All possible Grades
     * @return array
     */
    public static function getGrades()
    {
        return array('A+','A-','A','B+','B','B-','C+','C','C-','D+','D','D-','E+','E','E-','F');
    }

    /**
     * Get the class for the grade settings
     * @return mixed
     */
    public function getClass()
    {
        return $this->belongsTo('SchoolClass','class_id','class_id');
    }



} 
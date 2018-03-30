<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 3/9/14
 * Time: 3:41 PM
 */

class StudentSubject extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "student_subject";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'student_subject_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('class_id','student_id','subject_id','session');


    public function getSubject()
    {
        return $this->belongsTo('SchoolSubject','subject_id','subject_id');
    }

    public static function getStudentsByClassAndSubject($classId,$subjectId)
    {
        $students = self::where('class_id',$classId)->where('subject_id',$subjectId)->get();
        $results = array();
        if(!empty($students))
        {

            foreach($students as $s)
            {
                $results[$s->student_id] = $s;
            }

        }
        return $results;
    }

    public static function getOptionalSubject($data)
    {
        $result = self::where('class_id',$data['class_id'])->where('student_id',$data['student_id'])
                                                 ->where('subject_id',$data['subject_id'])
                                                 ->where('session',$data['session'])->where('subject_status','Optional')->first();
        return $result;
    }

    public static function getOptionalSubjects($data)
    {
        $results = self::where('class_id',$data['class_id'])->where('session',$data['session'])
                            ->where('subject_status','Optional')->get();
        $optionalSubjects = array();
        if(!empty($results))
        {

            foreach($results as $result)
            {
                $optionalSubjects[$result->student_id] = $result;
            }
        }
        return $optionalSubjects;
    }
} 
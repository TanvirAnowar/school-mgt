<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 3/19/14
 * Time: 2:10 PM
 */

class CoursePlan extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "course_plan";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'course_plan_id';

    /**
     * Soft delete
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('teacher_id','subject_id','term','session','title','date','type');


    /**
     * Get the teacher for this course plan
     * @return mixed
     */
    public function getTeacher()
    {
        return $this->belongsTo('Teacher','teacher_id','id');
    }

    /**
     * Get the subject for this course plan
     * @return mixed
     */
    public function getSubject()
    {
        return $this->belongsTo('SchoolSubject','subject_id','subject_id');
    }

    /**
     * Get all course plans grouped by teacher
     * @return array
     */
    public static function getCoursePlans()
    {
       $results =  self::where('deleted_at',0)->where('session',date('Y'))->get();
       $coursePlans = array();
       if(!empty($results))
       {
           foreach($results as $i => $result)
           {
               $coursePlans[$result->teacher_id]['subjects'][$result->getSubject->subject_id] = array(
                                'subject_id' => $result->getSubject->subject_id,
                                'subject_name' => $result->getSubject->subject_name);

               $coursePlans[$result->teacher_id]['teacher_name'] = $result->getTeacher->name;
               $coursePlans[$result->teacher_id]['teacher_id'] = $result->getTeacher->id;
               $coursePlans[$result->teacher_id]['course_plan']['id'] = $result->course_plan_id;
           }
       }

        return $coursePlans;
    }

    /**
     * Get class tests by teacher, subject, term and session
     * @param $teacher_id
     * @param $subject_id
     * @param $term
     * @param $session
     * @return mixed
     */
    public static function getClassTests($teacher_id,$subject_id,$term,$session)
    {
        //Helpers::debug($teacher_id.','.$subject_id.','.$term.','.$session);
        return self::where('teacher_id',$teacher_id)
                ->where('subject_id',$subject_id)
                ->where('term',$term)
                ->where('session',$session)
                ->where('type','Class Test')->get();
    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 3/18/14
 * Time: 6:14 PM
 */

class TeacherAssign extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "teacher_assign";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'teacher_assign_id';

    /**
     * Soft delete
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('teacher_id','subject_id','section_id','class_teacher');

    /**
     * Get the teacher Info
     * @return mixed
     */
    public function getTeacher()
    {
        return $this->belongsTo('Teacher','teacher_id','id');
    }

    /**
     * Get the subject info
     * @return mixed
     */
    public function getSubject()
    {
        return $this->belongsTo('SchoolSubject','subject_id','subject_id');
    }

    /**
     * Get the Section info
     * @return mixed
     */
    public function getSection()
    {
        return $this->belongsTo('SchoolSection','section_id','section_id');
    }

    /**
     * Get all teachers by subject id
     * @param $subject_id
     * @return array
     */
    public static function getTeachers($subject_id)
    {
        $results = self::where('subject_id',$subject_id)->where('deleted_at',0)->get();

        $teachers = array();
        if(!empty($results))
        {
            foreach($results as $result)
            {
                $teachers[$result->teacher_id]['name'] = $result->getTeacher->name;
                $teachers[$result->teacher_id]['class_name'] = $result->getSection->getClass->class_name;
                $teachers[$result->teacher_id]['class_id'] = $result->getSection->getClass->class_id;
                $teachers[$result->teacher_id]['section_name'] = $result->getSection->section_name;
            }
        }

        return $teachers;
    }

} 
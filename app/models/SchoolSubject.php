<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/23/14
 * Time: 12:13 PM
 */

class SchoolSubject extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table="subject";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'subject_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('subject_name','class_id','group_id','subject_status','subject_initial','subject_dependency','subject_code');


    /**
     * Get the Class of the subject
     * @return mixed
     */
    public function getClass()
    {
        return $this->belongsTo('SchoolClass','class_id','class_id');
    }

    /**
     * Get the Group of the subject
     * @return mixed
     */
    public function getGroup()
    {
        return $this->belongsTo('SchoolGroup','group_id','group_id');
    }

    /**
     * Get the subject distinctly
     * @return mixed
     */
    public static function getSubjectSuggestions()
    {
       return DB::table("subject")->select('subject_name')->distinct()->get();
    }


} 
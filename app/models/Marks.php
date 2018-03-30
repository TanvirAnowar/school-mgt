<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/1/14
 * Time: 11:04 AM
 */

class Marks extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "marks";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'mark_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('class_id','section_id','shift_id','group_id','subject_id','term','session');

    /**
     * Get Subject for marks
     * @return mixed
     */
    public function getSubject()
    {
        return $this->belongsTo('SchoolSubject','subject_id','subject_id');
    }

    /**
     * Get the section
     * @return mixed
     */
    public function getSection()
    {
        return $this->belongsTo('SchoolSection','section_id','section_id');
    }

    /**
     * Get the Class
     * @return mixed
     */
    public function getClass()
    {
        return $this->belongsTo('SchoolClass','class_id','class_id');
    }


} 
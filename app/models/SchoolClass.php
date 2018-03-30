<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/23/14
 * Time: 10:54 AM
 */

class SchoolClass extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "classes";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'class_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('class_name','class_code','class_type');


    /**
     * Get All Sections Associated with class
     * @return mixed
     */
    public function Sections()
    {
        return $this->hasMany('SchoolSection','class_id');
    }

    /**
     * Get all Subjects Associated with class
     * @return mixed
     */
    public function Subjects()
    {
        return $this->hasMany('SchoolSubject','class_id')->orderBy('subject_order','ASC');
    }

    /**
     * Get all Grades assigned for this class
     * @return mixed
     */
    public function Grades()
    {
        return $this->hasMany('Grades','class_id')->orderBy('point', 'DESC');
    }
} 
<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/15/14
 * Time: 12:42 PM
 */

class Task extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "tasks";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'task_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('class_id','section_id','date','session');

    public function getClass()
    {
        return $this->belongsTo('SchoolClass','class_id','class_id');
    }

    public function getSection()
    {
        return $this->belongsTo('SchoolSection', 'section_id','section_id');
    }

} 
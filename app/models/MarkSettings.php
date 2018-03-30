<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 3/13/14
 * Time: 2:32 PM
 */

class MarkSettings extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "mark_settings";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'mark_settings_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('mark_type_id','subject_id','class_id');


    /**
     * Get the class for the mark settings
     * @return mixed
     */
    public function getClass()
    {
        return $this->belongsTo('SchoolClass','class_id','class_id');
    }

    /**
     * Get the subject for the mark settings
     * @return mixed
     */
    public function getSubject()
    {
        return $this->belongsTo('SchoolSubject','subject_id','subject_id');
    }

    /**
     * Get the mark type for the mark settings
     * @return mixed
     */
    public function getMarkType()
    {
        return $this->belongsTo('MarkTypes','mark_type_id','mark_type_id');
    }

} 
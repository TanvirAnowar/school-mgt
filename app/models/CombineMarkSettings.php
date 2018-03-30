<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/23/14
 * Time: 4:53 PM
 */

class CombineMarkSettings extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "combine_mark_settings";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'combine_mark_settings_id';

    /**
     * Soft delete
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('title','mark_type_id','vendor_id','class_id','subjects','pass','convert_at');

    public function getClass()
    {
        return $this->belongsTo('SchoolClass','class_id','class_id');
    }

    public function getMarkType()
    {
        return $this->belongsTo('MarkTypes','mark_type_id','mark_type_id');
    }

    public static function getSubjectNames($subjects)
    {
        $subjects = json_decode($subjects);
        if(count($subjects))
        {
            $subjectNames = array();
            foreach($subjects as $sub)
            {
                $obj = SchoolSubject::find($sub);
                $subjectNames[] = $obj->subject_name;
            }
            echo implode(',', $subjectNames);
        }
    }

} 
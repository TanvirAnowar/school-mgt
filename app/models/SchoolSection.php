<?php
/**
 * Description of SchoolSection
 *
 * @author Tanvir Anowar
 */
class SchoolSection extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table="section";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'section_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('section_name','class_id','shift_id');

    /**
     * Get specific class that associated by id
     * @return mixed
     */
    public function getClass()
    {
        return $this->belongsTo('SchoolClass','class_id','class_id');
    }

    /**
     * Get specific shift that associated by id
     * @return mixed
     */
    public function getShift()
    {
        return $this->belongsTo('SchoolShift','shift_id','shift_id');
    }
}

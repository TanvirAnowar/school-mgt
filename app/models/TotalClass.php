<?php

class TotalClass extends Eloquent{
	
	/**
     * Table Name
     * @var string
     */
    protected $table="total_class";

    

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('class_id','section_id','term','session','no_of_class');

    public function getClass()
    {
        return $this->belongsTo('SchoolClass','class_id','class_id');
    }

    public function getSection()
    {
        return $this->belongsTo('SchoolSection','section_id','section_id');
    }

}
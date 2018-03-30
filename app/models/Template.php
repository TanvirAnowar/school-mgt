<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/6/14
 * Time: 5:48 PM
 */

class Template extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "templates";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'template_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('template_name','template_type','details');

    public static function getActiveTemplate($type)
    {
        return self::where('template_type',$type)->where('status',1)->first();
    }
} 
<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/23/14
 * Time: 12:20 PM
 */

class Option extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table="option";

    /**
     * Get Data of a specific option key
     * @param $key
     * @return mixed
     */
    public static function getData($key)
    {
       return self::where('key',$key)->first()->value;
    }

    /**
     * Set Data of a specific option key
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function setData($key,$value)
    {
        return self::where('key',$key)->update(array('value'=>$value));
    }

} 
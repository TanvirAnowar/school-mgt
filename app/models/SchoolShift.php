<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/23/14
 * Time: 11:25 AM
 */

class SchoolShift extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table="shift";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'shift_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('shift_name');

} 
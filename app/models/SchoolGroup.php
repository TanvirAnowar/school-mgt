<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/23/14
 * Time: 11:25 AM
 */

class SchoolGroup extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table="group";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'group_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('group_name');

} 
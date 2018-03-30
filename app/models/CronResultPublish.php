<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/4/14
 * Time: 4:02 PM
 */

class CronResultPublish extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "cron_result_publish";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Soft delete
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('class_id','section_id','term','session','status');
} 
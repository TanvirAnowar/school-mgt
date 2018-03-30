<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 3/3/14
 * Time: 11:47 AM
 */

class AdmitTest extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table="admit_test";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'admit_test_id';



    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('exam_roll','session','details');
} 
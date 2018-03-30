<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 3/2/14
 * Time: 4:04 PM
 */

class AdmitForm extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table="admit_form";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'admit_form_id';



    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('session','name','exam_roll');

} 
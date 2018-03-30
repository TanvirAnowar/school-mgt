<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/31/14
 * Time: 4:06 PM
 */

class TeacherFinance extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "teacher_finance";



    /**
     * Soft delete
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('transaction_code','ref_no', 'head','teacher_id','invoice_number','month','amount','description');

    public function getData()
    {
        return $this->belongsTo('Teacher','teacher_id','id');
    }

} 
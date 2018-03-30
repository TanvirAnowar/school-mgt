<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/31/14
 * Time: 4:06 PM
 */

class StudentFinance extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "student_finance";



    /**
     * Soft delete
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('transaction_code','ref_no', 'head','reg_id','invoice_number','month','amount','description');

    public function getData()
    {
        $registration = Registration::where('reg_id',$this->reg_id)->first();
        return $registration;
    }
} 
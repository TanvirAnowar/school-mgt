<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/6/14
 * Time: 12:24 PM
 */

class AccountTransaction extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "acc_transactions";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'acc_transaction_id';

    /**
     * Soft delete
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('invoice_number','transaction_code','user_id','acc_type','transaction_type','amount','status');

    public static $STUDENT = 'STUDENT';
    public static $TEACHER = 'TEACHER';
    public static $MISC = 'MISC';
    public static $TYPE_INCOME = 'INCOME';
    public static $TYPE_EXPENSE = 'EXPENSE';


    public function getDetails()
    {
        switch($this->acc_type)
        {
            case self::$TEACHER:
                return TeacherFinance::where('invoice_number',$this->invoice_number)->get();
                break;
            case self::$STUDENT:
                return StudentFinance::where('invoice_number',$this->invoice_number)->get();
                break;
            case self::$MISC:
                return MiscFinance::where('invoice_number',$this->invoice_number)->get();
                break;
        }
    }


}
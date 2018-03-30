<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/6/14
 * Time: 12:23 PM
 */

class AccountHead extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "acc_heads";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'acc_head_id';

    /**
     * Soft delete
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('head_name', 'head_type','parent_head','acc_type');
} 
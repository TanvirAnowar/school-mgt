<?php

class TransactionTemplate extends Eloquent
{
	/**
     * Table Name
     * @var string
     */
    protected $table = "transaction_template";

    

    /**
     * Soft delete
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('template', 'title','acc_type');
}
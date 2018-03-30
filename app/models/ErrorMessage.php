<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/25/14
 * Time: 12:52 PM
 */

class  ErrorMessage {

    public $status;

    public $message;

    public function __construct($status,$msg)
    {
        $this->status = $status;
        $this->message = $msg;
        return $this;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

} 
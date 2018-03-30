<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/24/14
 * Time: 12:41 PM
 */

interface IPublish{
    public function update();
    public function total($subject,$subject_total);
    public function pass_fail($subject,$student_id);
}
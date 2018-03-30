<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/24/14
 * Time: 12:40 PM
 */

interface IGrades{
    public function calculateGrade($student_id,$subject,$mark,$convert_at='');
    public function calculateCGPA($student_id);
    public function getGrades();
}
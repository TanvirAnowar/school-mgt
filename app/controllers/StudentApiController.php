<?php

/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/6/14
 * Time: 2:30 PM
 */
class StudentApiController extends BaseController
{

    public function index()
    {
        return "";
    }

    public function getStudentList($offset = 0)
    {
       // if (Helpers::getRequesterIP(Config::get('app.IP')) != false) {

            $limit = 25;

            $students = Student::take($limit)->skip($offset)->orderBy('id', 'desc')->get();
            if (count($students)) {
                foreach ($students as $i => $student) {
                    $students[$i]->photo = url($student->photo);
                    $students[$i]->options = json_decode($student->options);
                }
            }
            return ($students == null) ? array('status' => '400', 'message' => 'Student unavailable.') : array('students' => json_decode($students), 'count' => Student::count(), 'status' => '200');
        }

       /* return array('invalid request');
    }*/

} 
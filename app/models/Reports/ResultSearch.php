<?php
/**
 * Created by PhpStorm.
 * User: sanzeeb
 * Date: 17-Feb-15
 * Time: 4:19 PM
 */

class ResultSearch{

    public function get_position_in_class($data)
    {
        $reportData = ReportsData::getResultForClass($data['class_id'],$data['session'],$data['term']);

       // Helpers::debug($reportData); die();
        $students = array();

        foreach($reportData as $index=>$student)
        {
            $temp_total = $student->total_mark;

            $students[] = array(
                'position' => ++$index,
                'name' => $student->name,
                'class_roll' => $student->class_roll,
                'section_name' => $student->section_name,
                'total_mark' => $temp_total,
                'cgpa' => $student->cgpa,
            );
        }

        return $students;

    }


    public function get_position_in_section($data)
    {
        $reportData = ReportsData::getResultForSection($data['class_id'],$data['section_id'],$data['session'],$data['term']);

        // Helpers::debug($reportData); die();
        $students = array();

        foreach($reportData as $index=>$student)
        {
            $temp_total = $student->total_mark;

            $students[] = array(
                'position' => ++$index,
                'name' => $student->name,
                'class_roll' => $student->class_roll,
                'section_name' => $student->section_name,
                'total_mark' => $temp_total,
                'cgpa' => $student->cgpa,
            );
        }

     /*   echo"sdfds";
        Helpers::LastQuery();
        Helpers::debug($student);
        die(); */
        return $students;

    }

    public function get_all_passed_students($data)
    {
        $reportData = ReportsData::getResultForAllPassedStudents($data['class_id'],$data['section_id'],$data['session'],$data['term']);

        // Helpers::debug($data); die();
        $students = array();

        foreach($reportData as $index=>$student)
        {
            $temp_total = $student->total_mark;

            $students[] = array(
                'name' => $student->name,
                'class_roll' => $student->class_roll,
                'section_name' => $student->section_name,
                'total_mark' => $temp_total,
                'cgpa' => $student->cgpa,
            );
        }

        /*   echo"sdfds";
           Helpers::LastQuery();
           Helpers::debug($student);
           die(); */
        return $students;

    }

    public function get_all_failed_students($data)
    {
        $reportData = ReportsData::getResultForAllFailedStudents($data['class_id'],$data['section_id'],$data['session'],$data['term']);

        // Helpers::debug($data); die();
        $students = array();

        foreach($reportData as $index=>$student)
        {
            $temp_total = $student->total_mark;

            $students[] = array(
                'name' => $student->name,
                'class_roll' => $student->class_roll,
                'section_name' => $student->section_name,
                'total_mark' => $temp_total,
            );
        }

        /*   echo"sdfds";
           Helpers::LastQuery();
           Helpers::debug($student);
           die(); */
        return $students;

    }

}
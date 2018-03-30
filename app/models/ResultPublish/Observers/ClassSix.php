<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/24/14
 * Time: 1:03 PM
 */

class ClassSix implements IPublish, IGrades{

    private $name='Six';

    private $resultPublishData;
    private $subjectsMarks;
    private $grades;
    private $total_mark;
    private $cgpa;
    private $failedSubjects;
    private $num_of_subject = 8;
    private $highestMark = array();
    private $passMark;


    public function __construct(IResultPublish $r)
    {
        $r->registerObserver($this);
        $this->resultPublishData = $r;
        $this->passMark = PassMark::getList($this->resultPublishData->getClass()->class_id);
        $this->num_of_subject = $this->countSubjects();

    }

    public function update()
    {
        // first get all possible grades for this class
        $this->getGrades();
        $termRules = Option::getData('term_rules');
       
        foreach($this->subjectsMarks as $student_id => $student)
        {

            $this->total_mark = 0;
            $this->cgpa = 0;

            $percentageRules =  json_decode($termRules);

            $percentageTotal = (!empty($percentageRules->{$student['term']}))? $percentageRules->{$student['term']} : 100;

            foreach($student['subjects'] as $subject_name => $subject)
            {

                $subject_total = array_sum($subject['types']);  // summation of marks of all mark types
                $subject_full_mark = $this->subjectsMarks[$student_id]['subjects'][$subject_name]['subject_full_mark'];

                $this->highestMark[$subject_name][$subject_total] = $subject_total;

                if($student['term'] == 'COMBINE')
                {
                    $mark = 0;

                    foreach($subject['types'] as $key => $type)
                    {
                        $mark += array_sum($type);
                        $this->subjectsMarks[$student_id]['subjects'][$subject_name]['types'][strtolower($key)] = array_sum($type);
                    }

                    $subject_total = $mark;
                }

                if($student['term'] != 'COMBINE')
                {

                    foreach($subject['types'] as $typeName => $type)
                    {
                        $this->subjectsMarks[$student_id]['subjects'][$subject_name]['percentage_types'][$typeName] = (round($type) * $percentageTotal)/100;
                    }

                    $this->subjectsMarks[$student_id]['subjects'][$subject_name]['percentage_total'] = (round($subject_total) * $percentageTotal)/100;
                }
                $subject_total = round($subject_total);

                $this->pass_fail($subject,$student_id);
                $gpa = $this->calculateGrade($student_id,$subject,$subject_total,$subject_full_mark);
                $this->total($subject,$subject_total);

                $this->subjectsMarks[$student_id]['subjects'][$subject_name]['subject_total'] = $subject_total;
                $this->subjectsMarks[$student_id]['subjects'][$subject_name]['gpa']['grade'] = $gpa['grade'];
                $this->subjectsMarks[$student_id]['subjects'][$subject_name]['gpa']['point'] = $gpa['point'];

            }

            if(!empty($student['subjects_dependent']))
            {
                foreach($student['subjects_dependent'] as $dsubject_name => $dsubject)
                {
                    /*$typeMark = 0;*/
                    foreach($dsubject['types'] as $type=> $values)
                    {
                        $this->subjectsMarks[$student_id]['subjects_dependent'][$dsubject_name]['types'][$type] = array_sum($values);
                    }

                    $subject_total = array_sum($this->subjectsMarks[$student_id]['subjects_dependent'][$dsubject_name]['types']);  // summation of marks of all mark types

                    if(is_array($dsubject['subject_full_mark']))
                    {
                        $subject_full_mark = array_sum($dsubject['subject_full_mark']);
                    }else{
                        $subject_full_mark = $dsubject['subject_full_mark'];
                    }

                    $this->subjectsMarks[$student_id]['subjects_dependent'][$dsubject_name]['subject_full_mark'] = $subject_full_mark;


                    if($student['term'] == 'COMBINE')
                    {
                        $mark = 0;

                        foreach($dsubject['types'] as $dkey => $type)
                        {
                            $mark += array_sum($type);
                            $this->subjectsMarks[$student_id]['subjects_dependent'][$dsubject_name]['types'][strtolower($dkey)] = array_sum($type);
                        }

                        $subject_total = $mark;
                    }

                    if($student['term'] != 'COMBINE')
                    {

                        foreach($dsubject['types'] as $typeName => $typeValues)
                        {
                            $this->subjectsMarks[$student_id]['subjects_dependent'][$dsubject_name]['percentage_types'][$typeName] = (round(array_sum($typeValues)) * $percentageTotal)/100;
                        }

                        $this->subjectsMarks[$student_id]['subjects_dependent'][$dsubject_name]['percentage_total'] = (round($subject_total) * $percentageTotal)/100;
                    }
                    $subject_total = round($subject_total);


                    $this->subjectsMarks[$student_id]['subjects_dependent'][$dsubject_name]['subject_total'] = $subject_total;
                    $newSubjectInstance = $this->subjectsMarks[$student_id]['subjects_dependent'][$dsubject_name];

                    $this->pass_fail($newSubjectInstance,$student_id);
                    $gpa = $this->calculateGrade($student_id,$newSubjectInstance,trim($subject_total),$subject_full_mark);
                    $this->total($newSubjectInstance,$subject_total);




                    $this->subjectsMarks[$student_id]['subjects_dependent'][$dsubject_name]['gpa']['grade'] = $gpa['grade'];
                    $this->subjectsMarks[$student_id]['subjects_dependent'][$dsubject_name]['gpa']['point'] = $gpa['point'];
                }
            }

            $cgpa = $this->calculateCGPA($student_id);
            $this->subjectsMarks[$student_id]['total'] = $this->total_mark;
            $this->subjectsMarks[$student_id]['cgpa'] = ($student['term'] == 'COMBINE')? $cgpa : '';
            $this->subjectsMarks[$student_id]['cgpa_total'] = ($student['term'] == 'COMBINE')? $this->cgpa : '';
            $this->subjectsMarks[$student_id]['failed_subject'] = (!empty($this->failedSubjects[$student_id]))? $this->failedSubjects[$student_id] : '';
            $this->subjectsMarks[$student_id]['hasFail'] = (!empty($this->failedSubjects[$student_id]))? count($this->failedSubjects[$student_id]) : 0;
        }

        foreach($this->subjectsMarks as $id=>$subject)
        {
            foreach($subject['subjects'] as $subject_name => $subject)
            {
                //if(!empty($this->highestMark[$subject_name]))
                $this->subjectsMarks[$id]['subjects'][$subject_name]['highest_mark'] = max($this->highestMark[$subject_name]);
            }
        }

        return $this->subjectsMarks;
        //Helpers::debug($this->subjectsMarks);

    }

    public function calculateGrade($student_id,$subject,$mark,$subject_full_mark='')
    {

       // Helpers::debug($subject);
        if(!empty($this->grades))
        {
            $newmark = 0;
            if(!empty($subject_full_mark))
            {
                $newmark = round(($mark*100)/ $subject_full_mark);
            }



            foreach($this->grades as $grade)
            {
                $marks = explode("-",$grade['mark']);
                if($newmark >= $marks[0] && $newmark <= $marks[1]){


                        if(!empty($this->failedSubjects[$student_id][$subject['subject_name']]))
                        {
                           $gpa = array('grade'=>'F','point'=>'0.00');
                        }else{
                           $gpa = $grade->getAttributes();
                        }


                    $gpaPoint = $gpa['point'];
                    if(!empty($subject['optional_subject']))
                    {
                        if($gpaPoint > 2)
                        {
                            $optionalGpa = ($gpaPoint - 2);
                            $gpaPoint = $optionalGpa;
                        }
                    }

                    if(!$subject['subject_dependency'])
                    {
                        $this->cgpa += $gpaPoint;
                    }
                    return $gpa;
                }
            }
        }

    }

    public function calculateCGPA($student_id)
    {
        $cgpa = number_format(($this->cgpa/$this->num_of_subject),2);

        if($cgpa > 5)
            $cgpa = '5.00';

        if(!empty($this->failedSubjects[$student_id]))
            $cgpa = '0.00';

        return $cgpa;
    }

    public function total($subject,$subject_total)
    {
        if(!$subject['subject_dependency'])
        {
            $this->total_mark += $subject_total;
        }
    }

    public function pass_fail($subject,$student_id)
    {

        if(!$subject['subject_dependency'])
        {
            if(empty($subject['optional_subject'])){
                foreach($subject['types'] as $mark_type => $value)
                {
                    if(!empty($this->passMark[$subject['subject_name']]))
                    {

                        if($value < $this->passMark[$subject['subject_name']][$mark_type]['pass'])
                        {
                            $this->failedSubjects[$student_id][$subject['subject_name']]['types'][$mark_type] = $value;
                            $this->failedSubjects[$student_id][$subject['subject_name']]['id'] = $subject['id'];
                            $this->failedSubjects[$student_id][$subject['subject_name']]['subject_name'] = $subject['subject_name'];
                        }
                    }

                }
            }

        }


    }

    public function getGrades()
    {
        $class = $this->resultPublishData->getClass();
        $this->grades = $class->Grades;
    }

    public function getName()
    {
        return $this->name;
    }

    public function countSubjects()
    {
        $subjects = $this->resultPublishData->getClass()->Subjects;
        $i = 0;
        if(!empty($subjects))
        {

            foreach($subjects as $subject)
            {
                if(!$subject->subject_dependency)
                {
                    $i++;
                }
            }
        }
        return $i;
    }

    public function setMark($mark)
    {
        $this->subjectsMarks = $mark;
        return $this;
    }
} 
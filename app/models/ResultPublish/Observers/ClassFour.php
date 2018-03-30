<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/24/14
 * Time: 1:03 PM
 */

class ClassFour implements IPublish, IGrades{

    private $name='Four';

    private $resultPublishData;
    private $subjectsMarks;
    private $grades;
    private $total_mark;
    private $cgpa;
    protected $failedSubjects;
    private $num_of_subject;
    private $highestMark = array();
    protected $currentTerm = '';
    protected $passMark;


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
            $this->currentTerm = $student['term'];
            
            foreach($student['subjects'] as $subject_name => $subject)
            {

                $subject_total = array_sum($subject['types']);  // summation of marks of all mark types
                $subject_full_mark = $this->subjectsMarks[$student_id]['subjects'][$subject_name]['subject_full_mark'];



                $this->highestMark[$subject_name][$subject_total] = $subject_total;

                if($student['term'] == 'COMBINE')
                {
                    $mark = 0;

                    foreach($subject['types'] as $type)
                    {
                        $mark += array_sum($type);
                    }

                    $subject_total = $mark;
                }

                if($student['term'] != 'COMBINE')
                {

                    $percentageRules =  json_decode($termRules);
                    $percentageTotal = (!empty($percentageRules))? $percentageRules->{$student['term']} : 100;

                    $this->subjectsMarks[$student_id]['subjects'][$subject_name]['percentage_total'] = (round($subject_total) * $percentageTotal)/100;
                }
                $subject_total = round($subject_total);

                $this->subjectsMarks[$student_id]['subjects'][$subject_name]['subject_total'] = $subject_total;
                $newSubjectInstance = $this->subjectsMarks[$student_id]['subjects'][$subject_name];
                $this->pass_fail($newSubjectInstance,$student_id);
                $gpa = $this->calculateGrade($student_id,$newSubjectInstance,$subject_total,$subject_full_mark);
                $this->total($newSubjectInstance,$subject_total);
                $this->subjectsMarks[$student_id]['subjects'][$subject_name]['gpa']['grade'] = $gpa['grade'];
                $this->subjectsMarks[$student_id]['subjects'][$subject_name]['gpa']['point'] = $gpa['point'];

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
                $this->subjectsMarks[$id]['subjects'][$subject_name]['highest_mark'] = max($this->highestMark[$subject_name]);
            }
        }

        //Helpers::debug($this->subjectsMarks);
        return $this->subjectsMarks;

        //echo json_encode($this->subjectsMarks);
    }

    public function calculateGrade($student_id,$subject,$mark,$subject_full_mark='')
    {


        if(!empty($this->grades))
        {
            $newmark = 0;
            if(!empty($subject_full_mark))
            {
                $newmark = ($mark*100)/ $subject_full_mark;
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


        if(!empty($this->passMark[$subject['subject_name']]))
        {
            $passMarkTotal = 0;
            foreach($this->passMark[$subject['subject_name']] as $type)
            {
                $passMarkTotal += $type['pass']->{$this->currentTerm};
            }
            if($subject['subject_total'] < $passMarkTotal)
            {
                $this->failedSubjects[$student_id][$subject['subject_name']] = $subject['subject_total'];
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
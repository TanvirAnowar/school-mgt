<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/24/14
 * Time: 1:15 PM
 */

class ResultPublish {


    public static function publish($searchMark)
    {
        $resultPublishData = new ResultPublishData($searchMark);
        // register class objects to result publish
        $classOne = new OrkidsOne($resultPublishData);
        $classTwo = new OrkidsTwo($resultPublishData);
        $classThree = new OrkidsThree($resultPublishData);
        $classFour = new OrkidsFour($resultPublishData);
        $classFive = new OrkidsFive($resultPublishData);
        $classSix = new ClassSix($resultPublishData);
        $classSeven = new ClassSeven($resultPublishData);
        $classEight = new ClassEight($resultPublishData);
        $classNine = new ClassNine($resultPublishData);
        $classTen = new ClassTen($resultPublishData);
        $classEleven = new ClassEleven($resultPublishData);
        $classTwelve = new ClassTwelve($resultPublishData);

        $marks = self::getMarks($searchMark);


  //     Helpers::debug($marks);die();
        $resultPublishData->setStudentMark($marks);

        $populateResult =  $resultPublishData->populateResult();
     //   Helpers::debug($populateResult,'',0,1);
        return $populateResult;

    }

    public static function getMarks($searchMark)
    {
        $data['class_id']   = $searchMark['class_id'];
        $data['section_id'] = $searchMark['section_id'];
        $data['term']       = $searchMark['term'];
        $data['session']    = $searchMark['session'];

        $termRules = Option::getData('term_rules');
        $data['percentageRules'] =  json_decode($termRules);


        if($data['term'] != 'COMBINE')
        {

            // marks processing for terminal result
            $getMarks = Marks::where('class_id',$data['class_id'])
                ->where('section_id',$data['section_id'])
                ->where('term',$data['term'])
                ->where('session',$data['session'])->get();

            if(!empty($getMarks))
            {
                $data['optionalSubjects'] = (StudentSubject::getOptionalSubjects($data));

                $studentMark = self::terminalResultsMarkProcessing($getMarks,$data);

                return $studentMark;

            }else{

                return array();

            }

        }else{


            // marks processing for combine result
            $publishedReports = ReportsData::where('class_id',$data['class_id'])
                ->where('section_id',$data['section_id'])
                ->where('term','!=','COMBINE')
                ->where('exam_year',$data['session'])->get();

            if(!empty($publishedReports))
            {
                $studentMark = self::combineResultMarkProcessing($publishedReports,$data);
                return $studentMark;
            }else{
                return array();
            }

        }

    }

    private static function terminalResultsMarkProcessing($getMarks, $options)
    {
        $studentMark = array();
        foreach($getMarks as $getMark)
        {
            $results = (json_decode($getMark->mark_details));


            foreach($results->subjects as $subject_name => $mark_types)
            {


                foreach($mark_types as $type => $marks)
                {

                    foreach($marks as $student => $mark)
                    {

                        $SchoolSubject = $getMark->getSubject;
                        $bestCountCt =  CoursePlan::where('subject_id',$SchoolSubject->subject_id)
                            ->where('session',$options['session'])
                            ->where('term',$options['term'])
                            ->where('type','Class Test')
                            ->where('details',1)->count();



                        if(!preg_match('/(class test | ct )/',strtolower($type)))
                        {
                            /* $studentMark[$student][$subject_name]['mark'][] = $mark->marks->{1}; */
                            $studentMark[$student]['subjects'][$subject_name]['types'][$type] = $mark->marks->{1};

                        }else{

                            $classTestMarks = get_object_vars($mark->marks);
                            rsort($classTestMarks);
                            $classTest =0;
                            for($i=0; $i<$bestCountCt; $i++)
                            {
                                $classTest += $classTestMarks[$i];
                            }
                            $studentMark[$student]['subjects'][$subject_name]['types'][$type] = (!empty($bestCountCt))? round($classTest/$bestCountCt) : round(array_sum($classTestMarks)/count($classTestMarks));
                            $studentMark[$student]['subjects'][$subject_name]['ct'] =$classTestMarks;
                        }



                        $studentMark[$student]['subjects'][$subject_name]['id'] = $SchoolSubject->subject_id;
                        $studentMark[$student]['subjects'][$subject_name]['highest_mark'] = '';
                        $studentMark[$student]['subjects'][$subject_name]['subject_name'] = $SchoolSubject->subject_name;
                        $studentMark[$student]['subjects'][$subject_name]['subject_status'] = $SchoolSubject->subject_status;
                        $studentMark[$student]['subjects'][$subject_name]['subject_code'] = $SchoolSubject->subject_code;
                       // $studentMark[$student]['subjects'][$subject_name]['subject_full_mark'] = $SchoolSubject->full_mark;
                        $fullMark = json_decode($SchoolSubject->full_mark);
                        
                        $full_mark = $fullMark->$options['term'];
                        if($SchoolSubject->show_pass_mark)
                        {

                            $pass_mark = json_decode($SchoolSubject->pass_mark)->$options['term'];
                            $studentMark[$student]['subjects'][$subject_name]['subject_pass_mark'] = $pass_mark;
                        
                        }

                        $studentMark[$student]['subjects'][$subject_name]['subject_full_mark'] = $full_mark;
                        $studentMark[$student]['subjects'][$subject_name]['subject_dependency'] = $SchoolSubject->subject_dependency;


                        if(!empty($options['optionalSubjects'][$student]))
                            $studentSubject = $options['optionalSubjects'][$student];

                        $studentMark[$student]['subjects'][$subject_name]['optional_subject'] = (!empty($studentSubject) && ($studentSubject->subject_id == $SchoolSubject->subject_id))? $studentSubject->getAttributes() : '';

                        if($SchoolSubject->subject_dependency)
                        {
                            $subjecName = explode(" ",$SchoolSubject->subject_name);

                            if(!preg_match('/(class test | ct )/',strtolower($type)))
                            {


                                $studentMark[$student]['subjects_dependent'][$subjecName[0]]['types'][$type][] = $mark->marks->{1};

                            }else{

                                $classTestMarks = get_object_vars($mark->marks);
                                rsort($classTestMarks);
                                $classTest =0;
                                for($i=0; $i<$bestCountCt; $i++)
                                {
                                    $classTest += $classTestMarks[$i];
                                }
                                $studentMark[$student]['subjects_dependent'][$subjecName[0]]['types'][$type][] = (!empty($bestCountCt))? round($classTest/$bestCountCt) : round(array_sum($classTestMarks)/count($classTestMarks));

                            }

                            $studentMark[$student]['subjects_dependent'][$subjecName[0]]['id'] = $SchoolSubject->subject_id;
                            $studentMark[$student]['subjects_dependent'][$subjecName[0]]['subject_name'] = $subjecName[0];
                            $studentMark[$student]['subjects_dependent'][$subjecName[0]]['subject_status'] = $SchoolSubject->subject_status;
                            $studentMark[$student]['subjects_dependent'][$subjecName[0]]['subject_code'] = $SchoolSubject->subject_code;
                         //   $studentMark[$student]['subjects_dependent'][$subjecName[0]]['subject_full_mark'][$subjecName[1]] = $SchoolSubject->full_mark;

                            $full_mark = json_decode($SchoolSubject->full_mark)->$options['term'];
                            $studentMark[$student]['subjects_dependent'][$subjecName[0]]['subject_full_mark'][$subjecName[1]]  = $full_mark;

                            $studentMark[$student]['subjects_dependent'][$subjecName[0]]['subject_dependency'] = null;

                            $studentMark[$student]['subjects'][$subject_name]['subject_dependency'] = $SchoolSubject->subject_dependency;
                        }

                        $studentMark[$student]['total'] = '';
                        $studentMark[$student]['cgpa'] = '';
                        $studentMark[$student]['term'] = $getMark->term;

                    }
                }

            }
        }

        //Helpers::debug($studentMark);die();
        return $studentMark;

    }

    private static function combineResultMarkProcessing($publishedReports,$options)
    {

        $allResults = array();
        foreach($publishedReports as $report)
        {
            $termName = trim($report->term);
            $allResults[$report->student_id][$termName] = $report;
        }

        $process = array();

        foreach($allResults as $sid=> $student)
        {

            foreach($student as $term)
            {
                $termName = trim($term->term);
                $percentageTotal = (!empty($options['percentageRules']))? $options['percentageRules']->{$term->term} : 100;
                $subjects = (!empty($term->mark_info))? json_decode($term->mark_info): array();

                foreach($subjects->subjects as $subjectName => $subject)
                {

                    foreach($subject->types as $typeName => $type)
                    {
                        $subject_total[] = (($type * $percentageTotal)/100);
                        $process[$sid]['subjects'][$subjectName]['types'][$typeName][$termName] = (($type * $percentageTotal)/100);

                    }
                    $process[$sid]['subjects'][$subjectName]['subject_total'][$termName] = $subject->percentage_total;
                    $process[$sid]['subjects'][$subjectName]['id'] = $subject->id;
                    $process[$sid]['subjects'][$subjectName]['subject_name'] = $subject->subject_name;
                    $process[$sid]['subjects'][$subjectName]['subject_status'] = $subject->subject_status;
                    $process[$sid]['subjects'][$subjectName]['subject_code'] = $subject->subject_code;
                   // $full_mark = json_decode($SchoolSubject->full_mark)->$options['term'];
                    $process[$sid]['subjects'][$subjectName]['subject_full_mark'] = $subject->subject_full_mark;
                    $process[$sid]['subjects'][$subjectName]['subject_dependency'] = $subject->subject_dependency;
                    $process[$sid]['subjects'][$subjectName]['optional_subject'] = $subject->optional_subject;
                    $process[$sid]['subjects'][$subjectName]['term'] = 'COMBINE';

                }

                if(!empty($subjects->subjects_dependent)){
                    foreach($subjects->subjects_dependent as $subjectName => $subject)
                    {

                        foreach($subject->types as $typeName => $type)
                        {
                            $subject_total[] = (($type * $percentageTotal)/100);
                            $process[$sid]['subjects_dependent'][$subjectName]['types'][$typeName][$termName] = (($type * $percentageTotal)/100);

                        }
                        $process[$sid]['subjects_dependent'][$subjectName]['subject_total'][$termName] = $subject->percentage_total;
                        $process[$sid]['subjects_dependent'][$subjectName]['id'] = $subject->id;
                        $process[$sid]['subjects_dependent'][$subjectName]['subject_name'] = $subject->subject_name;
                        $process[$sid]['subjects_dependent'][$subjectName]['subject_status'] = $subject->subject_status;
                        $process[$sid]['subjects_dependent'][$subjectName]['subject_code'] = $subject->subject_code;
                        $process[$sid]['subjects_dependent'][$subjectName]['subject_full_mark'] = $subject->subject_full_mark;
                        $process[$sid]['subjects_dependent'][$subjectName]['subject_dependency'] = $subject->subject_dependency;
                        //$process[$sid]['subjects_dependent'][$subjectName]['optional_subject'] = $subject->optional_subject;
                        $process[$sid]['subjects_dependent'][$subjectName]['term'] = 'COMBINE';

                    }
                }
                    $process[$sid]['term'] = 'COMBINE';

            }
        }
        //Helpers::debug($process);die();
        return $process;

    }

} 
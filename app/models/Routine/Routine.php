<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 8/10/14
 * Time: 11:16 AM
 */

class Routine {

    /**
     * Get Class Period
     * @param $classId
     * @param $sectionId
     * @return mixed
     */
    public static function getClassPeriod($classId, $sectionId)
    {
        $classObj = SchoolClass::find($classId);
        $sectionObj = SchoolSection::find($sectionId);
        if(empty($classId) || empty($sectionId))
        {
            return array();
        }
        $classesPeriod = ClassesPeriod::where('class_id',$classObj->class_id)
                                        ->where('section_id',$sectionObj->section_id)
                                        ->first();
        if(!count($classesPeriod))
            return array();
        $classesPeriod->getPeriod;
        $periods = json_decode($classesPeriod->getPeriod->period_details);
        $classesPeriod->periods = array();
        $days = array('Sat','Sun','Mon','Tue','Wed','Thu','Fri');
        $periodsData = array();
        foreach($days as $d=> $day)
        {
            for($i=1; $i<=$periods->periodCount; $i++)
            {
                 $classRoutine = ClassRoutine::where('class_id',$classId)
                               ->where('section_id',$sectionId)
                               ->where('day',$day)->where('period_no',$i)->first();
                if(count($classRoutine))
                {
                    $teacherID = $classRoutine->teacher_id;
                    $subjectID = $classRoutine->subject_id;
                    $teacher = Teacher::find($teacherID);
                    $subject = SchoolSubject::find($subjectID);
                    $periodsData[$day.'_'.$i] = array(
                        'teacher'=>$teacher->getAttributes(),
                        'subject'=>$subject->getAttributes(),
                        'routine' => $classRoutine->getAttributes()
                    );
                }else{
                    $periodsData[$day.'_'.$i] = array();
                }
               // Helpers::debug($teacherID,'',0,1);
            }
        }
        $classesPeriod->periods = $periodsData;


        //Helpers::debug($classesPeriod,'',0,1);

        return $classesPeriod;
    }


    /**
     * Is Teacher Busy
     * @param $teacherId
     * @param $periodDay
     * @param $periodNo
     * @return mixed
     */
    public static function isTeacherBusy($teacherId,$periodDay,$periodNo)
    {
        return ClassRoutine::where('teacher_id',$teacherId)
            ->where('day',$periodDay)
            ->where('period_no',$periodNo)->get();
    }

    /**
     * Is Teacher already assigned for this params
     * @param $classId
     * @param $sectionId
     * @param $subjectId
     * @param $teacherId
     * @param $periodDay
     * @param $periodNo
     * @return mixed
     */
    public static function isTeacherExist($classId,$sectionId,$subjectId,$teacherId,$periodDay,$periodNo)
    {
        return ClassRoutine::where('class_id',$classId)
            ->where('section_id',$sectionId)
            ->where('subject_id',$subjectId)
            ->where('teacher_id',$teacherId)
            ->where('day',$periodDay)
            ->where('period_no',$periodNo)->get();
    }

    /**
     * Is Record Exist for this params
     * @param $classId
     * @param $sectionId
     * @param $subjectId
     * @param $periodDay
     * @param $periodNo
     * @return mixed
     */
    public static function isRoutineExist($classId,$sectionId,$subjectId,$periodDay,$periodNo)
    {
        return ClassRoutine::where('class_id',$classId)
                        ->where('section_id',$sectionId)
                        ->where('subject_id',$subjectId)
                        ->where('day',$periodDay)
                        ->where('period_no',$periodNo)->get();
    }
} 
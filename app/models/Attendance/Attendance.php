<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/16/14
 * Time: 2:56 PM
 */


class Attendance {

    private $currentState;
    private $attendanceSettings;

    public function __construct()
    {
       $this->attendanceSettings =  Option::getData('attendance_default');
       if($this->attendanceSettings == 'Automatic')
       {
          $this->currentState = new AutomaticAttendance();

       }else{

          $this->currentState = new ManualAttendance();

       }
    }

    public function getAttendance($registrations,$date)
    {
        if($this->attendanceSettings == 'Automatic')
        {
            foreach($registrations as $i=> $reg){
                $attendance = $this->currentState->where('student_id',$reg->sid)->where('attendance_date',$date)->first();

                $registrations[$i]['attendance_id'] = (!empty($attendance))? $attendance->id : '0';

            }
            return array('type'=>'Automatic','attendance'=>$registrations);

        }else{

            foreach($registrations as $i=> $reg){
                $attendance = $this->currentState->where('student_id',$reg->sid)->where('attendance_date',$date)->first();

                $registrations[$i]['attendance_id'] = (!empty($attendance))? $attendance->id : '0';

            }
            return array('type'=>'Manual','attendance'=>$registrations);
        }
        return array();
    }

    public function countAttendance($studentId,$term)
    {
        if($this->attendanceSettings == "Automatic")
        {
            
            $attendanceCount = $this->currentState->where('student_id',$studentId)->where('term',$term)->count();
            
            return array('type' => 'Automatic','attendance'=>$attendanceCount);

        }else{

            $attendanceCount = $this->currentState->where('student_id',$studentId)->where('term',$term)->count();

            return array('type' => 'Manual','attendance'=>$attendanceCount);

        }
    }


    public function addData($id,$class_id,$section_id,$attendance_date,$term,$in=0,$out=0)
    {
        if($this->attendanceSettings == 'Automatic')
        {
            $this->currentState->student_id = $id;
            $this->currentState->class_id = $class_id;
            $this->currentState->section_id = $section_id;
            $this->currentState->in = $in;
            $this->currentState->out = $out;
            $this->currentState->attendance_date = $attendance_date;
            $this->currentState->term = $term;
            $this->currentState->save();
            return $this->currentState->id;

        }else{
           $this->currentState->student_id = $id;
           $this->currentState->class_id = $class_id;
           $this->currentState->section_id = $section_id;
           $this->currentState->attendance_date = $attendance_date;
           $this->currentState->term = $term;
           $this->currentState->save();
           return $this->currentState->id;
        }
    }

    public function updateData($id,$class_id,$section_id,$attendance_date,$in=0,$out=0)
    {
        if($this->attendanceSettings == 'Automatic')
        {
            $this->currentState->where('student_id',$id)
                                ->where('class_id',$class_id)
                                ->where('section_id',$section_id)
                                ->where('in',$in)->where('attendance_date',$attendance_date)->update(array('out'=>$out));

            return $this->currentState->id;

        }else{
            // nothing to update
            /*$this->currentState->student_id = $id;
            $this->currentState->class_id = $class_id;
            $this->currentState->section_id = $section_id;
            $this->currentState->attendance_date = $attendance_date;
            $this->currentState->save();
            return $this->currentState->id;*/
        }
    }

    public function checkData($id,$class_id,$section_id,$attendance_date)
    {
        return $this->currentState->where('student_id', $id)
            ->where('class_id', $class_id)
            ->where('section_id',$section_id)
            ->where('attendance_date', $attendance_date)->count();
    }

    public function removeData($id,$class_id,$section_id,$attendance_date)
    {
        if($this->attendanceSettings == 'Automatic')
        {

            return $this->currentState->where('student_id', $id)
                ->where('class_id', $class_id)
                ->where('section_id',$section_id)
                ->where('attendance_date', $attendance_date)->delete();

        }else{
           return $this->currentState->where('student_id', $id)
                                ->where('class_id', $class_id)
                                ->where('section_id',$section_id)
                                ->where('attendance_date', $attendance_date)->delete();


        }
    }


    
} 
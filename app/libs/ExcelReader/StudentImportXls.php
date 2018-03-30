<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 6/4/14
 * Time: 10:03 AM
 */

class StudentImportXls {

    /**
     * Current Excel Sheet
     * @var array
     */
    private $currentSheet;

    /**
     * Contain records of excel sheet
     * @var array
     */
    private $rows;

    /**
     * Caption from spreadsheet
     * @var array
     */
    private $captions;


    public function __construct($currentSheet)
    {
        $this->currentSheet = $currentSheet;
        $this->rows         = $currentSheet['cells'];
        $this->captions     = $this->currentSheet['cells'][1];
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function getIndex()
    {


        foreach($this->captions as $captionkey=>  $caption)
        {




        }
        Helpers::debug($this->captions);
        die();
    }

    public function SaveStudent($shiftId)
    {
        $data = array();

        if(!empty($this->rows))
        {
            foreach($this->rows as $i => $row)
            {
                if($i>1 && !empty($row[3]) && !empty($row[2]))
                {


                    $classObj = SchoolClass::where('class_code',trim($row[2]))->first();


                    $sectionObj = SchoolSection::where('class_id',$classObj->class_id)
                        ->where('section_name',trim($row[3]))
                        ->where('shift_id',$shiftId)->first();


                    if(!count($classObj) || !count($sectionObj))
                    {


                        $data[$i]['name'] = (!empty($row[1]))? trim($row[1]) : '';
                        $data[$i]['status'] = 0;
                        $data[$i]['class_code'] = (!empty($row[2]))? trim($row[2]) : '';
                        $data[$i]['class'] = '';
                        $data[$i]['given_section'] = (!empty($row[3]))? trim($row[3]) : '';
                        $data[$i]['section'] = '';
                        $data[$i]['phone'] = (!empty($row[4]))? trim($row[4]) : '';
                        continue;

                    }

                    $studentObj = new Student();
                    $studentObj->class_id = $classObj->class_id;
                    $studentObj->section_id = $sectionObj->section_id;
                    $studentObj->name = (!empty($row[1]))? trim($row[1]) : '';
                    $studentObj->student_id = strtolower(str_replace(" ", "_",trim($studentObj->name)));
                    $mobileNumber = (!empty($row[4]))? trim($row[4]) : '';
                    $studentObj->father_cell_phone = (preg_match('/^0+/',$mobileNumber))? $mobileNumber : '0'.$mobileNumber;
                    $studentObj->student_type = 'New';

                    $user = User::firstOrNew(array('username'=>$studentObj->student_id));

                    $data[$i]['name'] = $studentObj->name;
                    $data[$i]['class_code'] = (!empty($row[2]))? trim($row[2]) : '';
                    $data[$i]['class'] = $classObj->class_name;
                    $data[$i]['given_section'] = (!empty($row[3]))? trim($row[3]) : '';
                    $data[$i]['section'] = $sectionObj->section_name;
                    $data[$i]['phone'] = $studentObj->father_cell_phone;


                    if(!$user->exists)
                    {

                        if($studentObj->name && (strlen($studentObj->father_cell_phone)== 11))
                        {
                            $data[$i]['status'] = 1;
                            $studentObj->save();

                            if($studentObj->id)
                            {
                                    $user->user_id = $studentObj->id;
                                    $user->username = $studentObj->student_id;
                                    $user->password = md5($studentObj->student_id);
                                    $user->user_type = 'Student';
                                    $user->user_status = 1;
                                    $user->save();
                            }
                            Helpers::addMessage(200,' Students Inserted');
                        }else{
                            $data[$i]['status'] = 0;
                        }
                    }else{
                        $data[$i]['status'] = 2;
                    }


                }
            }

            return $data;
        }else{
            return 0;
        }
    }


    public function SaveImportStudent($bs,$ds,$br,$dr)
    {
        $data = array();
        $success = $failed = 0; 

        if(!empty($this->rows))
        {
            $classIndex = (!empty($br['class_id']) && $br['class_id'] != "null") ? $br['class_id'] : '';
            $sectionIndex = (!empty($br['section_id']) && $br['section_id'] != "null") ? $br['section_id'] : '';
            $shiftIndex = (!empty($br['shift_id']) && $br['shift_id'] != "null") ? $br['shift_id'] : '';
            $groupIndex = (!empty($br['group_id']) && $br['group_id'] != "null") ? $br['group_id'] : '';
            $sessionIndex = (!empty($br['session']) && $br['session'] != "null") ? $br['session'] : '';
            $classRollIndex = (!empty($br['class_roll']) && $br['class_roll'] != "null") ? $br['class_roll'] : '';

            $studentIdIndex  = (!empty($bs['student_id']) && $bs['student_id'] != "null")? $bs['student_id'] : '';
            $studentNameIndex = (!empty($bs['name']) && $bs['name'] != "null")? $bs['name'] : '';
            $studentNationalityIndex = (!empty($bs['nationality']) && $bs['nationality'] != "null")? $bs['nationality'] : '';
            $studentDobIndex = (!empty($bs['dob']) && $bs['dob'] != "null")? $bs['dob'] : '';
            $studentBGIndex = (!empty($bs['blood_group']) && $bs['blood_group'] != "null")? $bs['blood_group'] : '';
            $studentGenderIndex = (!empty($bs['gender']) && $bs['gender'] != "null")? $bs['gender'] : '';
            $studentReligionIndex = (!empty($bs['religion']) && $bs['religion'] != "null")? $bs['religion'] : '';
            $studentPhotoIndex = (!empty($bs['photo']) && $bs['photo'] != "null")? $bs['photo'] : '';
            $motherNameIndex = (!empty($bs['mother_name']) && $bs['mother_name'] != "null")? $bs['mother_name'] : '';
            $motherProfessionIndex = (!empty($bs['mother_profession']) && $bs['mother_profession'] != "null")? $bs['mother_profession'] : '';
            $motherCellPhoneIndex = (!empty($bs['mother_cell_phone']) && $bs['mother_cell_phone'] != "null")? $bs['mother_cell_phone'] : '';
            $fatherNameIndex = (!empty($bs['father_name']) && $bs['father_name'] != "null")? $bs['father_name'] : '';
            $fatherProfessionIndex = (!empty($bs['father_profession']) && $bs['father_profession'] != "null")? $bs['father_profession'] : '';
            $fatherCellPhoneIndex = (!empty($bs['father_cell_phone']) && $bs['father_cell_phone'] != "null")? $bs['father_cell_phone'] : '';
            $presentAddressIndex   = (!empty($bs['present_address']) && $bs['present_address'] != "null")? $bs['present_address'] : '';
            $permanentAddressIndex = (!empty($bs['permanent_address']) && $bs['permanent_address'] != "null")? $bs['permanent_address'] : '';


            foreach($this->rows as $i => $row)
            {
                if($i>1 && !empty($row[3]) && !empty($row[2]))
                {

                    $classObj = SchoolClass::where('class_code',trim($row[$classIndex]))->first();
                    $shiftObj = SchoolShift::where('shift_name',trim($row[$shiftIndex]))->first();

                    $sectionObj = SchoolSection::where('class_id',$classObj->class_id)
                        ->where('section_name',trim($row[$sectionIndex]))
                        ->where('shift_id',$shiftObj->shift_id)->first();
                    $groupObj = SchoolGroup::where('group_name',trim($row[$groupIndex]))->first();    
                    $subjects = SchoolSubject::where('class_id',$classObj->class_id)
                                                        ->where('group_id',$groupObj->group_id)
                                                        ->get();

                    if(!count($classObj) || !count($sectionObj) || !count($shiftObj) || !count($groupObj))
                    {


                        /*$data[$i]['name'] = (!empty($row[1]))? trim($row[1]) : '';
                        $data[$i]['status'] = 0;
                        $data[$i]['class_code'] = (!empty($row[2]))? trim($row[2]) : '';
                        $data[$i]['class'] = '';
                        $data[$i]['given_section'] = (!empty($row[3]))? trim($row[3]) : '';
                        $data[$i]['section'] = '';
                        $data[$i]['phone'] = (!empty($row[4]))? trim($row[4]) : '';*/
                        continue;

                    }

                    $studentObj = new Student();
                    $studentObj->class_id = $classObj->class_id;
                    $studentObj->section_id = $sectionObj->section_id;
                    $studentObj->name = (!empty($row[$studentNameIndex]))? trim($row[$studentNameIndex]) : '';
                    $studentObj->student_id = (!empty($row[$studentIdIndex]))? trim($row[$studentIdIndex]) : '';;
                    $mobileNumber = (!empty($row[$fatherCellPhoneIndex]))? trim($row[$fatherCellPhoneIndex]) : '';
                    $studentObj->mother_name = (!empty($row[$motherNameIndex]))? trim($row[$motherNameIndex]) : '';
                    $studentObj->mother_profession = (!empty($row[$motherProfessionIndex]))? trim($row[$motherProfessionIndex]) : '';
                    $studentObj->mother_cell_phone = (!empty($row[$motherCellPhoneIndex])) ? trim($row[$motherCellPhoneIndex]) : '';
                    $studentObj->father_name = (!empty($row[$fatherNameIndex])) ? trim($row[$fatherNameIndex]) : '';
                    $studentObj->father_profession = (!empty($row[$fatherProfessionIndex])) ? trim($row[$fatherProfessionIndex]) : '';
                    $studentObj->father_cell_phone = (preg_match('/^0+/',$mobileNumber))? $mobileNumber : '0'.$mobileNumber;
                    $studentObj->student_type = 'New';
                    $studentObj->nationality = (!empty($row[$studentNationalityIndex])) ? trim($row[$studentNationalityIndex]) : '';
                    $dob = (!empty($row[$studentDobIndex]))? trim($row[$studentDobIndex]) : '';
                    $filterdob = '';
                    if(preg_match('/\//',$dob))
                    {
                        $dobs = explode("/",$dob);
                        $filterdob = $dobs[2].'-'.$dobs[0].'-'.$dobs[1];
                    }else{
                        $filterdob = strtotime($dob);
                    }
                    
                   // Helpers::debug($filterdob,1);
                    $filterdob = date("Y-m-d",strtotime($filterdob));
                    
                    $studentObj->dob = (!empty($filterdob))? $filterdob : '';
                    $studentObj->blood_group = (!empty($row[$studentBGIndex])) ? trim($row[$studentBGIndex]) : '';
                    $studentObj->religion = (!empty($row[$studentReligionIndex]))? trim($row[$studentReligionIndex]) : '';
                    $studentObj->gender = (!empty($row[$studentGenderIndex])) ? trim($row[$studentBGIndex]) : '';
                    $studentObj->photo  = (!empty($row[$studentPhotoIndex])) ? trim($row[$studentPhotoIndex]) : ''; 

                    $user = User::firstOrNew(array('username'=>$studentObj->student_id));

                    /*$data[$i]['name'] = $studentObj->name;
                    $data[$i]['class_code'] = (!empty($row[2]))? trim($row[2]) : '';
                    $data[$i]['class'] = $classObj->class_name;
                    $data[$i]['given_section'] = (!empty($row[3]))? trim($row[3]) : '';
                    $data[$i]['section'] = $sectionObj->section_name;
                    $data[$i]['phone'] = $studentObj->father_cell_phone;*/


                    if(!$user->exists)
                    {
                         //Helpers::debug($row[$studentNameIndex],1);

                        if($studentObj->name && (strlen($studentObj->father_cell_phone)== 11))
                        {
                           
                            $studentObj->save();

                            if($studentObj->id)
                            {
                                    $user->user_id = $studentObj->id;
                                    $user->username = $studentObj->student_id;
                                    $user->password = md5($studentObj->student_id);
                                    $user->user_type = 'Student';
                                    $user->user_status = 1;
                                    $user->save();
                                    $session = (!empty($row[$sessionIndex]))? trim($row[$sessionIndex]) : date('Y');
                                    $registration = Registration::firstOrNew(array('session'=>$session,'reg_id'=>$session.'_'.$studentObj->id,'deleted_at'=>0));
                                    if(!$registration->exists)
                                    {
                                        $registration->student_id = $studentObj->id;
                                        $registration->class_id = $classObj->class_id;
                                        $registration->section_id = $sectionObj->section_id;
                                        $registration->shift_id = $shiftObj->shift_id;
                                        $registration->group_id = $groupObj->group_id;
                                        $registration->class_roll = (!empty($row[$classRollIndex]))? trim($row[$classRollIndex]) : '';
                                        $registration->promotion_status = 'Running';
                                        $registration->deleted_at = 0;
                                        $registration->save();

                                        if($registration->id)
                                        {
                                            Student::where('id',$studentObj->id)->update(array('student_type'=>'Running'));

                                            if(count($subjects)){
                                                foreach($subjects as $k => $subject)
                                                {
                                                  $studentSubject = StudentSubject::firstOrNew(array('class_id'=>$classObj->class_id,'student_id'=>$studentObj->id,'subject_id'=>$subject->subject_id,'session'=>$session));
                                                  $studentSubject->subject_status = 'Compulsory';

                                                  $studentSubject->save();
                                                }
                                            }
                                        }
                                        

                                    }
                            }

                            $success++;
                        }else{
                          $failed++;  
                        }

                    }else{

                        $failed++;
                    }


                }
            }

            $data['success']=$success;
            $data['failed']=$failed;
            return $data;
        }else{
            return 0;
        }
    }

} 
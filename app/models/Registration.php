<?php

/**
 * Description of RegisteredStudent
 *
 * @author Tanvir Anowar
 */
class Registration extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "registration";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('student_id','session','reg_id');

    /**
     * Get the Student
     * @return mixed
     */
    public function getStudent()
    {
        return $this->belongsTo('Student','student_id','id');
    }

    /**
     * Get the Class
     * @return mixed
     */
    public function getClass()
    {
        return $this->belongsTo('SchoolClass','class_id','class_id');
    }

    /**
     * Get the Section
     * @return mixed
     */
    public function getSection()
    {
        return $this->belongsTo('SchoolSection','section_id','section_id');
    }

    /**
     * Get the Shift
     * @return mixed
     */
    public function getShift()
    {
        return $this->belongsTo('SchoolShift','shift_id','shift_id');
    }

    /**
     * Get the Group
     * @return mixed
     */
    public function getGroup()
    {
        return $this->belongsTo('SchoolGroup','group_id','group_id');
    }

    /**
     * Get Subjects List that assigned to a student
     * @return mixed
     */
    public function StudentSubjects()
    {
        return $this->hasMany('StudentSubject','student_id','student_id');
    }

    /**
     * Search Registration of students
     * @param array $data
     * @param string $type
     * @return array|string
     */
    public static function searchRegistration($data,$type="json")
    {
        $where = self::with('getStudent','getClass','getSection','getShift','getGroup')->where('session',$data['session']);

        if(!empty($data['class_id']))
            $where->where('class_id',$data['class_id']);

        if(!empty($data['section_id']))
            $where->where('section_id',$data['section_id']);

        if(!empty($data['shift_id']))
            $where->where('shift_id',$data['shift_id']);

        if(!empty($data['class_roll']))
            $where->where('class_roll',$data['class_roll']);

        $where->where('deleted_at',0);
        $where->orderBy('class_roll','ASC');
        $results = $where->get();
        $registrations = array();
        if(!empty($results))
        {
            foreach($results as $i => $r)
            {
                $student = $r->getStudent;
                $class = $r->getClass;
                $shift = $r->getShift;
                $group = $r->getGroup;
                $section = $r->getSection;

                $results[$i]['name']               = $student->name;
                $results[$i]['sid']                = $student->id;
                $results[$i]['student_id']         = $student->student_id;
                $results[$i]['father_cell_number'] = $student->father_cell_phone;
                $results[$i]['mother_cell_number'] = $student->mother_cell_phone;
                $results[$i]['class_name']         = $class->class_name;
                $results[$i]['section_name']       = $section->section_name;
                $results[$i]['shift_name']         = $shift->shift_name;
                $results[$i]['group_name']         = $group->group_name;
            }
            $registrations = $results;
        }


        if($type=="json")
        {

            return count($registrations)? $registrations->toJson() : json_encode(array());
        }
        else
            return $registrations;

    }

    /**
     * Get the student list of a class for giving their subject's mark
     * @param $session
     * @param $classId
     * @param $sectionId
     * @param $shiftId
     * @param $subjectId
     * @param null $term
     * @return array
     */
    public static function getStudentsForMark($session,$classId,$sectionId,$shiftId,$subjectId,$term=null)
    {

        $registeredStudents = self::searchRegistration(array(
            'session' => $session,
            'class_id'   => $classId,
            'section_id' => $sectionId,
            'shift_id'   => $shiftId,
            'deleted_at' => 0
        ),'');

        $studentSubjects = StudentSubject::getStudentsByClassAndSubject($classId,$subjectId);

        $results = array();
        if(!empty($registeredStudents))
        {

            foreach($registeredStudents as $reg)
            {

                if(!empty($studentSubjects[$reg->sid]))
                    $results[] = $reg;
            }
        }

        return $results;

    }

    /**
     * Get the list of ids only of subject taken by a student
     * @param $class_id
     * @param $student_id
     * @return array
     */
    public function studentSubjectsIds($class_id,$student_id)
    {
        $results = StudentSubject::where('class_id',$class_id)->where('student_id',$student_id)->get();
        $ids = array();
        if(!empty($results))
        {
            foreach($results as $r)
            {
                $ids[] = $r->subject_id;
            }
        }

        return $ids;
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 8/7/14
 * Time: 3:18 PM
 */

class RoutineController extends BaseController{

    protected $layout;
    protected $default_route;
    protected $_userSession;

    public function __construct() {

        parent::__construct();
        $this->default_route = 'dashboard/index';
        $this->_userSession = Authenticate::check();

        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }

    public function getPrevDay()
    {
        if(Request::isMethod('post'))
        {
            $time = Input::get('prev');
            $url = Input::get('url');
            Session::put('current',$time);
            return Redirect::to($url);
        }else{
            Helpers::addMessage(500, " Bad Request");
            return Redirect::to('/');
        }
    }

    public function getNextDay()
    {
        if(Request::isMethod('post'))
        {
            $time = Input::get('next');
            $url = Input::get('url');
            Session::put('current',$time);
            return Redirect::to($url);
        }else{
            Helpers::addMessage(500, " Bad Request");
            return Redirect::to('/');
        }

    }

    public function getPeriod()
    {
        if(Request::ajax())
        {
            $classId   = Input::get('classId');
            $sectionId = Input::get('sectionId');
            return Routine::getClassPeriod($classId,$sectionId);
        }
        exit(1);
    }

    public function getTeacherByClassSection()
    {
        if(Request::ajax())
        {
            $classId   = Input::get('classId');
            $sectionId = Input::get('sectionId');
            return TeacherAssign::getTeacherByClassSection($classId,$sectionId);
        }
        exit(1);
    }

    public function getAssignedTeacherBySubject()
    {
        if(Request::ajax())
        {
            $subject_id = Input::get('subject_id');
            return TeacherAssign::getTeachers($subject_id);
        }else{
            return Redirect::to($this->default_route);
        }
    }

    public function saveSchedule()
    {
        if(Request::isMethod('post'))
        {
            $postData = Input::all();

            $subject_id = $postData['subject'];
            $teacher_id = $postData['teacher'];
            $class_id   = $postData['class_id'];
            $section_id = $postData['section_id'];
            $period_no  = $postData['period_no'];
            $period_day = $postData['period_day'];

            // check teacher already assigned for a class, section , subject, period_no, period_day
            $recordExist = Routine::isRoutineExist($class_id,$section_id,$subject_id,$period_day,$period_no);
            $teacherBusy = Routine::isTeacherBusy($teacher_id,$period_day,$period_no);
            $teacherAlreadyAssigned = Routine::isTeacherExist($class_id,$section_id,$subject_id,$teacher_id,$period_day,$period_no);

            if((!count($teacherAlreadyAssigned)) && (!count($teacherBusy)) && (!count($recordExist)))
            {
                $classRoutine = new ClassRoutine(array(
                    'class_id'   => $class_id,
                    'section_id' => $section_id,
                    'day'        => $period_day,
                    'period_no'  => $period_no,
                    'subject_id' => $subject_id,
                    'teacher_id' => $teacher_id,
                    'session'    => date('Y')
                ));
                $classRoutine->save();
                return array('status'=>200,'msg'=>'Successfully Added','data'=>$classRoutine);
            }else{
                if(count($teacherAlreadyAssigned))
                    return array('status'=>400,'msg'=>'Teacher already assigned to this period');
                if(count($teacherBusy))
                    return array('status'=>400,'msg'=>'Teacher Already assigned for another class/section in this period');
                if(count($recordExist))
                    return array('status'=>400, 'msg'=>'Another Teacher Assigned for this Period');
            }

        }
    }

    public function deleteSchedule()
    {
        if(Request::ajax())
        {
            $routineID = Input::get('routineId');
            return ClassRoutine::where('routine_id',$routineID)->delete();

        }else{
            return Redirect::to($this->default_route);
        }
    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/27/14
 * Time: 1:11 PM
 */

class AjaxController extends BaseController{

    /**
     * for set layout
     * @var string
     */
    protected $layout;

    /**
     * for set default route
     * @var string
     */
    protected $default_route;

    /**
     * for set user session data
     * @var string
     */
    protected $_userSession;

    public function __construct()
    {
        $this->layout = Theme::getLayout();
        $this->default_route = '/';
        $this->_userSession = Authenticate::check();  // check is user logged in
        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }


    /* Get JSON data of class wise sections */
    public function getClassWiseSection()
    {
        if(Request::ajax() || (Request::format() == 'json'))
        {
            /*
            method's functionality transferred in AjaxModel for internal reuse - Tanvir.

            */
            $id = (int)Input::get('class_id');

            $ajaxModel = new AjaxModel();
            return $ajaxModel->get_class_wise_section($id);
        }
        else
        {
            return Redirect::to($this->default_route);
        }
    }

    public function getClassWiseSubject()
    {
        if(Request::ajax() || (Request::format() == 'json'))
        {
            $id = (int)Input::get('class_id');

            $ajaxModel = new AjaxModel();
            return $ajaxModel->get_class_wise_subject($id);
/*
            $subjects = SchoolClass::find($id);
            if(count($subjects))
                return $subjects->Subjects->toJson();
            else
                return json_encode(array()); */
        }
        else
        {
            return Redirect::to($this->default_route);
        }
    }


    public function getDependedSubject()
    {
        if(Request::ajax())
        {
            $id = (int)Input::get('class_id');
            $class = SchoolClass::find($id);
            if(count($class))
                return SchoolSubject::where('class_id',$class->class_id)->where('subject_dependency',1)->get()->toJson();
            else
                return json_encode(array());
        }
        else
        {
            return Redirect::to($this->default_route);
        }

    }

    public function getOptionalSubjects()
    {

        if(Request::ajax())
        {

            $classId = Input::get('class_id');
            $groupId = Input::get('group_id');
            $subjects = SchoolSubject::where("class_id",$classId)->where('group_id',$groupId)->get();

            return $subjects->toJson();
        }
        else
        {
            return Redirect::to($this->default_route);
        }
    }

    public function getPeriodByName()
    {
        if(Request::ajax())
        {
            $name = (string)Input::get('period_name');
            $period = SchoolPeriod::where('period_name',$name)->first();
            if(count($period))
            {
                return $period->period_details;
            }
            else{
                return json_encode(array());
            }
        }
        else
        {
            return Redirect::to($this->default_route);
        }
    }

    public function searchTeacher()
    {
        if(Request::ajax())
        {
            $searchTxt = Input::get('search_txt');
            $teacher = new Teacher();
            return $teacher->search($searchTxt);
        }
        else
        {
            return Redirect::to($this->default_route);
        }
    }

    public function searchStudent()
    {
        if(Request::ajax())
        {
            $searchTxt = Input::get('search_txt');
            $student = new Student();
            return $student->search($searchTxt);
        }
        else
        {
            return Redirect::to($this->default_route);
        }
    }

    public function getUnregisteredStudent()
    {

        if(Request::ajax())
        {
            $classId = Input::get('class_id');
            $studentType = Input::get('student_type');
            return Student::unregisteredStudents($classId,$studentType);
        }
        else
        {
            return Redirect::to($this->default_route);
        }
    }

    public function changeStudentSubjectStatus()
    {
        if(Request::ajax())
        {
            $id = Input::get('id');
            $subjectStatus = Input::get('subject_status');
            return StudentSubject::where('student_subject_id',$id)->update(array('subject_status'=>$subjectStatus));
        }
        else
        {
            return Redirect::to($this->default_route);
        }

    }

    public function getRegisteredStudent()
    {
        if(Request::ajax())
        {
            $session    = Input::get('session');
            $class_id   = Input::get('class_id');
            $section_id = Input::get('section_id');
            $class_roll = Input::get('class_roll');
            return Registration::searchRegistration(
                array('session'=>$session,'class_id'=>$class_id,'section_id'=>$section_id,'class_roll'=>$class_roll)
            );
        }
        else
        {
            return Redirect::to($this->default_route);
        }
    }


    public function getAssignedTeacherBySubject()
    {
        if(Request::ajax())
        {
            $viewModel = array();
            $subject_id = Input::get('subject_id');
            $viewModel['teacherAssigns'] = TeacherAssign::getTeachers($subject_id);
            $viewModel['theme'] = Theme::getTheme();
            return Theme::make('activities.partial.ajax-assigned-teacher-grid',$viewModel);
        }else{
            return Redirect::to($this->default_route);
        }
    }

    public function getCoursePlans()
    {
        if(Request::ajax())
        {
            $subject_id = Input::get('subject_id');
            $teacher_id = Input::get('teacher_id');
            $viewModel = array();
            $viewModel['coursePlans'] = CoursePlan::where('subject_id',$subject_id)->where('teacher_id',$teacher_id)->get();
            return Theme::make('activities.partial.ajax-course-plans',$viewModel);
        }else{
            return Redirect::to($this->default_route);
        }
    }

    public function getTeachers()
    {
        if(Request::ajax())
        {
            return Teacher::all()->toJson();
        }
        else{
            return Redirect::to($this->default_route);
        }
    }

    public function getHeads()
    {
        if(Request::ajax())
        {
            $acc_type = Input::get('acc_type');
            $heads = AccountHead::where('acc_type',$acc_type)->orderBy('parent_head','asc')->orderBy('head_name','asc')->get();
            $indexedHeads = array();
            foreach($heads as $head)
            {
                $head_name = (strlen(trim($head->parent_head)) > 0)? $head->parent_head : $head->head_name ;
                if($head_name == $head->parent_head)
                {
                    $indexedHeads[$head_name]['child'][] = $head->getAttributes();
                }else
                {
                    $indexedHeads[$head_name] = $head->getAttributes();
                    $indexedHeads[$head_name]['child'] = array(); 
                }
            }
            return $indexedHeads;
        }
    }


} 
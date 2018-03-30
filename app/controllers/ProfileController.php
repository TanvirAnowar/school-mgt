<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/5/14
 * Time: 3:03 PM
 */

class ProfileController extends BaseController{

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
        parent::__construct();

        $this->default_route = 'profile/index';
        $this->_userSession = Authenticate::check();  // check is user logged in
        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }

    public function index()
    {   $viewModel = array(

          'user'  => $this->_userSession
        );
        $viewType = strtolower(Authenticate::getUserType());
        $accessType = Authenticate::getUserType();

        $model = '';
        if($accessType == 'Teacher')
        {
            $obj = new Teacher;
            $model = $obj->where('id',$this->_userSession->user_id)->first();
            $viewModel['maritalStatus'] = array('Single','Married');
            $viewModel['bloodGroup']    = array('A+','A-','B+','B-','AB+','AB-','O+','O-');
            $viewModel['gender']        = array('Male','Female');
            $viewModel['religion']      = array('Muslim','Christian','Buddhist','Hindu','Other');

        }else if($accessType == 'Student')
        {
            $obj = new Student;
            $model = $obj->where('id',$this->_userSession->user_id)->first();
            $viewModel['gender']   = array('Male','Female');
            $viewModel['religion'] = array('Muslim','Christian','Buddhist','Hindu','Other');
            $viewModel['statuses']   = array('Passed','Terminate','Refer');
            $viewModel['blood_group']  = array('A+','A-','B+','B-','AB+','AB-','O+','O-');
            $viewModel['options'] = json_decode($model->options);
        }
        $viewModel['access_type'] = $accessType;
        $viewModel['model'] = $model;
        $view = 'profile.'.$viewType;
        try{

            return Theme::make($view,$viewModel);

        }catch(Exception $e)
        {
            Helpers::addMessage(400, ' Page Not found');
            return Redirect::to('/');
        }

    }

    public function settings()
    {
        $viewModel = array(
          'theme' => Theme::getTheme(),
          'user'  => $this->_userSession
        );
        $viewType = strtolower(Authenticate::getUserType());
        $accessType = Authenticate::getUserType();

        $model = '';
        if($accessType == 'Teacher')
        {
            $obj = new Teacher;
            $model = $obj->where('id',$this->_userSession->user_id)->first();


        }else if($accessType == 'Student')
        {
            $obj = new Student;
            $model = $obj->where('id',$this->_userSession->user_id)->first();

        }
        $viewModel['model'] = $model;
        $viewModel['username'] = $this->_userSession->username;
        $viewModel['user_id']  = $this->_userSession->id;
        return Theme::make('profile.settings',$viewModel);
    }

    public function updateSettings()
    {
        if(Request::isMethod('post'))
        {
            $oldPassword = Input::get('old_password');
            $userId = Input::get('user_id');
            $newPassword = Input::get('new_password');
            $confirmPassword = Input::get('confirm_password');
            $user = User::where('id',$userId)->where('password',md5($oldPassword))->where('deleted_at',0)->first();
            if(count($user))
            {
                if($newPassword == $confirmPassword)
                {
                    User::where('id',$userId)->update(array('password'=>md5($newPassword)));
                    Helpers::addMessage(200, " User credentials updated");
                }else{
                    Helpers::addMessage(400, " password did not match with confirm password");
                }
            }else{
                    Helpers::addMessage(400, " Old Password Invalid, please try again");
            }
        }
        else
        {
            Helpers::addMessage(500, " Bad Request");


        }
        return Redirect::to('profile/settings');

    }

    public function attendance()
    {
        $user_id = $this->_userSession->user_id;
        $reg     = Registration::where('student_id',$user_id)->where('active_reg',1)->first();
        $class   = $reg->getClass;
        $section = $reg->getSection;
        $section_name = $section->section_name;
        $sendTo = strtolower($class->class_name).'-'.strtolower($section_name);
        $currentMode = Option::getData('attendance_default');
        $months = array('12'=>'December',
            '11'=>'November',
            '10'=>'October',
            '09'=>'September',
            '08'=>'August',
            '07'=>'July',
            '06'=>'June',
            '05'=>'May',
            '04'=>'April',
            '03'=>'March',
            '02'=>'February',
            '01'=>'January');
        $result = array();
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession
        );

        $viewModel['months'] = $months;
        if($currentMode == "Manual")
        {
            foreach($months as $month => $monthInWord)
            {
                $result[$month]['class_taken'] =  SmsDayLimit::where('sent_to',$sendTo)->where('sent_date','LIKE',date("Y-").$month.'-%')->count();
                $result[$month]['absent'] =  ManualAttendance::where('student_id',$reg->student_id)->where('created_at','LIKE',date("Y-").$month.'-%')->count();

            }
            $viewModel['attendance'] = $result;
            $viewModel['reg'] = $reg;
            return Theme::make('profile.attendance',$viewModel);
        }else{

            foreach($months as $month => $monthInWord)
            {
                $result[$month]['class_taken'] =  SmsDayLimit::where('sent_to',$sendTo)->where('sent_date','LIKE',date("Y-").$month.'-%')->count();
                $result[$month]['present'] = AutomaticAttendance::where('student_id',$reg->student_id)->where('created_at','LIKE',date("Y-").$month.'-%')->count();
            }
            $viewModel['attendance'] = $result;
            return Theme::make('profile.attendance-auto',$viewModel);
        }

    }

    public function subjects()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession
        );
        $teacher = Teacher::where('id',$this->_userSession->user_id)->first();
        if(count($teacher))
        {
            $viewModel['subjects'] = TeacherAssign::where('teacher_id',$teacher->id)->get();
        }else{
            $viewModel['subjects'] = '';
        }
        return Theme::make('profile.subjects',$viewModel);
    }
} 
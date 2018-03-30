<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 3/3/14
 * Time: 2:27 PM
 */

class TeacherController extends BaseController{

    protected $layout;
    protected $default_route;
    protected $_userSession;
    protected $pageLimit;
    public function __construct()
    {
        parent::__construct();
        $this->default_route = 'teacher/lists';
        $this->_userSession = Authenticate::check();
        $this->pageLimit = 20;
        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }

    public function index()
    {
        return Redirect::to($this->default_route);
    }

    public function lists()
    {

        $viewModel = array(

            'user'  => $this->_userSession,
            'teachers' => Teacher::where('deleted_at','0')->paginate($this->pageLimit)
        );
        /*Helpers::LastQuery();die(Helpers::debug($viewModel['teachers']));*/
        return Theme::make('teacher.lists',$viewModel);
    }

    public function trash()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'teachers' => Teacher::where('deleted_at','>','0')->paginate($this->pageLimit)
        );
        /*Helpers::LastQuery();die(Helpers::debug($viewModel['teachers']));*/
        return Theme::make('teacher.trash',$viewModel);
    }

    public function add()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession
        );
        return Theme::make('teacher.add',$viewModel);
    }

    /* Action to save Teacher Profile */
    public function saveTeacher()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $nameInitial = Input::get('name_initial');
            $name = Input::get('name');
            $dob = Input::get('dob');
            $fatherName = Input::get('father_name');
            $motherName = Input::get('mother_name');
            $age = Input::get('age');
            $cellPhone = Input::get('cell_phone');
            $cellPhone2 = Input::get('cell_phone_2');
            $maritalStatus = Input::get('marital_status');
            $gender = Input::get('gender');
            $religion = Input::get('religion');
            $bloodGroup = Input::get('blood_group');
            $presentAddress = Input::get('present_address');
            $permanentAddress = Input::get('permanent_address');
            $email = Input::get('email');
            $nationality  = Input::get('nationality');
            $national_id  = Input::get('national_id');

            $teacher = Teacher::firstOrNew(array('name_initial'=>$nameInitial,'national_id'=>$national_id,'email'=>$email));
            if(!$teacher->exists)
            {
                $teacher->name_initial = $nameInitial;
                $teacher->name = $name;
                $teacher->dob  = $dob;
                $teacher->father_name  = $fatherName;
                $teacher->mother_name  = $motherName;
                $teacher->age = $age;
                $teacher->cell_phone = $cellPhone;
                $teacher->cell_phone_2 = $cellPhone2;
                $teacher->marital_status = $maritalStatus;
                $teacher->gender = $gender;
                $teacher->religion = $religion;
                $teacher->blood_group = $bloodGroup;
                $teacher->present_address = $presentAddress;
                $teacher->permanent_address = $permanentAddress;
                $teacher->email = $email;
                $teacher->nationality = $nationality;
                $teacher->national_id = $national_id;
                $teacher->save();
                $teacher_id = $teacher->id;

                // after saving teacher profile create login account for that teacher
                if($teacher_id)
                {

                   $userExist =  User::where('user_id',$teacher_id)->first();

                   if(!count($userExist))
                   {
                       $user = new User();
                       $user->user_id = $teacher_id;
                       $user->username = strtolower($nameInitial);
                       $user->password = md5(strtolower($nameInitial));
                       $user->user_type = 'Teacher';
                       $user->user_status = 1;
                       $user->save();
                   }
                }

                Helpers::addMessage(200,' Teacher Account Created');
            }
            else
            {
                Helpers::addMessage(400,' Teacher account already exist');
            }

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
        else
        {
            Helpers::addMessage(500,'Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }

    }


    public function edit()
    {
        $id = (int)Request::segment(3);
        $teacher = Teacher::find($id);

        if(count($teacher))
        {
            $viewModel = array(
                'theme'   => Theme::getTheme(),
                'user'    => $this->_userSession,
                'teacher' => Teacher::find($id),
                'maritalStatus' => array('Single','Married'),
                'bloodGroup'  => array('A+','A-','B+','B-','AB+','AB-','O+','O-'),
                'gender'   => array('Male','Female'),
                'religion' => array('Muslim','Christian','Buddhist','Hindu','Other')
            );
            return Theme::make('teacher.edit',$viewModel);

        }else{
            Helpers::addMessage(400," Teacher not found for id ".$id);
            $refUrl =  'teacher/lists';
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function updateTeacher()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $id = Input::get('teacher_id');
            $nameInitial = Input::get('name_initial');
            $name = Input::get('name');
            $dob = Input::get('dob');
            $fatherName = Input::get('father_name');
            $motherName = Input::get('mother_name');
            $age = Input::get('age');
            $cellPhone = Input::get('cell_phone');
            $cellPhone2 = Input::get('cell_phone_2');
            $maritalStatus = Input::get('marital_status');
            $gender = Input::get('gender');
            $religion = Input::get('religion');
            $bloodGroup = Input::get('blood_group');
            $presentAddress = Input::get('present_address');
            $permanentAddress = Input::get('permanent_address');
            $email = Input::get('email');
            $nationality  = Input::get('nationality');
            $nationalId  = Input::get('national_id');

            $teacher = Teacher::find($id);

            if(count($teacher))
            {
                $updateData = array();
                $updateData['name_initial'] = $nameInitial;
                $updateData['name'] = $name;
                $updateData['dob'] = $dob;
                $updateData['father_name'] = $fatherName;
                $updateData['mother_name'] = $motherName;
                $updateData['age'] = $age;
                $updateData['cell_phone'] = $cellPhone;
                $updateData['cell_phone_2'] = $cellPhone2;
                $updateData['marital_status'] = $maritalStatus;
                $updateData['gender'] = $gender;
                $updateData['religion'] = $religion;
                $updateData['blood_group'] = $bloodGroup;
                $updateData['present_address'] = $presentAddress;
                $updateData['permanent_address'] = $permanentAddress;
                $updateData['email'] = $email;
                $updateData['nationality'] = $nationality;
                $updateData['national_id'] = $nationalId;



                if(Input::hasFile('file'))
                {
                    $ext = Input::file('file')->getClientOriginalExtension();
                    $name = Input::file('file')->getClientOriginalName();
                    $path = 'data/teacher/';
                    $prefix = time();
                    $name = $prefix.'_'.$name;
                    if(in_array($ext,array('jpg','png','gif'))){
                        Input::file('file')->move($path,$name);
                        $updateData['photo'] = $path.$name;
                    }
                }
                $updated = Teacher::where('id',$teacher->id)->update($updateData);

                if($updated)
                {
                    Helpers::addMessage(200,' Teacher Information updated');
                }else{
                    Helpers::addMessage(400,' Teacher Information unchanged');
                }

            }else{
                Helpers::addMessage(400,' Teacher record not found');
            }


            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
        else
        {
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }

    }

    public function view()
    {
        $id = (int)Request::segment(3);
        $teacher = Teacher::find($id);

        if(count($teacher))
        {
            $viewModel = array(
                'theme'   => Theme::getTheme(),
                'user'    => $this->_userSession,
                'teacher' => $teacher,
                'maritalStatus' => array('Single','Married'),
                'bloodGroup'  => array('A+','A-','B+','B-','AB+','AB-','O+','O-'),
                'gender'   => array('Male','Female'),
                'religion' => array('Muslim','Christian','Buddhist','Hindu','Other')
            );
            return Theme::make('teacher.view',$viewModel);

        }else{
            Helpers::addMessage(400," Teacher not found for id ".$id);
            $refUrl =  'teacher/lists';
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }


    }

    // Soft delete of record
    public function delete()
    {
        if(Request::ajax())
        {
           $id = (int)Input::get('id');
           $teacher = Teacher::find($id);
           if(count($teacher))
           {
                Teacher::where('id',$id)->update(array('deleted_at'=>time()));
                Helpers::addMessage(200, " Information $teacher->name was trashed");
               return json_encode(array('status'=>200));
           }else{
                Helpers::addMessage(400, " Record Not Found");
                return json_encode(array('status'=>400));
           }

        }else{
            Helpers::addMessage(500, " Bad Request");
            return Redirect::to($this->default_route);
        }

    }

    // restore teacher
    public function restore()
    {
        if(Request::ajax())
        {
            $id = (int)Input::get('id');
            $teacher = Teacher::find($id);

            if(count($teacher))
            {
                Teacher::where('id',$teacher->id)->update(array('deleted_at'=>0));
                Helpers::addMessage(200, "$teacher->name's Information restored");
                return json_encode(array('status'=>200));
            }else{
                Helpers::addMessage(400, " Record not found");
                return json_encode(array('status'=>400));
            }
        }else{
            Helpers::addMessage(500, " Bad Request");
            return Redirect::to($this->default_route);
        }
    }

    // remove record from db
    public function terminate()
    {
        if(Request::ajax())
        {
            $id = (int)Input::get('id');
            $teacher = Teacher::find($id);
            if(count($teacher))
            {
                Teacher::destroy($id);
                Helpers::addMessage(200, " Information $teacher->name was terminated");
                return json_encode(array('status'=>200));
            }else{
                Helpers::addMessage(400, " Record Not Found");
                return json_encode(array('status'=>400));
            }

        }else{
            Helpers::addMessage(500, " Bad Request");
            return Redirect::to($this->default_route);
        }

    }


    public function search()
    {
        $viewModel = array(
          'theme' => Theme::getTheme(),
          'user'  => $this->_userSession
        );
        return Theme::make('teacher.search',$viewModel);
    }

} 
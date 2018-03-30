<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/20/14
 * Time: 12:10 PM
 */

class StudentController extends BaseController{

    protected $layout;
    protected $default_route;
    protected $_userSession;
    protected $pageLimit;

    public function __construct()
    {
        parent::__construct();
        $this->default_route = 'student/lists';
        $this->_userSession = Authenticate::check();
        $this->pageLimit = 20;

        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }

    public function index()
    {
        return Redirect::to($this->default_route);
    }

    public function admitForm()
    {
        $admitForm = new AdmitForm();
        $admitForm->exam_roll = date('Y') . substr(time(),5);
        $year = (int) date('Y');
        $admitForm->session = (!empty($admitForm->session))? $admitForm->session :   $year . '-' . ($year + 1);
        $viewModel = array(

            'user'  => $this->_userSession,
            'admitForm' =>$admitForm,
            'bloodGroup'  => array('A+','A-','B+','B-','AB+','AB-','O+','O-'),
            'gender'   => array('Male','Female'),
            'religion' => array('Muslim','Christian','Buddhist','Hindu','Other'),
            'statuses'   => array('Passed','Terminate','Refer'),
        );
        return Theme::make('student.admit-form',$viewModel);

    }


    public function saveAdmitForm()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');

            $session = Input::get('session');
            $name = Input::get('name');
            $exam_roll = Input::get('exam_roll');
            $exam_date = Input::get('exam_date');
            $exam_venue = Input::get('exam_venue');
            $previous_school = Input::get('previous_school');
            $father_name = Input::get('father_name');
            $mother_name = Input::get('mother_name');
            $mobile_number = Input::get('mobile_number');
            $phone = Input::get('phone');
            $present_address = Input::get('present_address');
            $nationality = Input::get('nationality');
            $dob = Input::get('dob');
            $religion = Input::get('religion');
            $status = Input::get('status');
            $gender = Input::get('gender');

            $admitForm = AdmitForm::firstOrNew(array(
                'session' => $session,
                'name'    => $name,
                'exam_roll' => $exam_roll,

            ));



            if(!$admitForm->exists)
            {
                $admitForm->exam_date = $exam_date;
                $admitForm->exam_venue = $exam_venue;
                $admitForm->previous_school = $previous_school;
                $admitForm->father_name = $father_name;
                $admitForm->mother_name = $mother_name;
                $admitForm->mobile_number = $mobile_number;
                $admitForm->phone = $phone;
                $admitForm->present_address = $present_address;
                $admitForm->nationality = $nationality;
                $admitForm->dob = $dob;
                $admitForm->religion = $religion;
                $admitForm->gender = $gender;
                $admitForm->photo = '';
                $admitForm->status = $status;

                $admitFormId = $admitForm->save();
                if($admitFormId)
                {

                    if(Input::hasFile('file'))
                    {
                        $ext = Input::file('file')->getClientOriginalExtension();
                        $name = Input::file('file')->getClientOriginalName();
                        $path = 'data/admit-form/';
                        $prefix = time();
                        $name = $prefix.'_'.$name;
                        if(in_array($ext,array('jpg','png','gif'))){
                            Input::file('file')->move($path,$name);
                            AdmitForm::where('admit_form_id',$admitFormId)->update(array('photo'=>$path.$name));
                        }
                    }

                }

                Helpers::addMessage(200,' Admission Form Applied For Exam Roll '.$admitForm->exam_roll);
            }
            else{
                Helpers::addMessage(400,' Exam Roll Already Exist');
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

    public function admitList()
    {
        $session = (int)date('Y');
        $viewModel = array(
          'theme' => Theme::getTheme(),
          'user'  => $this->_userSession,
          'admitLists' => AdmitForm::all()
        );
        return Theme::make('student.admit-list',$viewModel);
    }

    public function admitDetails()
    {
        $id = (int)Request::segment(3);
        $admitForm = AdmitForm::find($id);
        if(count($admitForm))
        {
            $viewModel = array(
                'theme'   => Theme::getTheme(),
                'user'    => $this->_userSession,
                'admitForm' => $admitForm,
                'bloodGroup'  => array('A+','A-','B+','B-','AB+','AB-','O+','O-'),
                'gender'   => array('Male','Female'),
                'religion' => array('Muslim','Christian','Buddhist','Hindu','Other'),
                'statuses'   => array('Passed','Terminate','Refer'),
                'options' => json_decode($admitForm->options)
            );
            return Theme::make('student.admit-details',$viewModel);
        }else{
            Helpers::addMessage('400', ' Record not found');
            $refUrl =  'teacher/admit-list';
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }

    }

    public function updateAdmitForm()
    {
        if(Request::isMethod('post'))
        {
            $refUrl = Input::get('refurl');
            $session = Input::get('session');
            $name = Input::get('name');
            $exam_roll = Input::get('exam_roll');
            $exam_date = Input::get('exam_date');
            $exam_venue = Input::get('exam_venue');
            $previous_school = Input::get('previous_school');
            $father_name = Input::get('father_name');
            $mother_name = Input::get('mother_name');
            $mobile_number = Input::get('mobile_number');
            $phone = Input::get('phone');
            $present_address = Input::get('present_address');
            $nationality = Input::get('nationality');
            $dob = Input::get('dob');
            $religion = Input::get('religion');
            $status = Input::get('status');
            $gender = Input::get('gender');
            $id = Input::get('id');
            $keys = Input::get('key');
            $values = Input::get('value');

            // adding additional info key value pair to new array $additionalInfo
            $additionalInfo = array();
            if(count($keys))
            {
                foreach($keys as $i => $field)
                {
                    if(!empty($keys[$i]) && !empty($values[$i]))
                    {
                        $additionalInfo[$i] = array('key'=>$field, 'value' => $values[$i]);
                    }
                }

            }

            // check is entity exist
            $admitForm = AdmitForm::find($id);


            if(count($admitForm))
            {
                $updateAdmitForm = array();
                $updateAdmitForm['session'] = $session;
                $updateAdmitForm['name'] = $name;
                $updateAdmitForm['exam_roll'] = $exam_roll;
                $updateAdmitForm['exam_date'] = $exam_date;
                $updateAdmitForm['exam_venue'] = $exam_venue;
                $updateAdmitForm['previous_school'] = $previous_school;
                $updateAdmitForm['father_name'] = $father_name;
                $updateAdmitForm['mother_name'] = $mother_name;
                $updateAdmitForm['mobile_number'] = $mobile_number;
                $updateAdmitForm['phone'] = $phone;
                $updateAdmitForm['present_address'] = $present_address;
                $updateAdmitForm['nationality'] = $nationality;
                $updateAdmitForm['dob'] = Helpers::dateTimeFormat("Y-m-d",$dob);
                $updateAdmitForm['religion'] = $religion;
                $updateAdmitForm['gender'] = $gender;
                $updateAdmitForm['status'] = $status;
                $updateAdmitForm['options'] = (!empty($additionalInfo))? json_encode($additionalInfo) : '';


                // if any new photo uploaded
                if(Input::hasFile('file'))
                {
                    $ext = Input::file('file')->getClientOriginalExtension();
                    $name = Input::file('file')->getClientOriginalName();
                    $path = 'data/admit-form/';

                    $prefix = time();
                    $name = $prefix.'_'.$name;
                    if(in_array($ext,array('jpg','png','gif'))){
                        Input::file('file')->move($path,$name);
                        $updateAdmitForm['photo'] = $path.$name;
                        AdmitForm::where('admit_form_id',$admitForm->admit_form_id)->update($updateAdmitForm);
                        if(file_exists($admitForm->photo))
                        {
                            unlink($admitForm->photo);
                        }
                    }
                }else{
                    AdmitForm::where('admit_form_id',$admitForm->admit_form_id)->update($updateAdmitForm);
                }
                Helpers::addMessage(200,' Information updated');
            }
            else
            {
                Helpers::addMessage(400,' Information unchanged.');
            }
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
        else
        {
            Helpers::addMessage(500,' Bad Request');
            $refUrl = Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }


    public function add()
    {

        $examRoll = Request::segment(3);

        $admitForm = AdmitForm::firstOrNew(array('exam_roll'=>$examRoll));

        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'admit_form' => $admitForm,
            'classes' => SchoolClass::all(),
            'gender'   => array('Male','Female'),
            'religion' => array('Muslim','Christian','Buddhist','Hindu','Other'),
            'statuses'   => array('Passed','Terminate','Refer'),
            'blood_group'  => array('A+','A-','B+','B-','AB+','AB-','O+','O-'),
            'options' => json_decode($admitForm->options)

        );

        return Theme::make('student.add',$viewModel);
    }
 
    public function saveStudent()
    {

        if(Request::isMethod('post'))
        {
            $refUrl = Input::get('refurl');

            $student_id = Input::get('student_id');
            $name = Input::get('name');
            $class_id = Input::get('class_id');
            $section_id = Input::get('section_id');
            $nationality = Input::get('nationality');
            $dob = Input::get('dob');
            $blood_group = Input::get('blood_group');
            $gender = Input::get('gender');
            $religion = Input::get('religion');
            $father_name = Input::get('father_name');
            $father_profession = Input::get('father_profession');
            $father_cell_phone = Input::get('father_cell_phone');
            $mother_name = Input::get('mother_name');
            $mother_profession = Input::get('mother_profession');
            $mother_cell_phone = Input::get('mother_cell_phone');
            $present_address = Input::get('present_address');
            $permanent_address = Input::get('permanent_address');
            $no_of_child = Input::get('no_of_child');
            $child_position = Input::get('child_position');
            $no_of_sibling = Input::get('no_of_sibling');

            $student = Student::firstOrNew(array('student_id'=>$student_id));

            if(!$student->exists)
            {
                $student->name = $name;
                $student->nationality = $nationality;
                $student->class_id = $class_id;
                $student->section_id = $section_id;
                $student->dob = $dob;
                $student->blood_group = $blood_group;
                $student->gender = $gender;
                $student->religion = $religion;
                $student->father_name = $father_name;
                $student->father_profession = $father_profession;
                $student->father_cell_phone = $father_cell_phone;
                $student->mother_name = $mother_name;
                $student->mother_profession = $mother_profession;
                $student->mother_cell_phone = $mother_cell_phone;
                $student->present_address = $present_address;
                $student->permanent_address = $permanent_address;
                $student->no_of_child = $no_of_child;
                $student->child_position = $child_position;
                $student->no_of_sibling = $no_of_sibling;

                $keys = Input::get('key');
                $values = Input::get('value');

                // adding additional info key value pair to new array $additionalInfo
                $additionalInfo = array();
                if(count($keys))
                {
                    foreach($keys as $i => $field)
                    {
                        if(!empty($keys[$i]) && !empty($values[$i]))
                        {
                            $additionalInfo[$i] = array('key'=>$field, 'value' => $values[$i]);
                        }
                    }

                }

                $student->options = (!empty($additionalInfo))? json_encode($additionalInfo) : '';

                //upload any image for father photo
                if(Input::hasFile('father_photo'))
                {
                    $ext = Input::file('father_photo')->getClientOriginalExtension();
                    $name = Input::file('father_photo')->getClientOriginalName();
                    $path = 'data/student/father/';

                    $prefix = time();
                    $name = $prefix.'_'.$name;
                    if(in_array($ext,array('jpg','png','gif'))){
                        Input::file('father_photo')->move($path,$name);
                        $student->father_photo = $path.$name;
                    }
                }
                //upload any image for mother photo
                if(Input::hasFile('mother_photo'))
                {
                    $ext = Input::file('mother_photo')->getClientOriginalExtension();
                    $name = Input::file('mother_photo')->getClientOriginalName();
                    $path = 'data/student/mother/';

                    $prefix = time();
                    $name = $prefix.'_'.$name;
                    if(in_array($ext,array('jpg','png','gif'))){
                        Input::file('mother_photo')->move($path,$name);
                        $student->mother_photo = $path.$name;
                    }
                }
                //upload any image for student photo
                if(Input::hasFile('student_photo'))
                {
                    $ext = Input::file('student_photo')->getClientOriginalExtension();
                    $name = Input::file('student_photo')->getClientOriginalName();
                    $path = 'data/student/';

                    $prefix = time();
                    $name = $prefix.'_'.$name;
                    if(in_array($ext,array('jpg','png','gif'))){
                        Input::file('student_photo')->move($path,$name);
                        $student->photo = $path.$name;
                    }
                }

                $student->save();
                // create student user account if student created successfully
                if($student->id)
                {
                    $userExist =  User::where('user_id',$student->id)->first();
                    if(!count($userExist))
                    {
                        $user = new User();
                        $user->user_id = $student->id;
                        $user->username = strtolower(str_replace(" ","_",$student_id));
                        $user->password = md5(strtolower(str_replace(" ","_",$student_id)));
                        $user->user_type = 'Student';
                        $user->user_status = 1;
                        $user->save();
                    }

                }

                Helpers::addMessage(200, " New Record added for $student->name");
            }
            else
            {
                Helpers::addMessage(400, " Information already exist for $student->name - $student->student_id");
            }

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
        else
        {
            Helpers::addMessage(500,' Bad Request');
            $refUrl = Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function edit()
    {
        $id = (int)Request::segment(3);

        $student = Student::find($id);

        if(count($student))
        {

            $viewModel = array(
                'theme' => Theme::getTheme(),
                'user'  => $this->_userSession,
                'student' => $student,
                'classes' => SchoolClass::all(),
                'gender'   => array('Male','Female'),
                'religion' => array('Muslim','Christian','Buddhist','Hindu','Other'),
                'statuses'   => array('Passed','Terminate','Refer'),
                'blood_group'  => array('A+','A-','B+','B-','AB+','AB-','O+','O-'),
                'options' => json_decode($student->options)
            );
            return Theme::make('student.edit',$viewModel);
        }
        else
        {
            Helpers::addMessage(500, ' Bad Request');
            return Redirect::to($this->default_route);

        }

    }


    public function updateStudent()
    {
        if(Request::isMethod('post')){

            $id = (int)Input::get('id');
            $student = Student::find($id);

            if(count($student))
            {
                $refUrl = Input::get('refurl');
                $updateStudent = array();
                $updateStudent['student_id'] = Input::get('student_id');
                $updateStudent['name'] = Input::get('name');
                $classId = Input::get('class_id');
                if(!empty($classId))
                    $updateStudent['class_id'] = $classId;
                $updateStudent['nationality'] = Input::get('nationality');
                $updateStudent['dob'] = Input::get('dob');
                $updateStudent['blood_group'] = Input::get('blood_group');
                $updateStudent['gender'] = Input::get('gender');
                $updateStudent['religion'] = Input::get('religion');
                $updateStudent['father_name'] = Input::get('father_name');
                $updateStudent['father_profession'] = Input::get('father_profession');
                $updateStudent['father_cell_phone'] = Input::get('father_cell_phone');
                $updateStudent['mother_name'] = Input::get('mother_name');
                $updateStudent['mother_profession'] = Input::get('mother_profession');
                $updateStudent['mother_cell_phone'] = Input::get('mother_cell_phone');
                $updateStudent['present_address'] = Input::get('present_address');
                $updateStudent['permanent_address'] = Input::get('permanent_address');
                $updateStudent['no_of_child'] = Input::get('no_of_child');
                $updateStudent['child_position'] = Input::get('child_position');
                $updateStudent['no_of_sibling'] = Input::get('no_of_sibling');

                $keys = Input::get('key');
                $values = Input::get('value');

                // adding additional info key value pair to new array $additionalInfo
                $additionalInfo = array();
                if(count($keys))
                {
                    foreach($keys as $i => $field)
                    {
                        if(!empty($keys[$i]) && !empty($values[$i]))
                        {
                            $additionalInfo[$i] = array('key'=>$field, 'value' => $values[$i]);
                        }
                    }

                }

                $updateStudent['options'] = (!empty($additionalInfo))? json_encode($additionalInfo) : '';

                //upload any image for father photo
                if(Input::hasFile('father_photo'))
                {
                    $ext = Input::file('father_photo')->getClientOriginalExtension();
                    $name = Input::file('father_photo')->getClientOriginalName();
                    $path = 'data/student/father/';

                    $prefix = time();
                    $name = $prefix.'_'.$name;
                    if(in_array($ext,array('jpg','png','gif'))){
                        $uploadSuccess = Input::file('father_photo')->move($path,$name);
                        if($uploadSuccess)
                        {
                            if(file_exists($student->father_photo))
                                unlink($student->father_photo);
                        }
                        $updateStudent['father_photo'] = $path.$name;
                    }
                }
                //upload any image for mother photo
                if(Input::hasFile('mother_photo'))
                {
                    $ext = Input::file('mother_photo')->getClientOriginalExtension();
                    $name = Input::file('mother_photo')->getClientOriginalName();
                    $path = 'data/student/mother/';

                    $prefix = time();
                    $name = $prefix.'_'.$name;
                    if(in_array($ext,array('jpg','png','gif'))){
                        $uploadSuccess = Input::file('mother_photo')->move($path,$name);
                        if($uploadSuccess)
                        {
                            if(file_exists($student->mother_photo))
                                unlink($student->mother_photo);
                        }
                        $updateStudent['mother_photo'] = $path.$name;
                    }
                }
                //upload any image for student photo
                if(Input::hasFile('student_photo'))
                {
                    $ext = Input::file('student_photo')->getClientOriginalExtension();
                    $name = Input::file('student_photo')->getClientOriginalName();
                    $path = 'data/student/';

                    $prefix = time();
                    $name = $prefix.'_'.$name;
                    if(in_array($ext,array('jpg','png','gif'))){
                       $uploadSuccess = Input::file('student_photo')->move($path,$name);
                       if($uploadSuccess)
                       {
                           if(file_exists($student->photo))
                               unlink($student->photo);
                       }
                        $updateStudent['photo'] = $path.$name;
                    }
                }

                $updated = Student::where('id',$student->id)->update($updateStudent);
                if($updated)
                {
                    Helpers::addMessage(200, " Information updated for $student->name");
                }
                else{
                    Helpers::addMessage(200, " Information unchanged");
                }

                return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
            }
            else
            {
                Helpers::addMessage(400,' No record found');
                $refUrl = Input::get('refurl');
                return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
            }
        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl = Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }


    public function view()
    {
        $id = (int)Request::segment(3);

        $student = Student::find($id);
        if(count($student))
        {

            $viewModel = array(
                'theme' => Theme::getTheme(),
                'user'  => $this->_userSession,
                'student' => $student,
                'classes' => SchoolClass::all(),
                'gender'   => array('Male','Female'),
                'religion' => array('Muslim','Christian','Buddhist','Hindu','Other'),
                'statuses'   => array('Passed','Terminate','Refer'),
                'blood_group'  => array('A+','A-','B+','B-','AB+','AB-','O+','O-'),
                'options' => json_decode($student->options)
            );
            return Theme::make('student.view',$viewModel);
        }
        else
        {
            Helpers::addMessage(400, ' Record not found');
            return Redirect::to($this->default_route);

        }

    }


    // Soft delete of record
    public function delete()
    {
        if(Request::ajax())
        {
            $id = (int)Input::get('id');
            $teacher = Student::find($id);
            if(count($teacher))
            {
                Student::where('id',$id)->update(array('deleted_at'=>time()));
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

    // remove record from db
    public function terminate()
    {
        if(Request::ajax())
        {
            $id = (int)Input::get('id');
            $teacher = Student::find($id);
            if(count($teacher))
            {
                Student::destroy($id);
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


    public function lists()
    {
        $viewModel = array(
            'theme'=> Theme::getTheme(),
            'user' => $this->_userSession,
            'students' => Student::where('deleted_at','0')->paginate($this->pageLimit)
        );

        return Theme::make('student.lists',$viewModel);
    }

    public function trash()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'students' => Student::where('deleted_at','>','0')->paginate($this->pageLimit)
        );

        /*Helpers::LastQuery();die(Helpers::debug($viewModel['teachers']));*/
        return Theme::make('student.trash',$viewModel);
    }

    public function search()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession
        );
        return Theme::make('student.search',$viewModel);
    }


    public function registeredStudents()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'classes' => SchoolClass::all(),
            'sections' => SchoolSection::all(),
            'registeredStudents' => Registration::where('deleted_at',0)->paginate($this->pageLimit)
        );
        
        return Theme::make('student.registered-students',$viewModel);

    }

    public function registeredStudentsTrash()
    {

        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'classes' => SchoolClass::all(),
            'sections' => SchoolSection::all(),
            'registeredStudents' => Registration::where('deleted_at','>',0)->paginate($this->pageLimit)
        );
        return Theme::make('student.registered-students-trash',$viewModel);
    }

    public function register()
    {
        $segment = Request::segment(3);
        $viewModel = array(
            'theme'=> Theme::getTheme(),
            'user' => $this->_userSession,
            'classes' => SchoolClass::all(),
            'shifts' => SchoolShift::all(),
            'groups' => SchoolGroup::all()
        );
        if($segment == 'edit')
        {
            $id = (int)Request::segment(4);
            $registration = Registration::find($id);
            if(count($registration))
            {
                $viewModel['registration'] = $registration;
                $subjects = SchoolSubject::where('class_id',$registration->class_id)->get();
                $assignedSubjectsIds = $registration->studentSubjectsIds($registration->class_id,$registration->student_id);
                $remainingSubjects = array();

                foreach($subjects as $subject)
                {

                        if(!in_array($subject->subject_id,$assignedSubjectsIds))
                            $remainingSubjects[] = $subject;


                }

                $viewModel['sections'] = $registration->getClass->Sections;
                $viewModel['subjects'] = $remainingSubjects;
                return Theme::make('student.register-edit',$viewModel);

            }else{

                Helpers::debug(400,' Record not found with id'.$id);
                $refUrl = 'student/registered-students';
                return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
            }

        }elseif($segment == 'view')
        {
            $id = (int)Request::segment(4);
            $registration = Registration::find($id);
            if(count($registration))
            {
                $viewModel['registration'] = $registration;
                $viewModel['sections'] = $registration->getClass->Sections;
                return Theme::make('student.register-view',$viewModel);

            }else{

                Helpers::debug(400,' Record not found with id'.$id);
                $refUrl = 'student/registered-students';
                return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
            }
        }
        else
        {
            return Theme::make('student.register',$viewModel);
        }

    }

    public function saveRegistration()
    {
        if(Request::isMethod('post'))
        {
            $refUrl = Input::get('refurl');
            $session = Input::get('session');

            $class_id = Input::get('class_id');
            $section_id = Input::get('section_id');
            $group_id = Input::get('group_id');
            $student_type = Input::get('student_type');
            $student_subjects = Input::get('student_subjects');
            $student = Input::get('student');
            $class_roll = Input::get('class_roll');

            $section = SchoolSection::find($section_id);

            $shift = $section->getShift;
            $shift_id = $shift->shift_id;

            if(!empty($student))
            {
                foreach($student as $i=> $s)
                {
                    $isRunning = Registration::where('student_id',$s)->first();
                    $registration = Registration::firstOrNew(array('session'=>$session,'reg_id'=>$session.'_'.$s,'deleted_at'=>0));
                    if(!$registration->exists)
                    {
                        $registration->student_id = $s;
                        $registration->class_id = $class_id;
                        $registration->section_id = $section_id;
                        $registration->shift_id = $shift_id;
                        $registration->group_id = $group_id;
                        $registration->class_roll = (!empty($class_roll[$i]))? $class_roll[$i] : '';
                        $registration->promotion_status = 'Running';
                        $registration->deleted_at = 0;
                        $registeredId = $registration->save();

                        if($registeredId)
                        {
                            Student::where('id',$registration->student_id)->update(array('student_type'=>'Running'));

                            if(count($student_subjects)){
                                foreach($student_subjects as $k => $studentSubject)
                                {
                                  $studentSubject = StudentSubject::firstOrNew(array('class_id'=>$class_id,'student_id'=>$s,'subject_id'=>$studentSubject,'session'=>$session));
                                  $studentSubject->subject_status = 'Compulsory';

                                  $studentSubject->save();
                                }
                            }
                        }
                        Helpers::addMessage(200, 'Registration Completed');

                    }else{
                        $verb = (count($student)==1)? ' is' : 's are';
                        Helpers::addMessage(400, ' Student'.$verb.' already registered for current year');
                    }
                }

                return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
            }else{
                Helpers::addMessage(400, ' Student not selected');
                $refUrl = 'student/register';
                return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
            }

        }
        else
        {
            Helpers::addMessage(500,' Bad Request');
            $refUrl = Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function updateRegistration()
    {
        if(Request::isMethod('post'))
        {
            $refUrl = Input::get('refurl');
            /*$shift_id = Input::get('shift_id');*/
            $class_id = Input::get('class_id');
            $section_id = Input::get('section_id');
            $group_id = Input::get('group_id');
            $id = Input::get('id');
            $student_id = Input::get('student_id');
            $session = Input::get('session');
            $student_subjects = Input::get('student_subjects');

            $registration = Registration::find($id);
            if(count($registration))
            {
                $section = SchoolSection::find($section_id);
                $shift_id = $section->getShift->shift_id;

                Registration::where('id',$id)->update(array('class_id'=>$class_id,'section_id'=>$section_id,'shift_id'=>$shift_id,'group_id'=>$group_id));
                if(count($student_subjects)){
                    foreach($student_subjects as $k=> $studentSubject)
                    {
                        $studentSubject = StudentSubject::firstOrNew(array('class_id'=>$class_id,'student_id'=>$student_id,'subject_id'=>$studentSubject,'session'=>$session));
                        $studentSubject->subject_status = 'Compulsory';
                        $studentSubject->save();
                    }
                }
                Helpers::addMessage(200,' Registration information updated');
            }
            else
            {
                Helpers::addMessage(400,' Record not found');
            }
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');

        }
        else
        {
            Helpers::addMessage(500,' Bad Request');
            $refUrl = Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function delStudSub()
    {
        if(Request::ajax())
        {
            $id = Input::get('id');
            return StudentSubject::where('student_subject_id',$id)->delete();
        }
        else
        {
            return Redirect::to($this->default_route);
        }
    }

    public function deleteRegistration()
    {
        $refUrl = 'student/registered-students';
        if(Request::isMethod('post'))
        {
            $id = Input::get('id');
            $registration = Registration::find($id);
            if(count($registration))
            {
                $deleted = Registration::where('id',$registration->id)->update(array('deleted_at'=>time()));
                if($deleted){
                    Student::where('id',$registration->student_id)->update(array('student_type'=>'New'));
                    Helpers::addMessage(200,' Information was deleted');
                    return json_encode(array('status'=>200));
                }
                else
                {
                    Helpers::addMessage(400,' Information was not deleted');
                    return json_encode(array('status'=>400));
                }
            }else{
                    Helpers::addMessage(400,' No registration found to delete.');
                    return json_encode(array('status'=>400));
            }
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
        else
        {
            Helpers::addMessage(500,' Bad Request');

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function deleteTrashRegistration()
    {
        $refUrl = 'student/registered-students';
        if(Request::isMethod('post'))
        {
            $id = Input::get('id');
            $deleted = Registration::where('id',$id)->where('deleted_at','>',0)->delete();

            if($deleted){
                //Helpers::addMessage(200,' Information was deleted');
                return json_encode(array('status'=>200));
            }
            else
            {
                //Helpers::addMessage(400,' Information was not deleted');
                return json_encode(array('status'=>400));
            }
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
        else
        {
            Helpers::addMessage(500,' Bad Request');

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function undoDelRegistration()
    {
        $refUrl = 'student/registered-students';
        if(Request::isMethod('post'))
        {
            $id = Input::get('id');
            $registration = Registration::find($id);
            if(count($registration))
            {
                $undoDelete = Registration::where('id',$id)->update(array('deleted_at'=>0));
                if($undoDelete){
                    Student::where('id',$registration->student_id)->update(array('student_type'=>'Running'));
                    Helpers::addMessage(200,' Information was retrieved');
                    return json_encode(array('status'=>200));
                }
                else
                {
                    Helpers::addMessage(400,' Information was not restored');
                    return json_encode(array('status'=>400));
                }
            }else{

                Helpers::addMessage(400,' No registration found to restore');
                return json_encode(array('status'=>400));
            }

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
        else
        {
            Helpers::addMessage(500,' Bad Request');

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function registeredStudentsTrashClear()
    {
        $refUrl = 'student/registered-students';
        if(Request::isMethod('post'))
        {
            $deleted =  Registration::where('deleted_at','>',0)->delete();
            if($deleted){
                Helpers::addMessage(200,' Information was deleted permanently');
            }
            else
            {
                Helpers::addMessage(400,' No Information was found to delete permanently');
            }
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
        else
        {
            Helpers::addMessage(500,' Bad Request');

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function promote()
    {
        $viewModel = array(
            'theme'=> Theme::getTheme(),
            'user' => $this->_userSession
        );
        return Theme::make('student.promote',$viewModel);
    }

    public function updateClassRoll()
    {
        if(Request::ajax())
        {
            $regId = Input::get('reg_id');
            if(count($regId))
            {
                foreach($regId as $id=>$value)
                {
                    Registration::where('reg_id',$id)->update(array('class_roll'=>$value));
                }
            }
            Helpers::addMessage(200,' Information updated');
        }
        return 1;
    }

} 
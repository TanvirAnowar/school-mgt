<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 3/17/14
 * Time: 4:25 PM
 */

class ActivitiesController extends BaseController{

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

    protected $pageLimit;

    public function __construct()
    {

        parent::__construct();
        $this->default_route = 'activities/index';
        $this->pageLimit = 20;
        $this->_userSession = Authenticate::check();  // check is user logged in
        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }


    public function index()
    {
        $viewModel = array(

          'user'  => $this->_userSession
        );

        return Theme::make('activities.dashboard',$viewModel);
    }

    public function mark()
    {
        $viewModel = array(

          'user'    => $this->_userSession,
          'classes' => SchoolClass::all(),
          'groups'  => SchoolGroup::all(),
          "terms"   => Terms::GetTerms()
        );

        return Theme::make('activities.mark.mark',$viewModel);
    }

    public function ajaxGetStudentsForMark()
    {
        if(Request::ajax())
        {
            $session = Input::get('session');
            $classId = Input::get('class_id');
            $groupId = Input::get('group_id');
            $sectionId = Input::get('section_id');
            $section = SchoolSection::find($sectionId);
            $shift = $section->getShift;
            $shiftId = $shift->shift_id;
            $subjectId = Input::get('subject_id');
            $term = Input::get('term');

            $teacherAssign =  TeacherAssign::where('subject_id',$subjectId)->where('section_id',$sectionId)->first();
            $viewModel = array();
            if(count($teacherAssign))
            {

                $classTests = CoursePlan::getClassTests($teacherAssign->teacher_id,$subjectId,$term,$session);

                $viewModel['teacher'] = $teacherAssign->getTeacher;
            }

            $viewModel['students'] = Registration::getStudentsForMark($session,$classId,$sectionId,$shiftId,$subjectId,$term);

            $subject = SchoolSubject::find($subjectId);
            if(!empty($subject->subject_dependency)){

                $viewModel['markSettings'] = CombineMarkSettings::where('subjects','like',"%".$subjectId."%")->get();

            }else{

                $viewModel['markSettings'] = MarkSettings::where('subject_id',$subjectId)->where('deleted_at',0)->orderBy('mark_type_id','ASC')->get();
            }

            $viewModel['classTests'] = (!empty($classTests))? $classTests : array();

            $marks = Marks::where('class_id',$classId)
                ->where('section_id',$sectionId)
                ->where('shift_id',$shiftId)
                ->where('group_id',$groupId)
                ->where('subject_id',$subjectId)
                ->where('term',$term)
                ->where('session',$session)->first();
            if(count($marks))
            {

                $viewModel['marks'] = json_decode($marks->mark_details);
                $viewModel['subject'] = SchoolSubject::find($subjectId);
                return Theme::make('activities.partial.ajax-get-students-for-mark-edit',$viewModel);
            }else{

                return Theme::make('activities.partial.ajax-get-students-for-mark',$viewModel);
            }

        }
        else
        {
            return Redirect::to($this->default_route);
        }
    }

    public function ajaxSaveMark()
    {
        if(Request::ajax())
        {
            $subjectName = Input::get('subject_name');
            $subjectId = Input::get('subject');
            $students = Input::get('students');
            $classId = Input::get('class');
            $session = Input::get('session');
            $term = Input::get('term');
            $sectionId = Input::get('section');
            $groupId = Input::get('group');
            $section = SchoolSection::find($sectionId);
           
            $shiftId = $section->getShift->shift_id;
            $studentSubjectMark = array();
            if(!empty($students))
            {
                foreach($students as $student)
                {
                    $studentSubjectMark['subjects'][$subjectName][$student['marktype']][$student['id']]['subject_id'] = $subjectId;
                    $studentSubjectMark['subjects'][$subjectName][$student['marktype']][$student['id']]['marks'][$student['markindex']] = $student['mark'];
                }
            }
            $marks =  Marks::firstOrNew(array('class_id'=>$classId,'section_id'=>$sectionId,'shift_id'=>$shiftId,'group_id'=>$groupId,'subject_id'=>$subjectId,'term'=>$term,'session'=>$session));
            if(!$marks->exists)
            {
                $marks->mark_details = json_encode($studentSubjectMark);
                $marks->save();
                //Helpers::debug($studentSubjectMark);
            }else{
                Marks::where('mark_id',$marks->mark_id)->update(array('mark_details'=>json_encode($studentSubjectMark)));
            }
            return 0;
        }

    }

    /*** Course Plan ***/
    public function coursePlan()
    {
        $segment = Request::segment(3);

        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession
        );
        if($segment == 'create')
        {
            $viewModel['classes'] = SchoolClass::all();
            $viewModel['terms'] = Terms::GetTerms();
            return Theme::make('activities.courses.course-plan-create',$viewModel);
        }
        elseif($segment == 'view'){
            $subject_id = Request::segment(4);
            $teacher_id = Request::segment(5);
            $teacherAssign = TeacherAssign::where('subject_id',$subject_id)->where('teacher_id',$teacher_id)->where('session',date("Y"))->first();
            $viewModel['section'] = SchoolSection::find($teacherAssign->section_id);
            $viewModel['teacher'] = Teacher::find($teacher_id);
            $viewModel['subject'] = SchoolSubject::find($subject_id);
            $viewModel['coursePlans'] = CoursePlan::where('teacher_id',$teacher_id)->where('subject_id',$subject_id)->where('deleted_at',0)->get();
            return Theme::make('activities.courses.course-plan-view',$viewModel);
        }
        else
        {
            $viewModel['courseplans'] = CoursePlan::getCoursePlans();
            return Theme::make('activities.courses.course-plan',$viewModel);
        }

    }

    public function saveCoursePlan()
    {
        if(Request::ajax())
        {
            $refUrl =  Input::get('refurl');
            $teacher_id = Input::get('teacher_id');
            $subject_id = Input::get('subject_id');
            $session = Input::get('session');
            $term = Input::get('term');
            $title = Input::get('title');
            $type = Input::get('type');
            $date = Input::get('date');
            $coursePlan = new CoursePlan;

            $coursePlan->teacher_id = $teacher_id;
            $coursePlan->subject_id = $subject_id;
            $coursePlan->session    = $session;
            $coursePlan->term       = $term;
            $coursePlan->title      = $title;
            $coursePlan->type       = $type;
            $coursePlan->date       = Helpers::dateTimeFormat("Y-m-d",$date);

            $savedId =  $coursePlan->save();
            if($savedId)
                return json_encode(array('status'=>200,'id'=>$savedId,'refurl'=>url($refUrl)));
            else
                return json_encode(array('status'=>400));
        }else{
            return Redirect::to($this->default_route);
        }
    }

    public function updateBestCount()
    {
        if(Request::ajax())
        {
            $id = Input::get('id');
            $coursePlan = CoursePlan::find($id);
            if(count($coursePlan))
            {
                CoursePlan::where('course_plan_id',$coursePlan->course_plan_id)->update(array('details' => Input::get('val')));
                return json_encode(array('status'=>200));
            }else{
                return json_encode(array('status'=>400));
            }
        }else{
            return Redirect::to($this->default_route);
        }
    }



    /*** Task ***/
    public function tasks()
    {
        $viewModel = array(
          'theme' => Theme::getTheme(),
          'user'  => $this->_userSession
        );
        $viewModel['classes'] = SchoolClass::all();
        $segment = Request::segment(3);
        if($segment == 'create')
        {

            return Theme::make('activities.task.create',$viewModel);

        }else if($segment == 'view')
        {
            $id = (int)Request::segment(4);
            $taskObj = Task::find($id);
            if(count($taskObj)){
                return Theme::make('activities.task.create',$viewModel);
            }else{
                Helpers::addMessage(400,' Record not found');
                return Redirect::to('activities/tasks');
            }

        }else if($segment == 'edit'){

            $id = (int)Request::segment(4);
            $taskObj = Task::find($id);
            if(count($taskObj)){
                $viewModel['task'] = $taskObj;
                return Theme::make('activities.task.edit',$viewModel);
            }else{
                Helpers::addMessage(400,' Record not found');
                return Redirect::to('activities/tasks');
            }


        }else{
            $viewModel['tasks'] = Task::where('date','like',date('Y-m').'%')->get();
            return Theme::make('activities.task.list',$viewModel);
        }


    }

    public function saveTask()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $classId = Input::get('class_id');
            $sectionId = Input::get('section_id');
            $task = Input::get('task');
            $task_date = Helpers::dateTimeFormat('Y-m-d', Input::get('task_date'));

            $taskObj = Task::firstOrNew(array('class_id'=>$classId,'section_id'=>$sectionId,'date'=>$task_date));
            if(!$taskObj->exists)
            {
                $taskObj->task = $task;
                $taskObj->session = date('Y');
                $taskObj->save();
                Helpers::addMessage(200, ' Information saved.');
            }else{

                Helpers::addMessage(400, ' Information already exist.');
            }

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }else{

            Helpers::addMessage(500, ' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function updateTask()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');

            $classId = Input::get('class_id');
            $sectionId = Input::get('section_id');
            $task = Input::get('task');
            $task_date = Helpers::dateTimeFormat('Y-m-d', Input::get('task_date'));
            $id = Input::get('task_id');
            $taskObj = Task::find($id);
            if(count($taskObj))
            {
                Task::where('task_id',$id)->update(array('class_id'=>$classId,'section_id'=>$sectionId,'task'=>$task,'date'=>$task_date));
                Helpers::addMessage(200,' Information updated');
            }else{
                Helpers::addMessage(400,' Record not found');
            }

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');

        }else{

            Helpers::addMessage(500, ' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');

        }
    }

    public function deleteTask()
    {
        if(Request::ajax())
        {
            $id = (int)Input::get('task_id');
            $taskObj = Task::find($id);
            $response = array();
            if(count($taskObj))
            {
                $taskObj->delete();
                $response = array('status'=>200,'msg'=>' Information deleted');
            }
            else{
                $response = array('status'=>400,'msg'=>' Record not found');
            }

            return json_encode($response);
        }else{

            Helpers::addMessage(500, 'Bad Request');
            $refUrl = 'activities/tasks';
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    /**** Attendance ****/

    public function attendance()
    {
        $viewModel = array(
          'theme' => Theme::getTheme(),
          'user'  => $this->_userSession
        );
        $viewModel['classes'] = SchoolClass::all();

        $carbonAPi = new Carbon51();
        $api_state = $carbonAPi->hasSession();
        $terms = Terms::GetTerms();
        $accessToken = $carbonAPi->getAccessToken($api_state);
        $token = $carbonAPi->getRefreshToken($accessToken);
        $tokenObj = (!empty($token)) ? json_decode($token) : '';
        $viewModel['clientid'] = $tokenObj->client_id;
        $viewModel['access_token'] = $tokenObj->access_token;
        $viewModel['refresh_token'] = $tokenObj->refresh_token;
        $viewModel['terms'] = $terms;
        return Theme::make('activities.attendance.manual',$viewModel);
    }

    public function getStudentAttendance()
    {
        if(Request::ajax())
        {
            $session = Input::get('session');
            $class_id = Input::get('class_id');
            $section_id = Input::get('section_id');
            $attendance_date = Input::get('attendance_date');
            $registration = Registration::searchRegistration(array('session'=>$session,'class_id'=>$class_id,'section_id'=>$section_id),'');
            $attendanceObj = new Attendance();
            $attendance = $attendanceObj->getAttendance($registration,Helpers::dateTimeFormat("Y-m-d",$attendance_date));
            $response = array();
            $response['attendance'] = (!empty($attendance['attendance']))? $attendance['attendance']->toJson() : json_encode($attendance['attendance']);
            $response['type'] = $attendance['type'];

            $carbonAPi = new Carbon51();
            $api_state = $carbonAPi->hasSession();
            $accessToken = $carbonAPi->getAccessToken($api_state);
            $token = $carbonAPi->getRefreshToken($accessToken);
            $tokenObj = (!empty($token)) ? json_decode($token) : '';
            $response['clientid'] = $tokenObj->client_id;
            $response['access_token'] = $tokenObj->access_token;
            $response['refresh_token'] = $tokenObj->refresh_token;

            return json_encode($response);
        }
        else
        {
            Helpers::addMessage(500, 'Bad Request');
            $refUrl = 'activities/attendance';
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function changeAttendance()
    {
        if(Request::ajax())
        {
            date_default_timezone_set("Asia/Dhaka");
            $attendance = Input::get('attendance');
            $class_id = Input::get('class_id');
            $section_id = Input::get('section_id');
            $term       = Input::get('term');
            $id = Input::get('id');
            $attendance_date = Input::get('attendance_date');
            $attendanceObj = new Attendance();

            if($attendance)
            {
                $attendanceObj->addData($id,$class_id,$section_id,$attendance_date,$term);
            }else{
                $attendanceObj->removeData($id,$class_id,$section_id,$attendance_date);
            }
            return 1;
        }
    }

    public function automaticAttendance()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession
        );
        $viewModel['terms'] = Terms::GetTerms();
        return Theme::make('activities.attendance.upload',$viewModel);
    }

    public function saveAutomaticAttendance()
    {
        date_default_timezone_set('Asia/Dhaka');
        $refUrl =  Input::get('refurl');
        $attendance_sheet_bind = Option::getData('attendance_sheet_bind');
        $attendanceBindData = (!empty($attendance_sheet_bind))? json_decode($attendance_sheet_bind) : array();

        if(!count($attendanceBindData))
        {
            Helpers::addMessage(400, ' Csv File Binding is not matching Please Check in the settings');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }

        if (Request::isMethod('post')) {

            $attendance_date = Helpers::dateTimeFormat('Y-m-d',Input::get('attendance_date'));

            $refUrl =  Input::get('refurl');
            $term = Input::get('term');

            if(Input::hasFile('attendance_file'))
            {

                $ext = Input::file('attendance_file')->getClientOriginalExtension();
                $name = Input::file('attendance_file')->getClientOriginalName();

                $path = 'data/csv-attendance/';
                $name = $attendance_date.'_'.$name;

                if(in_array(strtolower($ext),array('csv','comma-separated-values','vnd.ms-excel'))){
                    Input::file('attendance_file')->move($path,$name);

                    $fh = fopen($path . $name, "r");
                    $row = 0;
                    while (($data = fgetcsv($fh)) !== FALSE) {

                        if ($row > 0 && (!empty($data[$attendanceBindData->user_id])) && (!empty($data[$attendanceBindData->in_time]))) {

                            if((strlen(trim($data[$attendanceBindData->in_time])) > 0))
                            {

                                $student_id = $data[$attendanceBindData->user_id];
                                $reg = Registration::where('student_id',$student_id)->where('active_reg',1)->where('deleted_at',0)->first();
                                if(count($reg))
                                {
                                    $in = $data[$attendanceBindData->in_time];
                                    $out = (!empty($data[$attendanceBindData->out_time]))? $data[$attendanceBindData->out_time] : '';
                                    $attendance_date = $attendance_date;
                                    $attendanceObj = new Attendance();

                                    if(!$attendanceObj->checkData($student_id,$reg->class_id,$reg->section_id,$attendance_date)){
                                        $attendanceObj->addData($student_id,$reg->class_id,$reg->section_id,$attendance_date,$term,$in,$out);
                                    }else{
                                        $attendanceObj->updateData($student_id,$reg->class_id,$reg->section_id,$attendance_date,$in,$out);
                                    }
                                }
                            }

                        }
                        $row++;
                    }
                }
                Helpers::addMessage(200, ' File Uploaded');

            }

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        } else {
            Helpers::addMessage(500, ' Bad Request');

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }

    }

    public function getStudentResult()
    {
        if(Request::ajax())
        {
            $session = Input::get('session');
            $class_id = Input::get('class_id');
            $section_id = Input::get('section_id');
            $term = trim(Input::get('term'));
            /*$registration = Registration::searchRegistration(array('session'=>$session,'class_id'=>$class_id,'section_id'=>$section_id),'');*/

            $results = ReportsData::getResult($class_id,$section_id,$session,$term);
            $response = array();
            $response['results'] = (!empty($results))? $results->toJson() : json_encode($results);


            $carbonAPi = new Carbon51();
            $api_state = $carbonAPi->hasSession();
            $accessToken = $carbonAPi->getAccessToken($api_state);
            $token = $carbonAPi->getRefreshToken($accessToken);
            $tokenObj = (!empty($token)) ? json_decode($token) : '';
            $response['clientid'] = $tokenObj->client_id;
            $response['access_token'] = $tokenObj->access_token;
            $response['refresh_token'] = $tokenObj->refresh_token;
           // Helpers::debug($response);die();
            return json_encode($response);
        }else{
            Helpers::addMessage(500, 'Bad Request');
            $refUrl = 'sms/sms-result';
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }


} 
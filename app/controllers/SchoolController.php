<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/20/14
 * Time: 2:00 PM
 */

class SchoolController extends BaseController{

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
        $this->default_route = 'school/index';
        $this->_userSession = Authenticate::check();  // check is user logged in
        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }


    /* Default Landing page */
    public function index()
    {
        $viewModel = array(

            'user'  => $this->_userSession

        );
        return Theme::make('settings.dashboard',$viewModel);
    }

    /* Organization Settings */
    public function orgInfo()
    {

        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession

        );
        return Theme::make('settings.school.org-info',$viewModel);
    }


    /* Update Org Info */
    public function updateOrgInfo(){
        if(Request::isMethod('post'))
        {
            Option::setData('vendor_name',Input::get('vendor_name'));
            Option::setData('vendor_address',Input::get('vendor_address'));
            Option::setData('vendor_email',Input::get('vendor_email'));
            Option::setData('vendor_phone',Input::get('vendor_phone'));
            Option::setData('vendor_code',Input::get('vendor_code'));

            if(Input::hasFile('file'))
            {
                $ext = Input::file('file')->getClientOriginalExtension();
                $name = Input::file('file')->getClientOriginalName();
                $path = 'data/logo/';
                $prefix = time();
                $name = $prefix.'_'.$name;
                if(in_array($ext,array('jpg','png','gif'))){
                    Input::file('file')->move($path,$name);
                    Option::setData('vendor_logo',$path.$name);
                }
            }
            Helpers::addMessage(200,' Information Updated');
            return Redirect::to('school/org-info');

        }else{
            Helpers::addMessage(500,' Bad Request');
            return Redirect::to('/');
        }
    }

    /* List of classes or render new class form */
    public function classes()
    {
        $param = Menu::getUri();
        $viewModel = array(
            'theme'   => Theme::getTheme(),
            'user'    => $this->_userSession,
            'classes' => SchoolClass::all()
        );

        if(isset($param[2]) && $param[2] == 'add')
        {
            $viewModel['class_types'] = array('PRIMARY'=>'Primary','HIGHSCHOOL'=>'High School', 'COLLEGE'=> 'College');
            return Theme::make('settings.school.classes.add',$viewModel);
        }else{
            $viewModel['class_types'] = array('PRIMARY'=>'Primary','HIGHSCHOOL'=>'High School', 'COLLEGE'=> 'College');
            return Theme::make('settings.school.classes.lists',$viewModel);
        }


    }

    /* Action to save new class info */
    public function saveClass()
    {
        if(Request::isMethod('post'))                   // if request is post
        {
            $refUrl =  Input::get('refurl');
            $className = Input::get('class_name');
            $classCode = Input::get('class_code');
            $classType = Input::get('class_type');

            $schoolClass = SchoolClass::firstOrNew(array('class_name' => $className,'class_code'=>$classCode));
            if(!$schoolClass->exists)
            {
                $schoolClass->class_type = $classType;
                $schoolClass->save();
                Helpers::addMessage(200,$className. ' was Successfully Added');
            }else{
                Helpers::addMessage(400,$className.' was already created');
            }

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');

        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to(refUrl) : Redirect::to('/');
        }
    }

    /* Action to update class info */
    public function updateClass()
    {
        if(Request::isMethod('post'))
        {
            $class = SchoolClass::find(Input::get('class_id'));
            if(count($class))
            {
                $className =  Input::get('class_name');
                $classCode =  Input::get('class_code');
                $classType =  Input::get('class_type');
                SchoolClass::where('class_id',$class->class_id)
                            ->update(array('class_name'=>$className,
                                           'class_code'=>$classCode,
                                           'class_type'=>$classType));
                Helpers::addMessage(200,' Information Updated');
            }else{
                Helpers::addMessage(400,' Information not updated');
            }
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }

    }


    /* List of sections or render new section form */
    public function section()
    {
        $param = Menu::getUri();
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'classes' => SchoolClass::all(),
            'shifts'   => SchoolShift::all(),
        );
        if(isset($param[2]) && $param[2] == 'add')
        {

            return Theme::make('settings.school.section.add',$viewModel);

        }elseif(isset($param[2]) && $param[2] == 'edit'){

            $id = (int)Request::segment(4);
            $viewModel['section'] = SchoolSection::find($id);
            return Theme::make('settings.school.section.edit',$viewModel);
        }else{
            $viewModel['sections'] = SchoolSection::all();
            return Theme::make('settings.school.section.lists',$viewModel);
        }
    }

    /* Action to save new section info */
    public function saveSection()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $sectionName = Input::get('section_name');
            $classId     = Input::get('class_id');
            $shiftId     = Input::get('shift_id');

            $schoolSection = SchoolSection::firstOrNew(array('section_name' => $sectionName,'class_id'=>$classId,'shift_id'=>$shiftId));
            if(!$schoolSection->exists)
            {
                $schoolSection->save();
                Helpers::addMessage(200,$sectionName. ' was Successfully Added');
            }else{
                Helpers::addMessage(400,$sectionName.' was already created');
            }

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');

        }
        else
        {
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to(refUrl) : Redirect::to('/');

        }
    }

    /* Action to update section info */
    public function updateSection()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $id = (int)Input::get('section_id');
            $sectionName = Input::get('section_name');
            $classId = Input::get('class_id');
            $shiftId = Input::get('shift_id');

            // check record exist for update
            $sectionExist = SchoolSection::find($id);
            if(count($sectionExist))
            {
                // check if information exist with updated info
                $section = SchoolSection::firstOrNew(array('section_name'=>$sectionName,'class_id'=>$classId,'shift_id'=>$shiftId));

                if(!$section->exists)
                {
                    $section->where('section_id',$sectionExist->section_id)->update(array('section_name'=>$sectionName,'class_id'=>$classId,'shift_id'=>$shiftId));
                    Helpers::addMessage(200,' Infomration Updated');
                }
                else{
                    Helpers::addMessage(400,' Record already exist information unchanged');
                }

            }else{

                Helpers::addMessage(400,' Section not found');

            }
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
        else
        {
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to(refUrl) : Redirect::to('/');
        }
    }

    /* List of subjects or render new subject form */
    public function subject()
    {
        $param = Menu::getUri();
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession
        );
        if(isset($param[2]) && $param[2] == 'add')
        {
            $viewModel['classes'] = SchoolClass::all();
            $viewModel['groups'] = SchoolGroup::all();
            $viewModel['subjectSuggestions'] = SchoolSubject::getSubjectSuggestions();
            $viewModel['terms'] = explode(',',Option::getData('terms'));
            return Theme::make('settings.school.subject.add',$viewModel);
        }elseif(isset($param[2]) && $param[2] == 'edit')
        {
            $id = (int)Request::segment(4);
            $subject = SchoolSubject::find($id);
            if(!$subject)
            {
                Helpers::addMessage(400, ' No Record found');
                return Redirect::to('school/subject');
            }
            $viewModel['classes'] = SchoolClass::all();
            $viewModel['groups'] = SchoolGroup::all();
            $viewModel['subjectSuggestions'] = SchoolSubject::getSubjectSuggestions();
            $viewModel['viewSubject'] =$subject;
            $viewModel['terms'] = explode(',',Option::getData('terms'));

            return Theme::make('settings.school.subject.edit',$viewModel);
        }else{
            $viewModel['subjects'] = SchoolSubject::all();
            $viewModel['subject_status'] = array('1'=>'First Subject','2'=>'Second Subject','3'=>'Third Subject');
            return Theme::make('settings.school.subject.lists',$viewModel);
        }
    }

    /* Action to save new section info */
    public function saveSubject()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $subjectName = Input::get('subject_name');
            $classId     = Input::get('class_id');
            $groupId     = Input::get('group_id');
            $subjectOrder = Input::get('display_order');
            $subjectStatus = Input::get('subject_status');
            $subjectInitial = Input::get('subject_initial');
            $subjectCode = Input::get('subject_code');
            $full_mark = json_encode( Input::get('full_mark'));
            $pass_mark = json_encode( Input::get('pass_mark'));
            $show_pass_mark = Input::get('show_pass_mark');
            $subject_dependency = Input::get('subject_dependency');
         //   print_r();die();

            $schoolSubject = SchoolSubject::firstOrNew(array('subject_name' => $subjectName,'class_id'=>$classId,'group_id'=>$groupId,'subject_status'=>$subjectStatus,'subject_initial'=>$subjectInitial,'subject_code'=>$subjectCode));

            if(!$schoolSubject->exists)
            {
                $schoolSubject->subject_dependency = $subject_dependency;
                $schoolSubject->subject_order = $subjectOrder;
                $schoolSubject->full_mark = $full_mark;
                $schoolSubject->pass_mark = $pass_mark;
                $schoolSubject->show_pass_mark = $show_pass_mark;
                $schoolSubject->save();
                Helpers::addMessage(200,$subjectName. ' was Successfully Added');
            }else{
                Helpers::addMessage(400,$subjectName.' was already created');
            }

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');

        }
        else
        {
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to(refUrl) : Redirect::to('/');

        }
    }


    /* Action to update subject info */
    public function updateSubject()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $id = (int)Input::get('subject_id');
            $subjectName = Input::get('subject_name');
            $classId = Input::get('class_id');
            $groupId = Input::get('group_id');
            $displayOrder = Input::get('display_order');
            $subjectStatus = Input::get('subject_status');
            $subjectInitial = Input::get('subject_initial');
            $subjectCode = Input::get('subject_code');
            $full_mark = json_encode( Input::get('full_mark'));
            $subject_dependency = Input::get('subject_dependency');
            $pass_mark = json_encode( Input::get('pass_mark'));
            $show_pass_mark = (boolean)Input::get('show_pass_mark');

            // check record exist for update
            $subjectExist = SchoolSubject::find($id);
            if(count($subjectExist))
            {
                // check if information exist with updated info

                    SchoolSubject::where('subject_id',$subjectExist->subject_id)->update(array('subject_name'=>$subjectName,'class_id'=>$classId,
                        'group_id'=>$groupId,'subject_order'=>$displayOrder,'full_mark'=>$full_mark,'pass_mark'=>$pass_mark,'show_pass_mark'=>$show_pass_mark,
                        'subject_status'=>$subjectStatus,'subject_initial'=>$subjectInitial,'subject_dependency'=>$subject_dependency,'subject_code'=>$subjectCode));
                    Helpers::addMessage(200,' Infomration Updated');



            }else{

                Helpers::addMessage(400,' Section not found');

            }

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
        else
        {
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to(refUrl) : Redirect::to('/');
        }
    }

    public function deleteSubject()
    {
        if(Request::ajax())
        {
            $id = Input::get('id');
            $subject = SchoolSubject::find($id);
            if(count($subject))
                $subject->delete();
            return 1;
        }else{
            return Redirect::to('school/subject');
        }
    }

    /* Shift and Group settings render view */
    public function shiftGroup()
    {
        $param = Menu::getUri();
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'shifts' => SchoolShift::all(),
            'groups' => SchoolGroup::all()
        );
        return Theme::make('settings.school.shift-group',$viewModel);

    }

    /* Action to save new Shift info */
    public function saveShift()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $shiftName = Input::get('shift_name');

            $schoolShift = SchoolShift::firstOrNew(array('shift_name'=>$shiftName));
            if(!$schoolShift->exists)
            {
                $schoolShift->save();
                Helpers::addMessage(200,$shiftName. ' was Successfully Added');
            }else{
                Helpers::addMessage(400,$shiftName.' was already created');
            }

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');

        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    /* Action to update shift info */
    public function updateShift()
    {
        if(Request::isMethod('post'))
        {
            $shift = SchoolShift::find(Input::get('shift_id'));
            if(count($shift))
            {
                SchoolShift::where('shift_id',$shift->shift_id)->update(array('shift_name'=>Input::get('shift_name')));
                Helpers::addMessage(200,' Information Updated');
            }else{
                Helpers::addMessage(400,' Information not updated');
            }
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }

    }



    /* Action to save new Group info */
    public function saveGroup()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $groupName = Input::get('group_name');

            $schoolGroup = SchoolGroup::firstOrNew(array('group_name'=>$groupName));
            if(!$schoolGroup->exists)
            {
                $schoolGroup->save();
                Helpers::addMessage(200,$groupName. ' was Successfully Added');
            }else{
                Helpers::addMessage(400,$groupName.' was already created');
            }

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');

        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    /* Action to update group info */
    public function updateGroup()
    {
        if(Request::isMethod('post'))
        {
            $group = SchoolGroup::find(Input::get('group_id'));
            if(count($group))
            {
                SchoolGroup::where('group_id',$group->group_id)->update(array('group_name'=>Input::get('group_name')));
                Helpers::addMessage(200,' Information Updated');
            }else{
                Helpers::addMessage(400,' Information not updated');
            }
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }

    }

    /* General settings */
    public function general()
    {
        $id = Request::segment(3);
        if($id == 'Debug')
        {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'attendance_default' => Option::getData('attendance_default'),
            'present'  => Option::getData('present'),
            'absent'   => Option::getData('absent'),
            'attendance_sheet_bind' => Option::getData('attendance_sheet_bind'),
            'aptitudes' => Option::getData('aptitudes'),
            'app_mode'  => Option::getData('app_mode'),
            'terms'     => Option::getData('terms'),
            'daily_sms_limit' => Option::getData('daily_sms_limit'),
            'teacher_sms_option'=> Option::getData('teacher_sms_option'),
            'student_sms_option'=> Option::getData('student_sms_option'),
            'notice_sms_option' => Option::getData('notice_sms_option'),
            'attendance_sms_option'=>Option::getData('attendance_sms_option')
        );

        return Theme::make('settings.school.general',$viewModel);
        }else{
            return Redirect::to('/');
        }
    }

    /* Action to update general settings */
    public function updateGeneralSettings()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $attendanceDefault = Input::get('attendance_default');
            Option::setData('attendance_default',$attendanceDefault);
            $user_id = Input::get('uid');
            $inttime = Input::get('intime');
            $outtime = Input::get('outtime');
            $attendance_sheet_bind = json_encode(array('user_id'=>$user_id,'in_time'=>$inttime,'out_time'=>$outtime));
            Option::setData('attendance_sheet_bind',$attendance_sheet_bind);
            Helpers::addMessage(200,' Settings Updated');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');

        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }


    }

    public function updateAttendanceOption()
    {
        if(Request::ajax())
        {
            $field = Input::get('field');
            $type = Input::get('type');
            return Option::setData($field,$type);
        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  '';
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function changeAppMode()
    {
        if(Request::ajax())
        {
            $appMode = Input::get('appmode');
            return Option::setData('app_mode',$appMode);
        }
    }

    /* List of periods and render period form */
    public function period()
    {
        $param = Menu::getUri();
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession
        );
        if(isset($param[2]) && $param[2] == 'add')
        {
            $viewModel['classes'] = SchoolClass::all();
            $viewModel['periods'] = SchoolPeriod::getPeriodSuggestions();
            return Theme::make('settings.school.period.add',$viewModel);
        }elseif(isset($param[2]) && $param[2] == 'edit'){
            $id = (int)Request::segment(4);
            $viewModel['classes'] = SchoolClass::all();
            $viewModel['class_period'] = ClassesPeriod::find($id);
            return Theme::make('settings.school.period.edit',$viewModel);
        }
        else{
            $classPeriods = ClassesPeriod::all();
            //Helpers::debug($classPeriods,'',0,1);
            $viewModel['class_periods'] = $classPeriods;
            return Theme::make('settings.school.period.lists',$viewModel);
        }
    }

    public function savePeriod()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $periodName = Input::get('period_name');
            $noOfPeriod = Input::get('no_of_period');
            $classId = Input::get('class_id');
            $sectionId = Input::get('section_id');
            $startTimes = Input::get('start');
            $endTimes = Input::get('end');
            $periodDetails = array('periodCount'=>$noOfPeriod,'start'=>$startTimes,'end'=>$endTimes);
            $period_status = 0;
            if(!empty($classId) && !empty($sectionId))
            {
                $period_status = 1;
            }


            $period = SchoolPeriod::firstOrNew(array('period_name'=>$periodName,'period_details'=>json_encode($periodDetails)));

            if(!$period->exists)
            {
                $period->period_status = $period_status;
                $period->save();
                if(!empty($classId) && !empty($sectionId))
                {
                   $classesPeriod =  ClassesPeriod::firstOrNew(array('period_id'=>$period->period_id,'class_id'=>$classId,'section_id'=>$sectionId));
                   if(!$classesPeriod->exists)
                        $classesPeriod->save();
                }
                Helpers::addMessage(200,$periodName. ' was Successfully Added');

            }else{

                if(!empty($classId) && !empty($sectionId))
                {
                    SchoolPeriod::where('period_id',$period->period_id)->update(array('period_status'=>1));

                    $classesPeriod =  ClassesPeriod::firstOrNew(array('period_id'=>$period->period_id,'class_id'=>$classId,'section_id'=>$sectionId));

                    if(!($classesPeriod->exists))
                        $classesPeriod->save();
                }

                Helpers::addMessage(200,' Class and Section settings for this period updated');

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

    /* Action to update period info */
    public function updatePeriod()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $periodName = Input::get('period_name');
            $period_id = (int)Input::get('period_id');
            $classesPeriodId = (int)Input::get('classes_period_id');
            $noOfPeriod = Input::get('no_of_period');
            $classId = Input::get('class_id');
            $sectionId = Input::get('section_id');
            $startTimes = Input::get('start');
            $endTimes = Input::get('end');
            $periodDetails = array('periodCount'=>$noOfPeriod,'start'=>$startTimes,'end'=>$endTimes);

            $period = SchoolPeriod::find($period_id);
            if(count($period))
            {
                SchoolPeriod::where('period_id',$period->period_id)->update(array('period_name'=>$periodName,'period_details'=>json_encode($periodDetails)));
            }

            $classesPeriod = ClassesPeriod::find($classesPeriodId);
            if(count($period) && count($classesPeriod))
            {
                if(!empty($classId) && !empty($sectionId) && !empty($period_id))
                {
                    ClassesPeriod::where('classes_period_id',$classesPeriodId)->update(array('class_id'=>$classId,'section_id'=>$sectionId,'period_id'=>$period->period_id));
                }
            }
            
            Helpers::addMessage(200,' Information updated');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
        else
        {
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function teacherAssign()
    {
        $segment = Request::segment(3);
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'classes' => SchoolClass::all(),
            'sections' => SchoolSection::all()

        );
        if($segment == "add"){
            $viewModel['teachers'] = Teacher::where('deleted_at',0)->get();
            return Theme::make('settings.school.teacher.teacher-assign',$viewModel);
        }
        else if ($segment == "edit")
        {
             $id = (int)Request::segment(4);
             $teacherAssign = TeacherAssign::find($id);
             $viewModel['teacherAssign'] =$teacherAssign;
             $viewModel['subeject'] = SchoolSubject::find($teacherAssign->subject_id);
            return Theme::make('settings.school.teacher.teacher-assign-edit',$viewModel);
        }
        else if($segment == "trash")
        {
            $viewModel['teachers'] = TeacherAssign::where('deleted_at','>',0)->get();
            return Theme::make('settings.school.teacher.teacher-assign-trash',$viewModel);
        }
        else
        {
            $viewModel['teachers'] = TeacherAssign::where('deleted_at',0)->get();
            return Theme::make('settings.school.teacher.teacher-assign-list',$viewModel);
        }

    }


    public function saveTeacherAssign()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $teacher_id = Input::get('teacher_id');
            $subject_id = Input::get('subject_id');
            $section_id = Input::get('section_id');
            $class_id   = Input::get('class_id');
            $teacher = Teacher::find($teacher_id);
            if(count($teacher))
            {

                $teacher_assign =   TeacherAssign::firstOrNew(array('teacher_id'=>$teacher_id,'subject_id'=>$subject_id,'section_id'=>$section_id,'deleted_at'=>0));
                $isClassTeacherAssign = TeacherAssign::firstOrNew(array('section_id'=>$section_id,'class_teacher'=>$class_id,'deleted_at'=>0));
                $isTeacherAlreadyAssign = TeacherAssign::firstOrNew(array('section_id'=>$section_id,'subject_id'=>$subject_id,'deleted_at'=>0));
                if(!$teacher_assign->exists ){
                    if($isTeacherAlreadyAssign->exists){
                        Helpers::addMessage(400,$isTeacherAlreadyAssign->getTeacher->name.' already assigned for this subject.');
                        return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
                    }
                    $teacher_assign->status = Input::get('teacher_assign_status');
                    $teacher_assign->session = date("Y");

                    $teacherUpdate = array();
                    $classTeacher = Input::get('class_teacher');
                    if($classTeacher){
                        if(!$isClassTeacherAssign->exists){
                            $teacher_assign->class_teacher  = $class_id;
                            $teacherUpdate['class_teacher'] = $class_id;
                        }

                    }
                    $assigned = $teacher_assign->save();
                    if($assigned)
                    {
                        $teacherUpdate['assigned_status'] = 1;
                        Teacher::where('id',$teacher->id)->update($teacherUpdate);
                    }
                    $section = SchoolSection::find($section_id);
                    $class = $section->getClass;
                    if($isClassTeacherAssign->exists && !empty($classTeacher))
                        Helpers::addMessage(400,$isClassTeacherAssign->getTeacher->name.' already assigned as class teacher for this subject. So '.$teacher->name.' was assigned as subject teacher');
                    else
                        Helpers::addMessage(200, $teacher->name.' assigned to section-'.$section->section_name. ' of  class -'.$class->class_name);
                }else{
                    Helpers::addMessage(400,' Teacher Already assigned');
                }
            }else{
                Helpers::addMessage(400,' Teacher Id '.$teacher_id.' not exist');
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


    public function updateTeacherAssign()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $subject_id = Input::get('subject_id');
            $section_id = Input::get('section_id');

            $teacher_assign_status = Input::get('teacher_assign_status');
            $class_teacher = Input::get('class_teacher');
            $id = (int)Input::get('id');
            $teacher_id = Input::get('teacher_id');
            $teacherAssign = TeacherAssign::find($id);
            if($teacherAssign)
            {
                $exists = TeacherAssign::where('teacher_id',$teacher_id)->where('subject_id',$subject_id)->
                    where('section_id',$section_id)->where('deleted_at',0)->get();
                Helpers::debug(count($exists));
                if(count($exists)){
                    Helpers::addMessage(400,'Information already exits');
                    return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
                }
                $updateData = array();
                $updateData['subject_id'] = $subject_id;
                $updateData['section_id'] = $section_id;
                $updateData['status'] = $teacher_assign_status;

                if(!empty($class_teacher))
                {

                    Teacher::where('id',$teacher_id)->update(array('class_teacher'=> Input::get('class_id')));
                    $updateData['class_teacher'] = Input::get('class_id');
                    TeacherAssign::where('teacher_assign_id',$id)->update($updateData);

                }else{
                    $updateData['class_teacher'] = 0;
                    Teacher::where('id',$teacher_id)->update(array('class_teacher'=>0));
                    TeacherAssign::where('teacher_assign_id',$id)->update($updateData);
                }

                Helpers::addMessage(200,'Information updated');

            }
            else
            {
                Helpers::addMessage(400,'Information was unchanged');
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


    public function deleteTeacherAssign()
    {
        if(Request::ajax())
        {
            $id = (int)Input::get('id');
            $teacherAssign = TeacherAssign::find($id);
            if(count($teacherAssign))
            {
                TeacherAssign::where('teacher_assign_id',$id)->update(array('deleted_at'=>time()));
                Helpers::addMessage(200, " Information was trashed");
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

    // clean teacher assign trash
    public function clearTrashTeacherAssign()
    {
        if(Request::isMethod('post'))
        {
            TeacherAssign::where('deleted_at','>',0)->delete();
            Helpers::addMessage(200, " Trash Clean");
        }else{
            Helpers::addMessage(500 , " Bad Request");

        }
        return Redirect::to('school/teacher-assign/trash');
    }

    public function routine()
    {
        date_default_timezone_set('Asia/Dhaka');
        $current =  '';
        $today = time();

        $viewModel = array(
            'theme'   => Theme::getTheme(),
            'user'    => $this->_userSession,
            'classes' => SchoolClass::all()
        );
        
        if(Request::isMethod('post'))
        {
            $time = Input::get('day');
            $day = Input::get('dayBtn');
            $today = Input::get('current');
            if($day == "Prev")
            {

                $current = ($today - (60*60*24));

            }
            else if($day == "Next")
            {
                $current = ($today + (60*60*24));

            }


        }

        $viewModel['next'] = ($today + (60*60*24));
        $viewModel['prev'] = ($today - (60*60*24));
        $viewModel['current'] = (!empty($current))? $current : time();

        return Theme::make('routine.class.index',$viewModel);
    }

    public function totalClass()
    {

        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession
        );
        $viewModel['totalClasses'] = TotalClass::with('getClass','getSection')->get();
        $viewModel['classes'] = SchoolClass::all();
        $viewModel['terms']   = Terms::GetTerms();
        return Theme::make('settings.school.total-class',$viewModel);
    }

    public function saveTotalClass()
    {
        if(Request::isMethod('post'))
        {
            $classId = Input::get('class_id');
            $sectionId = Input::get('section_id');
            $term = Input::get('term');
            $session = Input::get('session');

            $totalClass = TotalClass::firstOrNew(array('class_id'=>$classId,'section_id'=>$sectionId,'term'=>$term,'session'=>$session));
            $totalClass->no_of_class = Input::get('noOfClass');
            $totalClass->save();

            Helpers::addMessage(200, "No of classes successfull saved");
            return Redirect::to('school/total-class');

        }else{

            return Redirect::to('/');

        }
    }

    public function deleteTotalClass($id)
    {

            $totalClass = TotalClass::find($id);
            $totalClass->delete();
            Helpers::addMessage(200, "Successfully Deleted");
            return Redirect::to('school/total-class');        
    }


} 

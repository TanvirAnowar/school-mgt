<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/19/14
 * Time: 3:20 PM
 */

class SettingsController extends BaseController{

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
        $this->default_route = 'settings/index';
        $this->pageLimit = 20;
        $this->_userSession = Authenticate::check();  // check is user logged in
        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }

    public function index()
    {
        $viewModel = array();
        return Theme::make('settings.dashboard',$viewModel);
    }

    public function mark()
    {
        $segment = Request::segment(3);
        $id = (int)Request::segment(4);
        $viewModel = array(

            'user'  => $this->_userSession,
            'classes' => SchoolClass::all(),
            'mark_types' => MarkTypes::all(),
            'terms' => explode(',',Option::getData('terms'))

        );
        //Helpers::debug($viewModel['terms']);die();
        if($segment == 'edit')
        {
            $markSettings =  MarkSettings::find($id);
            $viewModel['mark_setting'] = (count($markSettings))? $markSettings : array();
            return Theme::make('settings.exam-mark.mark-edit',$viewModel);
        }
        elseif($segment == 'trash')
        {
            $settings = MarkSettings::where('deleted_at','>',0)->get();

            $viewModel['mark_settings'] = $settings;
            return Theme::make('settings.exam-mark.mark-trash',$viewModel);
        }
        else
        {
            $settings = MarkSettings::where('deleted_at','=',0)->get();
            $viewModel['terms'] = Terms::GetTerms(); 
            $viewModel['mark_settings'] = $settings;
            return Theme::make('settings.exam-mark.mark',$viewModel);
        }

    }

    public function additional()
    {
        $aptitudes = Option::getData('aptitudes');

        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user' => $this->_userSession,
            'classes' => SchoolClass::all(),
            'aptitudes' => (!empty($aptitudes)) ? explode(',',$aptitudes) : array(),
            'grades' => Grades::aptitudeGrades()
        );
        return Theme::make('settings.exam-mark.additional',$viewModel);
    }


    public function grades()
    {
        $segment = Request::segment(3);
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession);
        if($segment == 'add')
        {
            $viewModel['classes']  = SchoolClass::all();
            $grades =  Grades::getGrades();

            $viewModel['grades']   = $grades;
            return Theme::make('settings.exam-mark.grade-add',$viewModel);

        }else if($segment == 'edit'){
            $viewModel['classes']  = SchoolClass::all();
            $id = (int)Request::segment(4);
            $grade =  Grades::find($id);
            if(count($grade))
            {
                $viewModel['grade'] = $grade;
                $grades =  Grades::getGrades();

                $viewModel['grades']   = $grades;
                return Theme::make('settings.exam-mark.grade-edit',$viewModel);

            }else{

                Helpers::addMessage(400,' Record not found');
                return Redirect::to('settings/grades');
            }
        }elseif($segment == 'trash'){
            $viewModel['grades']  = Grades::where('deleted_at','>',0)->get();
            return Theme::make('settings.exam-mark.grades-trash',$viewModel);
        }
        else{

            $viewModel['grades']  = Grades::where('deleted_at',0)->get();

            return Theme::make('settings.exam-mark.grades',$viewModel);
        }

    }

    public function saveGradeSettings()
    {
        if(Request::isMethod('post'))
        {

            $refUrl = Input::get('refurl');
            $class_id = Input::get('class_id');
            $grade = Input::get('grade');
            $mark = Input::get('mark');
            $point = Input::get('point');
            $gradeObj = Grades::firstOrNew(array('class_id'=>$class_id,'grade'=>$grade,'point'=>$point,'mark'=>$mark));
            if(!$gradeObj->exists)
            {
                $gradeObj->save();
                Helpers::addMessage(200, ' Information was added');
            }else{
                Helpers::addMessage(400, ' Information already exist');
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


    public function updateGradeSettings()
    {
        if(Request::isMethod('post'))
        {
            $refUrl = Input::get('refurl');
            $class_id = Input::get('class_id');
            $grade = Input::get('grade');
            $mark = Input::get('mark');
            $point = Input::get('point');
            $id = Input::get('grade_id');
            $result = Grades::find($id);
            if(count($result))
            {
                $updated = Grades::where('grade_id',$result->grade_id)->update(array('class_id'=>$class_id,'grade'=>$grade,'point'=>$point,'mark'=>$mark));
                if($updated)
                {
                    Helpers::addMessage(200,' Information updated');
                }
                else
                {
                    Helpers::addMessage(400,' Information unchanged');
                }

            }else{

                Helpers::addMessage(400,' No record found');
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

    public function deleteGradeSetting()
    {
        if(Request::isMethod('post'))
        {
            $id = (int)Input::get('id');

            $grade = Grades::find($id);

            if(count($grade))
            {
                $updated = Grades::where('grade_id',$id)->update(array('deleted_at'=>time()));
                if($updated)
                {
                    Helpers::addMessage(200,' Information was deleted');
                    return json_encode(array('status'=>200));
                }else{
                    Helpers::addMessage(400,' Information was not deleted');
                    return json_encode(array('status'=>400));
                }
            }else{
                Helpers::addMessage(400,' Record not found');
                return json_encode(array('status'=>400));
            }

        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl = url('settings/grades');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function undoDeleteGradeSetting()
    {
        if(Request::isMethod('post'))
        {
            $id = (int)Input::get('id');

            $grade = Grades::find($id);

            if(count($grade))
            {
                $updated = Grades::where('grade_id',$id)->update(array('deleted_at'=>0));
                if($updated)
                {
                    Helpers::addMessage(200,' Information was retrieved');
                    return json_encode(array('status'=>200));
                }else{
                    Helpers::addMessage(400,' Information was not retrieved');
                    return json_encode(array('status'=>400));
                }
            }else{
                Helpers::addMessage(400,' Record not found');
                return json_encode(array('status'=>400));
            }

        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl = url('settings/grades');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }


    public function saveMarkSettings()
    {
        if(Request::isMethod('post'))
        {
            $refUrl = Input::get('refurl');
            $class_id = Input::get('class_id');

            $subject_id   = Input::get('subject_id');
            $mark_type_id = Input::get('mark_type_id');
            $pass         = Input::get('pass');
           // $convert_at   = Input::get('convert_at');

            $markSettings = MarkSettings::firstOrNew(array('class_id'=>$class_id,'subject_id'=>$subject_id,'mark_type_id'=>$mark_type_id,'deleted_at'=>0));

            if(!$markSettings->exists)
            {
                $markSettings->pass = json_encode($pass);
                //$markSettings->convert_at = $convert_at;
                $markSettings->save();
                Helpers::addMessage(200, ' Mark settings was added');

            }else{

                $class = SchoolClass::find($class_id);
                $subject = SchoolSubject::find($subject_id);
                $type = MarkTypes::find($mark_type_id);
                Helpers::addMessage(400,'Mark settings for '.$class->class_name.'-'.$subject->subject_name.'-'.$type->mark_type.' already exist');
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

    public function updateMarkSettings()
    {
        if(Request::isMethod('post'))
        {
            $refUrl = Input::get('refurl');
            $id = Input::get('mark_settings_id');
            $class_id = Input::get('class_id');
            $subject_id = Input::get('subject_id');
            $mark_type_id = Input::get('mark_type_id');
            $pass = Input::get('pass');
            $convert_at = Input::get('convert_at');
            $settings = MarkSettings::find($id);
            if(count($settings))
            {
               $updated = MarkSettings::where('mark_settings_id',$id)->update(array('class_id'=>$class_id,
                                            'subject_id'=>$subject_id,'mark_type_id'=>$mark_type_id,
                                            'pass'=>json_encode($pass),'convert_at'=>$convert_at));
                if($updated)
                {
                    Helpers::addMessage(200,' Information was updated');
                }
                else
                {
                    Helpers::addMessage(400,' Information unchanged');
                }

            }
            else
            {
                Helpers::addMessage(400,' Record not found');
            }
            MarkSettings::where('mark_settings_id',$id);

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
        else
        {
            Helpers::addMessage(500,' Bad Request');
            $refUrl = Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function deleteMarkSetting()
    {
        if(Request::isMethod('post'))
        {
            $id = (int)Input::get('id');

            $markSettings = MarkSettings::find($id);

            if(count($markSettings))
            {
               $updated = MarkSettings::where('mark_settings_id',$id)->update(array('deleted_at'=>time()));
               if($updated)
               {
                   Helpers::addMessage(200,' Information was deleted');
                   return json_encode(array('status'=>200));
               }else{
                   Helpers::addMessage(400,' Information was not deleted');
                   return json_encode(array('status'=>400));
               }
            }else{
                Helpers::addMessage(400,' Record not found');
                return json_encode(array('status'=>400));
            }

        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl = Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function undoDeleteMarkSetting()
    {
        if(Request::isMethod('post'))
        {
            $id = (int)Input::get('id');

            $markSettings = MarkSettings::find($id);

            if(count($markSettings))
            {
               $updated = MarkSettings::where('mark_settings_id',$id)->update(array('deleted_at'=>0));
               if($updated)
               {
                   Helpers::addMessage(200,' Information was retrieved');
                   return json_encode(array('status'=>200));
               }else{
                   Helpers::addMessage(400,' Information was not deleted');
                   return json_encode(array('status'=>400));
               }
            }else{
                Helpers::addMessage(400,' Record not found');
                return json_encode(array('status'=>400));
            }

        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl = Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function deleteTrashMarkSetting()
    {
        if(Request::isMethod('post'))
        {
            $id = (int)Input::get('id');

            $markSettings = MarkSettings::find($id);

            if(count($markSettings))
            {
                $deleted = MarkSettings::where('mark_settings_id',$id)->where('deleted_at','>',0)->delete();

                if($deleted)
                {
                    //Helpers::addMessage(200,' Information was deleted');
                    return json_encode(array('status'=>200));
                }else{
                    //Helpers::addMessage(400,' Information was not deleted');
                    return json_encode(array('status'=>400));
                }
            }else{
                Helpers::addMessage(400,' Record not found');
                return json_encode(array('status'=>400));
            }

        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl = Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function clearTrashMarkSettings()
    {
        if(Request::isMethod('post'))
        {
            MarkSettings::where('deleted_at','>',0)->delete();
            Helpers::addMessage(200, " Trash Clean");
        }
        else
        {
            Helpers::addMessage(500, " Bad Request");
        }
        return Redirect::to('settings/mark/trash');
    }

    public function markType()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'mark_types' => MarkTypes::all(),
        );
        return Theme::make('settings.exam-mark.mark-type',$viewModel);
    }

    public function saveMarkType()
    {
        if(Request::isMethod('post'))
        {
            $refUrl = Input::get('refurl');
            $markType = Input::get('mark_type');
            $markTypeOrder = Input::get('mark_type_order');
            $markTypes = MarkTypes::firstOrNew(array('mark_type'=>$markType));
            if(!$markTypes->exists)
            {
                $markTypes->mark_type_order = $markTypeOrder;
                $markTypes->save();
                Helpers::addMessage(200,' Information was added');
            }
            else
            {
                Helpers::addMessage(400,' Mark type already exist');
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

    public function updateMarkType()
    {
        if(Request::isMethod('post'))
        {

            $refUrl = Input::get('refurl');
            $markType = Input::get('mark_type');
            $markTypeOrder = Input::get('mark_type_order');
            $id = (int)Input::get('mark_type_id');
            $markTypes = MarkTypes::find($id);
            if(count($markTypes))
            {

                $updated = MarkTypes::where('mark_type_id',$id)->update(array('mark_type'=>$markType,'mark_type_order'=>$markTypeOrder));

                if($updated)
                {
                    Helpers::addMessage(200,' Information was updated');
                }
                else
                {
                    Helpers::addMessage(400,' Information was unchanged');
                }
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

    /* Action to update general settings */
    public function updateGeneralSettings()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $aptitudes = Input::get('aptitudes');
            $terms = Input::get('terms');
            $dailySmsLimit = Input::get('daily_sms_limit');
            $teacher_sms_option = (Input::get('teacher_sms_option') != null) ? 1 : 0;
            $student_sms_option = (Input::get('student_sms_option') != null) ? 1 : 0;
            $notice_sms_option  = (Input::get('notice_sms_option') != null) ? 1 : 0;
            $attendance_sms_option = (Input::get('attendance_sms_option') != null) ? 1 : 0;

            Option::setData('daily_sms_limit',$dailySmsLimit);
            Option::setData('teacher_sms_option',$teacher_sms_option);
            Option::setData('student_sms_option',$student_sms_option);
            Option::setData('notice_sms_option',$notice_sms_option);
            Option::setData('attendance_sms_option',$attendance_sms_option);

            Option::setData('aptitudes',$aptitudes);
            Option::setData('terms',$terms);
            Helpers::addMessage(200,' Settings Updated');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');

        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }


    }

    public function combineMark()
    {
        $segment = Request::segment(3);
        $viewModel = array(
          'theme' => Theme::getTheme(),
          'user'  => $this->_userSession,
          'classes' => SchoolClass::all(),
          'mark_types' => MarkTypes::all(),
          'combineMarkSettings' => CombineMarkSettings::where('deleted_at',0)->get()
        );
        if($segment == 'edit')
        {
            $id = Request::segment(4);

            $combineMarkSettings = CombineMarkSettings::find($id);

            if(count($combineMarkSettings))
            {
                $viewModel['combineMarkSettings'] = $combineMarkSettings;
                return Theme::make('settings.combine-mark.combine-mark-edit',$viewModel);
            }else{
                return Redirect::to('settings/combineMark');
            }

        }else{

            return Theme::make('settings.combine-mark.combine-mark-create',$viewModel);

        }
    }

    public function combineMarkTrash()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'classes' => SchoolClass::all(),
            'mark_types' => MarkTypes::all(),
            'combineMarkSettings' => CombineMarkSettings::where('deleted_at','>',0)->get()
        );
        return Theme::make('settings.combine-mark.combine-mark-trash',$viewModel);
    }

    public function saveCombineMark()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $title = Input::get('title');
            $class_id = Input::get('class_id');
            $mark_type_id = Input::get('mark_type_id');
            $pass = Input::get('pass');
            $subjects = Input::get('subject_id');
            $convert_at = Input::get('convert_at');

            $combineMarkSettings =  CombineMarkSettings::firstOrNew(array('title'=>$title,'class_id'=>$class_id,'mark_type_id'=>$mark_type_id,'deleted_at'=>0));

            if(!$combineMarkSettings->exists)
            {
                $combineMarkSettings->pass = $pass;
                $combineMarkSettings->subjects = (!empty($subjects))? json_encode($subjects) : json_encode(array());
                $combineMarkSettings->convert_at = $convert_at;
                $combineMarkSettings->save();

                Helpers::addMessage(200, ' Information was saved');
            }else{
                Helpers::addMessage(400, ' Information Already Exist');
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

    /**
     * Update Combine Mark Settings
     * @return mixed
     */
    public function updateCombineMark()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $title = Input::get('title');
            $class_id = Input::get('class_id');
            $mark_type_id = Input::get('mark_type_id');
            $pass = Input::get('pass');
            $subjects = Input::get('subject_id');
            $convert_at = Input::get('convert_at');
            $id = Input::get('combine_mark_settings_id');

            $combineMarkSettings = CombineMarkSettings::find($id);
            if(count($combineMarkSettings))
            {

                $updateData = array();
                $updateData['title'] = $title;

                $updateData['class_id'] = $class_id;
                $updateData['mark_type_id'] = $mark_type_id;
                $updateData['pass'] = $pass;
                $updateData['convert_at'] = $convert_at;

                $updateData['subjects'] = (!empty($subjects))? json_encode($subjects) : json_encode(array());
                CombineMarkSettings::where('combine_mark_settings_id',$combineMarkSettings->combine_mark_settings_id)->update($updateData);

                Helpers::addMessage(200, ' Information was updated.');

            }else{

                Helpers::addMessage(400, ' Record not found.');

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

    public function deleteCombineMark()
    {
        if(Request::ajax())
        {
            $id = (int)Input::get('id');

            $combineMarkSettings = CombineMarkSettings::find($id);
            if($combineMarkSettings)
                CombineMarkSettings::where('combine_mark_settings_id',$combineMarkSettings->combine_mark_settings_id)->update(array('deleted_at'=>time()));
            return 1;

        }else{

            return Redirect::to('settings/combine-mark');

        }
    }

    public function undoDeleteCombineMark()
    {
        if(Request::ajax())
        {
            $id = (int)Input::get('id');

            $combineMarkSettings = CombineMarkSettings::find($id);
            if($combineMarkSettings)
                CombineMarkSettings::where('combine_mark_settings_id',$combineMarkSettings->combine_mark_settings_id)->update(array('deleted_at'=>0));
            return 1;

        }else{

            return Redirect::to('settings/combine-mark');

        }
    }

    public function removeCombineMark()
    {
        if(Request::ajax())
        {
            $id = (int)Input::get('id');

            $combineMarkSettings = CombineMarkSettings::find($id);
            if($combineMarkSettings)
                $combineMarkSettings->delete();
            return 1;

        }else{

            return Redirect::to('settings/combine-mark');

        }
    }

    public function examRules()
    {
        $viewModel = array(
          'theme' => Theme::getTheme(),
          'user'  => $this->_userSession,
          'terms' => Terms::GetTerms(),
          'termRules' => json_decode(Option::getData('term_rules'))
        );

        return Theme::make('settings.exam-mark.exam-rules',$viewModel);
    }

    public function updateExamRules()
    {
        if(Request::isMethod('post'))
        {
            $termRules = Input::get('term_rules');
            Option::setData('term_rules',json_encode($termRules));
            Helpers::addMessage(200, " Rules are updated");
        }else{
            Helpers::addMessage(500, " Bad Request");
        }
        return Redirect::to('settings/exam-rules');
    }

    public function resultPublish()
    {

        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'classes'  => SchoolClass::all(),
            'terms'  => Terms::GetTerms()
    );
        return Theme::make('settings.exam-mark.result-publish',$viewModel);
    }

} 
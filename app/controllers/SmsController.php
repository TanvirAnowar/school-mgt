<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/19/14
 * Time: 3:38 PM
 */

class SmsController extends BaseController{

    protected $layout;
    protected $default_route;
    protected $_userSession;

    public function  __construct()
    {
        parent::__construct();
        $this->default_route = 'sms/notice';
        $this->_userSession = Authenticate::check();
        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }

    public function index()
    {
        return Redirect::to($this->default_route);
    }

    public function notice()
    {
        date_default_timezone_set('Asia/Dhaka');
        $viewModel = array(

            'user'  => $this->_userSession,
            'groups' => MessageGroup::all()
        );

        $dailySmsLimit = Option::getData('daily_sms_limit');

        $carbonAPi = new Carbon51();
        $api_state = $carbonAPi->hasSession();
        $accessToken = $carbonAPi->getAccessToken($api_state);
        $token = $carbonAPi->getRefreshToken($accessToken);
        $tokenObj = (!empty($token)) ? json_decode($token) : '';
        $viewModel['clientid'] = $tokenObj->client_id;
        $viewModel['access_token'] = $tokenObj->access_token;
        $viewModel['refresh_token'] = $tokenObj->refresh_token;
        $viewModel['daily_sms_limit'] = $dailySmsLimit;
        $response = $carbonAPi->get_daily_sms_count($tokenObj->access_token,date('Y-m-d'));
        $response = json_decode($response);
        $viewModel['daily_sms_count'] = $response->count;
        return Theme::make('sms.groups.notice',$viewModel);
    }

    public function sendNotice()
    {
        if(Request::ajax())
        {
            $groupId = Input::get('group_name');
            $message = Input::get('message');
            $clientId = Input::get('client_id');
            $accessToken = Input::get('access_token');
            $refreshToken = Input::get('refresh_token');


            $appMode = Option::getData('app_mode');

            $dailySmsLimit = Option::getData('daily_sms_limit');
            $carbonApi = new Carbon51();
            $responseCount = $carbonApi->get_daily_sms_count($accessToken,date('Y-m-d'));
            $responseCount = json_decode($responseCount);

            if(($responseCount->count) >= $dailySmsLimit)
            {
                Helpers::addMessage(400, 'Your daily message limit finish');
                return -1;
            }

            $group = MessageGroup::find($groupId);
            if(count($group))
            {
                $groupItems = MessageGroupDetail::where('group_id',$group->group_id)->get();
                if(count($groupItems))
                {
                    $myRemainingLimit = ($dailySmsLimit-$responseCount->count);
                    if(count($groupItems) >= $dailySmsLimit || count($groupItems) >= $myRemainingLimit)
                    {
                        Helpers::addMessage(400, 'Your daily message limit finish');
                        return -1;
                    }

                    $xmlStr = '<?xml version="1.0"?>';
                    $xmlStr .= '<messages>';
                    foreach($groupItems as $item)
                    {
                        $numbers = explode(",",$item->number);

                        foreach($numbers as $number){
                            if(strlen(trim($number)) == 11)
                            {
                                /*$msgCount = ceil(strlen(trim($message))/160);
                                $dailySmsCount += $msgCount;*/

                                $xmlStr .= '<message>';
                                $xmlStr .= '<clientid>' . trim($clientId) . '</clientid>';
                                $xmlStr .= '<number>' . trim($number) . '</number>';
                                $xmlStr .= '<content>' . trim($message) . '</content>';
                                $xmlStr .= '<recipient>0</recipient>';
                                $xmlStr .= '<subject>' . trim($carbonApi::$SMS_MASKING) . '</subject>';
                                $xmlStr .= '</message>';
                            }
                        }
                    }

                    $xmlStr .= '</messages>';


                    /*Option::setData('daily_sms_count',$dailySmsCount);*/
                    if($appMode)
                    {
                        file_put_contents('notice.xml',$xmlStr);
                    }else{
                        Helpers::addMessage(200,' Message Sent Successfully');
                        $response = $carbonApi->sent_message_request($accessToken, $refreshToken, $xmlStr); 

                        if (!empty($response)) {
                            $jsonObj = json_decode($response);

                            if ($jsonObj->status == '200') {
                                Helpers::addMessage(200,' Message Sent Successfully');
                            } elseif ($jsonObj->status == '502') {

                                Helpers::addMessage(400,' Message Already Sent');
                            }
                        }
                    }
                }

            }
            return '0';

        }else{
            return Redirect::to($this->default_route);
        }
    }

    public function sendAttendanceSms()
    {
        if(Request::ajax())
        {
            $presentMode = Option::getData('present');
            $absentMode = Option::getData('absent');
            $attendance_sms_option = Option::getData('attendance_sms_option');
            $student_sms_option = Option::getData('student_sms_option');
            $appMode = Option::getData('app_mode');

            $classId = Input::get('class_id');
            $session = Input::get('session');
            $sectionId = Input::get('section_id');
            $attendanceDate = Helpers::dateTimeFormat('Y-m-d',Input::get('attendance_date'));
            $reg_ids = Input::get('reg_id');
            $attendance = Input::get('attendance');

            $clientId = Input::get('client_id');
            $accessToken = Input::get('access_token');
            $refreshToken = Input::get('refresh_token');

            $dailySmsLimit = Option::getData('daily_sms_limit');
            $carbonApi = new Carbon51();
            $responseCount = $carbonApi->get_daily_sms_count($accessToken,date('Y-m-d'));
            $responseCount = json_decode($responseCount);

            if(($responseCount->count) >= $dailySmsLimit)
            {
                Helpers::addMessage(400, 'Your daily message limit finish');
                return json_encode(array('status'=>400,'message'=>'Sorry Your daily sms limit finish'));
            }

            $class = SchoolClass::find($classId);
            $section = SchoolSection::find($sectionId);
            $currentMsgTemplate = Template::getActiveTemplate('SMS');

            $section_name = (!empty($section))? $section->section_name : '';
            $sendTo = strtolower($class->class_name).'-'.strtolower($section_name);
            $countSmsLimit = SmsDayLimit::where('sent_date',$attendanceDate)->where('sent_to',$sendTo)->count();
            if($countSmsLimit)
            {
                return json_encode(array('status'=>400,'message'=>'Message Already Sent'));

            }else{
                $smsDayLimit = new SmsDayLimit();
                $smsDayLimit->sent_to = $sendTo;
                $smsDayLimit->sent_date = $attendanceDate;
                if(!$appMode)
                {
                    $smsDayLimit->save();
                }
            }

            if(count($reg_ids))
            {
                $messageData = array();
                $myRemainingLimit = ($dailySmsLimit-$responseCount->count);
                if(count($reg_ids) >= $dailySmsLimit || count($reg_ids) >= $myRemainingLimit)
                {
                    Helpers::addMessage(400, 'Your daily message limit finish');
                    return json_encode(array('status'=>400,'message'=>'Sorry Your daily sms limit finish'));
                }

                $xmlStr = '<?xml version="1.0"?>';
                $xmlStr .= '<messages>';
                foreach($reg_ids as $id)
                {
                    $message = '';
                    $registration = Registration::find($id);
                    if(count($registration))
                    {
                        $student = $registration->getStudent;
                        $messageData['Name'] = $student->name;
                        $class = $registration->getClass;
                        $section = $registration->getSection;
                        $task = Task::where('class_id',$class->class_id)->where('section_id',$section->section_id)->where('date',$attendanceDate)->first();

                        $messageData['Task'] = (!empty($task))? $task->task : '';
                        $messageData["Class"] = $class->class_name;
                        $messageData["Section"] = $section->section_name;
                        $messageData['Roll'] = $registration->class_roll;
                        $messageData['Attendance'] = $attendance[$id];

                        if($presentMode && preg_match('/^Present/',$messageData['Attendance']))
                        {

                            $message = Helpers::processMessage($messageData,$currentMsgTemplate->details);
                        }
                        if($absentMode && preg_match('/^Absent/',$messageData['Attendance']))
                        {

                            $message = Helpers::processMessage($messageData,$currentMsgTemplate->details);
                        }
                        $mobileNumbers = array();
                        if($student_sms_option && $attendance_sms_option)
                        {
                            //Helpers::debug($student);
                            $mobileNumbers[0] = (!empty($student->father_cell_phone))? trim($student->father_cell_phone) : '';
                            $mobileNumbers[1] = (!empty($student->mother_cell_phone))? trim($student->mother_cell_phone) : '';
                        }else
                        {

                            $mobileNumbers[] = (!empty($student->father_cell_phone))? trim($student->father_cell_phone) : trim($student->mother_cell_phone);
                        }

                        foreach($mobileNumbers as $mobileNumber){
                            $mobileNumber = str_replace(array("+","-"),"",$mobileNumber);
                            $mobileNumber = (preg_match('/^88+/',$mobileNumber))? substr($mobileNumber,2,strlen($mobileNumber)) : $mobileNumber;
                            $mobileNumber = (preg_match('/^1/',$mobileNumber))? '0'.$mobileNumber : $mobileNumber;
                            if(strlen($mobileNumber) == 11 && (strlen(trim($message)) > 0))
                            {
                                    $xmlStr .= '<message>';
                                    $xmlStr .= '<clientid>'.$clientId.'</clientid>';
                                    $xmlStr .= '<number>' . trim($mobileNumber) . '</number>';
                                    $xmlStr .= '<content>' . trim($message) . '</content>';
                                    $xmlStr .= '<recipient>stud-'.$student->id.'</recipient>';
                                    $xmlStr .= '<subject>' . trim($carbonApi::$SMS_MASKING) . '</subject>';
                                    $xmlStr .= '</message>';
                            }
                        }
                    }

                }
                $xmlStr .= '</messages>';

                if($appMode)
                {
                    file_put_contents('attendance.xml',$xmlStr);
                }else{

                    Helpers::addMessage(200,' Message Sent Successfully');
                    $response = $carbonApi->sent_message_request($accessToken, $refreshToken, $xmlStr);
                    if (!empty($response)) {
                        $jsonObj = json_decode($response);

                        if ($jsonObj->status == '200') {

                            return json_encode(array('status'=>200,'message'=>'Message Sent Successfully'));

                        } elseif ($jsonObj->status == '502') {

                            return json_encode(array('status'=>400,'message'=>'Message Already Sent'));
                        }
                    }
                }

            }
            return 1;
        }else{
            return Redirect::to('activities/attendance');
        }
    }

    public function sendResultSms()
    {
        $appMode = Option::getData('app_mode');

        if(Request::ajax())
        {

            $clientId = Input::get('client_id');
            $accessToken = Input::get('access_token');
            $refreshToken = Input::get('refresh_token');
            $studentResults = Input::get('sms_result');

            $dailySmsLimit = Option::getData('daily_sms_limit');
            $carbonApi = new Carbon51();
            $responseCount = $carbonApi->get_daily_sms_count($accessToken,date('Y-m-d'));
            $responseCount = json_decode($responseCount);

            if(($responseCount->count) >= $dailySmsLimit)
            {
                Helpers::addMessage(400, 'Your daily message limit finish');
                return json_encode(array('status'=>400,'message'=>'Sorry Your daily sms limit finish'));
            }

            if(count($studentResults))
            {

                $messageData = array();
                $myRemainingLimit = ($dailySmsLimit-$responseCount->count);
                if(count($studentResults) >= $dailySmsLimit || count($studentResults) >= $myRemainingLimit)
                {
                    Helpers::addMessage(400, 'Your daily message limit finish');
                    return json_encode(array('status'=>400,'message'=>'Sorry Your daily sms limit finish'));
                }

                $xmlStr = '<?xml version="1.0"?>';
                $xmlStr .= '<messages>';

                foreach($studentResults as $id=>$stdResult)
                {
                    $message = $stdResult;
                    $student = Student::find($id);
                    if(count($student))
                    {

                        $mobileNumber = (!empty($student->father_cell_phone))? trim($student->father_cell_phone) : trim($student->mother_cell_phone);
                        $mobileNumber = str_replace(array("+","-"),"",$mobileNumber);
                        $mobileNumber = (preg_match('/^88+/',$mobileNumber))? substr($mobileNumber,2,strlen($mobileNumber)) : $mobileNumber;
                        $mobileNumber = (preg_match('/^1/',$mobileNumber))? '0'.$mobileNumber : $mobileNumber;
                        //Helpers::debug($mobileNumber);
                        if(strlen($mobileNumber) == 11 && (strlen(trim($message)) > 0))
                        {
                            $xmlStr .= '<message>';
                            $xmlStr .= '<clientid>'.$clientId.'</clientid>';
                            $xmlStr .= '<number>' . trim($mobileNumber) . '</number>';
                            $xmlStr .= '<content>' . trim($message) . '</content>';
                            $xmlStr .= '<recipient>stud-'.$student->id.'</recipient>';
                            $xmlStr .= '<subject>' . trim($carbonApi::$SMS_MASKING) . '</subject>';
                            $xmlStr .= '</message>';
                        }
                    }
                }
                $xmlStr .= '</messages>';

                if($appMode)
                {
                    file_put_contents('sms-result.xml',$xmlStr);
                }else{

                    Helpers::addMessage(200,' Message Sent Successfully');
                    $response = $carbonApi->sent_message_request($accessToken, $refreshToken, $xmlStr);
                    if (!empty($response)) {
                        $jsonObj = json_decode($response);

                        if ($jsonObj->status == '200') {

                            return json_encode(array('status'=>200,'message'=>'Message Sent Successfully'));

                        } elseif ($jsonObj->status == '502') {

                            return json_encode(array('status'=>400,'message'=>'Message Already Sent'));
                        }
                    }
                }
            }
            return 1;
        }else{
            return Redirect::to('sms/sms-result');
        }

    }

    public function groups()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user' => $this->_userSession,
            'groups' => MessageGroup::all()
        );
        return Theme::make('sms.groups.lists',$viewModel);
    }

    public function groupAdd()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user' => $this->_userSession,
            'classes' => SchoolClass::all(),
            'types' => array('student','teacher','other'),
            'teacher_sms_option' => Option::getData('teacher_sms_option'),
            'student_sms_option' => Option::getData('student_sms_option'),
            'notice_sms_option' => Option::getData('notice_sms_option')
        );

        return Theme::make('sms.groups.add',$viewModel);
    }

    public function saveGroup()
    {
        if(Request::isMethod('post'))
        {
            $refUrl =  Input::get('refurl');
            $group_name= Input::get('group_name');
            $group_type= Input::get('group_type');
            $name = Input::get('name');
            $phone = array_unique(Input::get('phone'));
           // Helpers::debug($phone);die();
            $messageGroup = MessageGroup::firstOrNew(array('group_name'=>$group_name,'group_type'=>$group_type));
            if(!$messageGroup->exists)
            {
                $messageGroupId = $messageGroup->save();
                if($messageGroupId)
                {
                    foreach($name as $i => $n) {
                        if (!empty($phone[$i]))
                        {
                            $mgD = new MessageGroupDetail();
                            $mgD->group_id = $messageGroup->group_id;
                            $mgD->name = $n;
                            $mgD->number = $phone[$i];
                            $mgD->save();
                        }
                    }
                }

                Helpers::addMessage(200,' Group '.$group_name.' Saved');
            }
            else
            {
                Helpers::addMessage(400,' Group already exist');
            }
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }else{
            Helpers::addMessage(500,'Bad Request');
            $refUrl =  Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function groupView()
    {
        $id = Request::segment(3);
        $group = MessageGroup::find($id);
        if(count($group))
        {
            $viewModel = array(
              'theme' => Theme::getTheme(),
              'user'  => $this->_userSession,
              'group' => $group,
              'members' => MessageGroupDetail::where('group_id',$group->group_id)->get()
            );
            return Theme::make('sms.groups.view',$viewModel);
        }else{
            Helpers::addMessage(500, ' group is not exist');
            return Redirect::to('sms/groups');
        }
    }

    public function delGroup()
    {
        if(Request::ajax())
        {
            $groupId = Input::get('group_id');
           return MessageGroup::where('group_id',$groupId)->delete();

        }else{
            Helpers::addMessage(500,'Bad Request');
            $refUrl =  url('sms/groups');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }

    }

    public function deleteGroupMember()
    {
        if(Request::ajax())
        {
            $groupMemberId = Input::get('member_id');
            return MessageGroupDetail::where('id',$groupMemberId)->delete();
        }else{
            Helpers::addMessage(500,'Bad Request');
            $refUrl =  url('sms/groups');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }

    }

    public function smsResult()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'classes' => SchoolClass::all(),
            'terms'   => explode(',', Option::getData('terms'))
        );
        $carbonAPi = new Carbon51();
        $api_state = $carbonAPi->hasSession();
        $accessToken = $carbonAPi->getAccessToken($api_state);
        $token = $carbonAPi->getRefreshToken($accessToken);
        $tokenObj = (!empty($token)) ? json_decode($token) : '';
        $viewModel['clientid'] = $tokenObj->client_id;
        $viewModel['access_token'] = $tokenObj->access_token;
        $viewModel['refresh_token'] = $tokenObj->refresh_token;
        return Theme::make('reports.sms-result',$viewModel);
    }



} 
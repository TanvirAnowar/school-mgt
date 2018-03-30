<?php

class DashboardController extends BaseController {

/*    protected $layout;
    protected $default_route;
    protected $_userSession;*/

    public function __construct() {

        parent::__construct();
        $this->default_route = 'dashboard/index';
        $this->_userSession = Authenticate::check();
        $this->_userSession->user_type;
        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }

    public function index() {

        $dailySmsLimit = Option::getData('daily_sms_limit');
        $carbonApi = new Carbon51();
        $api_state = $carbonApi->hasSession();

        $accessToken = $carbonApi->getAccessToken($api_state);

        $responseCount = $carbonApi->get_daily_sms_count($accessToken,date('Y-m-d'));
        $responseCount = json_decode($responseCount);
        $viewModel = array(
            'user'     => $this->_userSession,
            'teachers' => Teacher::where('deleted_at',0)->count(),
            'admit_application' => AdmitForm::count(),
            'students' => Student::where('deleted_at',0)->count(),
            'daily_sms_count' => $responseCount->count,
            'daily_sms_limit' => $dailySmsLimit
        );
        return Theme::make('dashboard',$viewModel);
    }





}

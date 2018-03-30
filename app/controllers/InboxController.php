<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 7/8/14
 * Time: 3:39 PM
 */

class InboxController extends BaseController{

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
        $this->default_route = 'inbox/index';
        $this->pageLimit = 20;
        $this->_userSession = Authenticate::check();  // check is user logged in

        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }

    public function index()
    {
        $sessionUId = $this->_userSession->id;
        $viewModel = array(

            'user' => $this->_userSession,
            'messages' => Comment::where('receiver_id',$sessionUId)->where('type','Notification')->OrderBy('sender_id','DESC')->get()
        );
        return Theme::make('inbox.index',$viewModel);
    }

    public function sentItems()
    {
        $sessionUId = $this->_userSession->id;
        $viewModel = array(
            'theme'=> Theme::getTheme(),
            'user' => $this->_userSession,
            'messages' => Discussion::where('sender_id',$sessionUId)->OrderBy('discussion_id','DESC')->get()
        );
        return Theme::make('inbox.sent-items',$viewModel);
    }

    public function compose()
    {
        $receivers = DB::table('users')
            ->leftJoin('student','users.user_id','=','student.id')
            ->leftJoin('teacher','users.user_id','=','teacher.id')->where('users.user_type','!=','Admin')
            ->select(array('users.id','users.user_type','student.name as sname','teacher.name as tname'))->get();
        /*Helpers::LastQuery();
        Helpers::debug($receivers);die();*/
        $viewModel = array(
            'theme' =>  Theme::getTheme(),
            'user'  => $this->_userSession,
            'receivers' => $receivers
        );

        return Theme::make('inbox.compose',$viewModel);
    }

    public function saveMessage()
    {
      $response = MessageSystem::saveDiscussion($this->_userSession->id);
      Helpers::addMessage($response['status'],$response['msg']);

      return Redirect::to($this->default_route);
    }


    public function details()
    {
        $id = Request::segment(3);
        $cid = Request::segment(4);
        $discussion = Discussion::find($id);


        $viewModel = array(
          'theme' => Theme::getTheme(),
          'user'  => $this->_userSession
        );

        if(count($discussion))
        {
            $comment = Comment::find($cid);
            if(count($comment))
            {
                Comment::where('comment_id',$comment->comment_id)->update(array('read_status'=>1));
            }

            $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
            View::share('inbox',$inbox);

            $viewModel['message'] = $discussion;
            return Theme::make('inbox.details',$viewModel);
        }else{
            Helpers::addMessage(500, " Bad Request");
            return Redirect::to($this->default_route);
        }
    }

    public function reply()
    {
        $response = MessageSystem::commentToDiscussion();
        Helpers::addMessage($response['status'],$response['msg']);

        return Redirect::to($response['refurl']);
    }

    public function bulkDeleteComment()
    {
        if(Request::ajax())
        {
            $message_id = Input::get('message_id');
            if(count($message_id))
            {
                foreach($message_id as $mid)
                {
                   $notification = Comment::find($mid);
                   $notification->delete();
                }

            }
        }
        return 1;
    }

    public function bulkDeleteMessage()
    {
        if(Request::ajax())
        {
            $message_id = Input::get('message_id');
            if(count($message_id))
            {
                foreach($message_id as $mid)
                {
                    $message = Discussion::find($mid);
                    $message->delete();
                }

            }
        }
        return 1;
    }

    public function downloadAttachment($fileName)
    {
        $file_url = 'data/attachment/'.urldecode($fileName);
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: Binary');
        header('Content-disposition: attachment; filename="' . basename($file_url) . '"');
        readfile($file_url);
    }
} 
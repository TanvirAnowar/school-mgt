<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/20/14
 * Time: 2:00 PM
 */

class UsersController extends BaseController{

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
        $this->default_route = 'users/lists';
        $this->pageLimit = 20;
        $this->_userSession = Authenticate::check();
        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }

    public function index()
    {
        return Redirect::to($this->default_route);
    }

    public function lists()
    {   $segment = Request::segment(3);
        if($segment == 'edit')
        {
            $id = (int)Request::segment(4);
            $user = User::find($id);
            $viewModel=array(

                'user' => $this->_userSession,
                'user_edit' => $user,
                'user_type' => array('Admin','Teacher','Student')
            );
            return Theme::make('users.edit',$viewModel);
        }else if($segment == 'add')
        {
            $viewModel=array(
                'theme' => Theme::getTheme(),
                'user' => $this->_userSession,
                'user_type' => array('Admin','Teacher','Student')
            );
            return Theme::make('users.add',$viewModel);
        }else{
            $viewModel=array(
                'theme' => Theme::getTheme(),
                'user' => $this->_userSession,
                'users' => User::where('deleted_at',0)->get()
            );
            return Theme::make('users.lists',$viewModel);
        }

    }

    public function trash()
    {
        $viewModel=array(
            'theme' => Theme::getTheme(),
            'user' => $this->_userSession,
            'users' => User::where('deleted_at','>',0)->get()
        );
        return Theme::make('users.trash',$viewModel);
    }

    public function saveUser()
    {
        if(Request::isMethod('post'))
        {
            $refUrl = Input::get('refurl');
            $username = Input::get('username');
            $password = Input::get('password');
            $user_type = Input::get('user_type');
            $user = User::firstOrNew(array('username'=>$username,'deleted_at'=>0));

            if(!$user->exists)
            {
                $user->password = md5($password);
                $user->user_type = $user_type;
                $user->save();

                Helpers::addMessage(200, " User Created");
            }else{
                Helpers::addMessage(400, " $user->username user account already exists");
            }
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');

        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl = Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function updateUser()
    {
        if(Request::isMethod('post'))
        {
            $refUrl = Input::get('refurl');
            $id = (int)Input::get('user_id');
            $password = Input::get('password');
            $user_type = Input::get('user_type');
            $user = User::find($id);
            if(count($user))
            {
                $updateData = array();
                $updateDate['user_type'] = $user_type;
                if($password)
                {
                    $updateData['password'] = md5($password);
                }
                User::where('id',$id)->update($updateData);

                Helpers::addMessage(200,' Information updated');
            }else{
                Helpers::addMessage(400,' Record not found');
            }

            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }else{
            Helpers::addMessage(500,' Bad Request');
            $refUrl = Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    public function deleteUser()
    {
        if(Request::ajax())
        {

            $id = (int)Input::get('id');
            $user = User::find($id);
            if(count($user))
            {
                User::where('id',$user->id)->update(array('deleted_at'=>time()));

                return 1;
            }

        }else{
            Helpers::addMessage(500,' Bad Request');
            return Redirect::to($this->default_route);
        }
    }

    public function restoreUser()
    {
        if(Request::ajax())
        {

            $id = (int)Input::get('id');
            $user = User::find($id);
            if(count($user))
            {
                User::where('id',$user->id)->update(array('deleted_at'=>0));

                return 1;
            }

        }else{
            Helpers::addMessage(500,' Bad Request');
            return Redirect::to($this->default_route);
        }
    }

    public function deleteTrashUser()
    {
        if(Request::ajax())
        {
            $id = (int)Input::get('id');
            $user = User::where('deleted_at','>',0)->where('id',$id)->first();
            if(count($user))
            {
                $user->delete();
                return 1;
            }

        }else{
            Helpers::addMessage(500,' Bad Request');
            return Redirect::to($this->default_route);
        }
    }


} 
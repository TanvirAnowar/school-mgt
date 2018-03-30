<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/6/14
 * Time: 3:56 PM
 */

class TemplatesController extends BaseController{

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
        $this->default_route = 'templates/lists';
        $this->pageLimit = 20;
        $this->_userSession = Authenticate::check();  // check is user logged in
        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }

    public function index()
    {
        return Redirect::to($this->default_route);
    }

    public function edit()
    {
        $id = (int)Request::segment(3);
        $template = Template::find($id);
        $viewModel = array(

            'user'  => $this->_userSession
        );
        $viewModel['template'] = (!empty($template))? $template : array();
        return Theme::make('templates.edit',$viewModel);
    }

    public function lists()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession
        );
        $segment = Request::segment(3);
        if($segment == 'add')
        {
            return Theme::make('templates.add',$viewModel);
        }
        else
        {
            $viewModel['templates'] = Template::all();
            return Theme::make('templates.lists',$viewModel);
        }

    }

    public function saveTemplate()
    {

        if(Request::isMethod('post'))
        {

            $refUrl =  Input::get('refurl');
            $name = Input::get('name');
            $type = Input::get('type');
            $template_details = Input::get('template_details');

            $templates = Template::firstOrNew(array('template_name'=>$name));

            if(!$templates->exists)
            {
                $templates->details = $template_details;
                $templates->template_type = $type;
                Template::where('template_type',$type)->update(array('status'=>0));
                $templates->save();
                Helpers::addMessage(200,' Template '.$name.'  saved');
            }
            else
            {
                Helpers::addMessage(400,' Template '.$name.'  already exist');
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

    public function updateTemplate()
    {

        if(Request::isMethod('post'))
        {

            $refUrl =  Input::get('refurl');
            $name = Input::get('name');
            $type = Input::get('type');
            $id = Input::get('id');
            $template_details = Input::get('template_details');

            $template = Template::find($id);

            if(count($template))
            {
                 Template::where('template_id',$id)->update(array('template_type'=>$type,'template_name'=>$name,'details'=>$template_details));
                Helpers::addMessage(200,' Template '.$name.'  updated');
            }
            else
            {
                Helpers::addMessage(400,' Template not found');
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

    public function deleteTemplate()
    {
        if(Request::ajax())
        {
            $id = (int)Input::get('id');
            $template = Template::find($id);
            if(count($template))
            {
                $template->delete();
            }
            return 1;
        }else{
            return Redirect::to('templates');
        }
    }



} 
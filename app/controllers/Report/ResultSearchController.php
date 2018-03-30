<?php
/**
 * Created by PhpStorm.
 * User: sanzeeb
 * Date: 11-Feb-15
 * Time: 3:20 PM
 */

Class ResultSearchController extends BaseController{

    protected $layout;
    protected $default_route;
    protected $_userSession;

    public function __construct() {

        $this->layout = Theme::getLayout();
        $this->default_route = 'report/index';
        $this->_userSession = Authenticate::check();
        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);

    }

    public  function index(){


        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'classes' => SchoolClass::all(),
            'terms'  => Terms::GetTerms()
        );
        return Theme::make('result-search.index',$viewModel);

        //echo "hi";
    }

    public function getClassWiseSection()
    {
        if(Request::format() == 'json')
        {
            $id = (int)Input::get('class_id');

            $ajaxModel = new AjaxModel();
            return $ajaxModel->get_class_wise_section($id);
        }
        else
        {
            return Redirect::to($this->default_route);
        }
    }


    public function getClassWiseSubject()
    {
        if(Request::format() == 'json')
        {
            $id = (int)Input::get('class_id');

            $ajaxModel = new AjaxModel();
            return $ajaxModel->get_class_wise_subject($id);
        }
        else
        {
            return Redirect::to($this->default_route);
        }
    }


    public  function getCustomSearchResult()
    {

        if(Request::format() == 'json')
        {
            $data['session'] = (int)Input::get('session_id');
            $data['class_id'] = (int)Input::get('class_id');
            $data['section_id'] = (int)Input::get('section_id');
            $data['term'] = Input::get('term_id');
            $data['search_type'] = Input::get('search_type');
            $data['subject_id'] = (int)Input::get('subject_id');

            $resultSearch = new ResultSearch();

            $response = array();//$resultSearch->get_position_in_class($data) ;

            switch($data['search_type']){
                case 'position-in-class':
                    $response = $resultSearch->get_position_in_class($data);
                    break ;
                case 'position-section':
                    $response = $resultSearch->get_position_in_section($data);
                    break ;
                case 'all-passed-student':
                    $response = $resultSearch->get_all_passed_students($data);
                    break ;
                case 'all-failed-student':
                    $response = $resultSearch->get_all_failed_students($data);
                    break ;

                default:
                    $response = null;
            }
           return json_encode($response);

        }
        else{
            return 'failed';// Redirect::to($this->default_route);
        }

    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/24/14
 * Time: 2:42 PM
 */

class ResultController extends BaseController{

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
        $this->default_route = 'result/index';
        $this->pageLimit = 20;
        $segment = Request::segment(2);

        View::share('inbox',array());
        if(!in_array($segment,array('process','publish','combine-result-publish')))
        {
            $this->_userSession = Authenticate::check();  // check is user logged in
        }
    }

    public function index()
    {

        $viewModel = array();
        return Theme::make('settings.dashboard',$viewModel);
    }

    public function saveResultPublishRequest()
    {
        if(Request::isMethod('post'))
        {
            $refUrl = Input::get('refurl');
            $class_id = Input::get('class_id');
            $section_id = Input::get('section_id');
            $session = Input::get('session');
            $term = Input::get('term');
            $resultPublishRequest = CronResultPublish::firstOrNew(array(
                'class_id'=>$class_id,
                'section_id'=>$section_id,
                'session'=>$session,
                'term' => $term
            ));
            if(!$resultPublishRequest->exists)
            {
                $resultPublishRequest->status = 0;
                $resultPublishRequest->save();
                /*if($resultPublishRequest->id)
                {
                    return Redirect::to('result/publish');
                }*/

                Helpers::addMessage(200, ' Result published.');
            }else{
                CronResultPublish::where('id',$resultPublishRequest->id)->update(array('status'=>0));
                /*if($resultPublishRequest->id)
                {
                    return Redirect::to('result/publish');

                }*/

                Helpers::addMessage(200, ' Result Re-published.');

            }
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
        else
        {
            Helpers::addMessage(500, ' Bad Request');
            $refUrl = Input::get('refurl');
            return (!empty($refUrl))? Redirect::to($refUrl) : Redirect::to('/');
        }
    }

    /**
     * Cron Job function
     * @return int
     */
    public function publish()
    {
        /* corn check publishable data after an interval and execute the first result.*/
        $resultPublishRequest = CronResultPublish::where('status',0)->where('term','!=','COMBINE')->where('deleted_at',0)->first();

        if(count($resultPublishRequest))
        {


            $class_id = $resultPublishRequest->class_id;
            $section_id = $resultPublishRequest->section_id;
            $term = $resultPublishRequest->term;
            $examYear = $resultPublishRequest->session;
            $searchMark = array();
            $searchMark['class_id'] = $class_id;
            $searchMark['section_id'] = $section_id;
            $searchMark['term'] = $term;
            $searchMark['session'] = $examYear;

            /* Populate result for a section */
            $publishedData = ResultPublish::publish($searchMark);
            $section =  SchoolSection::find($section_id);
            $shift = $section->getShift;
            $saveResult = array(
                'class_id'=>$class_id,
                'section_id'=>$section_id,
                'shift_id'=>$shift->shift_id,
                'term' => trim($term),
                'session' => $examYear,
                'results' => $publishedData
            );


            $reportsData = ReportsData::storeResult($saveResult);
            if($reportsData)
            {
                CronResultPublish::where('id',$resultPublishRequest->id)->where('deleted_at',0)->update(array('status'=>1));
            }
           // Helpers::addMessage(200," Result published");
            return Redirect::to('settings/result-publish');
            return 1;
        }
        else
        {
            return 0;
        }



    }

    /**
     * Cron Job function
     * @return int
     */
    public function combineResultPublish()
    {
        $resultPublishRequest = CronResultPublish::where('status',0)->where('term','COMBINE')->where('deleted_at',0)->first();

        if(count($resultPublishRequest))
        {

            $class_id = $resultPublishRequest->class_id;
            $section_id = $resultPublishRequest->section_id;
            $term = $resultPublishRequest->term;
            $examYear = $resultPublishRequest->session;
            $searchMark = array();
            $searchMark['class_id'] = $class_id;
            $searchMark['section_id'] = $section_id;
            $searchMark['term'] = $term;
            $searchMark['session'] = $examYear;

            $publishedData = ResultPublish::publish($searchMark);
            $section =  SchoolSection::find($section_id);
            $shift = $section->getShift;
            $saveResult = array(
                'class_id'=>$class_id,
                'section_id'=>$section_id,
                'shift_id'=>$shift->shift_id,
                'term' => trim($term),
                'session' => $examYear,
                'results' => $publishedData
            );


            $reportsData = ReportsData::storeResult($saveResult);
            if($reportsData)
            {
                CronResultPublish::where('id',$resultPublishRequest->id)->where('deleted_at',0)->update(array('status'=>1));
            }
            return 1;
        }
        else
        {
            return 0;
        }



    }

} 
<?php

class TransactionSettingsController extends BaseController
{
	private $defaultRoute = 'transaction-settings/manage';

	/**
     * for set user session data
     * @var string
     */
    protected $_userSession;

    private $pageLimit;

	public function __construct()
	{
		parent::__construct();
		$this->_userSession = Authenticate::check();
        $this->pageLimit = 20;
		$inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
	}

	public function index()
	{
		return Redirect::to($this->defaultRoute);
	}

	public function manage($type,$id='')
	{
		$viewModel= array(
			'theme' => Theme::getTheme(),
			'user'  => $this->_userSession
		);
		
		switch ($type) {
			case 'new':

				return Theme::make('finance.new-template',$viewModel);
                break;
            case 'edit':
                if(!empty($id))
                {
                    $transaction_template = TransactionTemplate::find($id);
                    $viewModel['transaction_template'] = $transaction_template;
                    $heads = AccountHead::where('acc_type',$transaction_template->acc_type)->orderBy('parent_head','asc')->orderBy('head_name','asc')->get();
                    $indexedHeads = array();
                    foreach($heads as $head)
                    {
                        $head_name = (strlen(trim($head->parent_head)) > 0)? $head->parent_head : $head->head_name ;
                        if($head_name == $head->parent_head)
                        {
                            $indexedHeads[$head_name]['child'][] = $head->getAttributes();
                        }else
                        {
                            $indexedHeads[$head_name] = $head->getAttributes();
                            $indexedHeads[$head_name]['child'] = array();
                        }
                    }
                    $viewModel['templates'] = $indexedHeads;

                    return Theme::make('finance.edit-template',$viewModel);
                }
                else
                {
                    return Redirect::to();
                }
			default:
				
				break;
		}
        $viewModel['transactions'] = TransactionTemplate::orderBy('id','desc')->paginate($this->pageLimit);
		return Theme::make('finance.settings',$viewModel);
	}

	public function saveTemplate()
	{
		if(Request::ajax())
		{
			$head_id 	  = Input::get('head_id');
			$amount  	  = Input::get('amount');
			$templateName = Input::get('template_name');
			$acc_type     = Input::get('acc_type');
			$transactionTemplate = TransactionTemplate::firstOrNew(array('acc_type'=>$acc_type,'title'=>$templateName));
			$template = array();				
			foreach($head_id as $id)
			{
				$template[] = array('head_id'=>$id,'amount'=>$amount[$id]);
			}
			Helpers::debug($transactionTemplate);
			$transactionTemplate->template = json_encode($template);
			$transactionTemplate->save();
		}
		exit();
	}
}
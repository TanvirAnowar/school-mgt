<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/6/14
 * Time: 12:25 PM
 */

class FinanceController extends BaseController{

    protected $layout;
    protected $default_route;
    protected $_userSession;
    protected $pageLimit;

    public function __construct()
    {
        parent::__construct();
        $this->layout = Theme::getLayout();
        $this->default_route = 'finance';
        $this->_userSession = Authenticate::check();
        $this->pageLimit = 20;
        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }

    public function index()
    {
        $viewModel = array(
          'theme' => Theme::getTheme(),
          'user'  => $this->_userSession,
          'head_types' => array('Income','Expense')
        );

        return Theme::make('finance.index',$viewModel);
    }

    public function head()
    {
        $heads = ApiRequest::getApiResponse(url('service/get-heads'),array(),ApiRequest::$GET);
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'head_types' => array('Asset','Liabilities','Capital','Income','Expense'),
            'acc_types' => array('MISC','STUDENT','TEACHER'),
            'heads' => json_decode($heads)
        );

        return Theme::make('finance.head',$viewModel);
    }

    public function saveHead()
    {
        $response = '';
        if(Request::isMethod('post'))
        {
            $url = url('service/create-head');
            $head_type = Input::get('head_type');
            $head_name = Input::get('head_name');
            $parent_head = Input::get('parent_head');
            $acc_type = Input::get('acc_type');
            $postFields = array('head_type'=>$head_type,'head_name'=>$head_name,'parent_head'=>$parent_head,'acc_type'=>$acc_type);

            $response =  ApiRequest::getApiResponse($url,$postFields,ApiRequest::$POST);

            $response = json_decode($response);
            Helpers::addMessage($response->status,$response->message);
            return Redirect::to('finance/head');
        }else{
            Helpers::addMessage($response->status,$response->message);
            return Redirect::to('finance/head');
        }

    }

    public function account()
    {
        $segment = Request::segment(3);
        if($segment == 'new')
        {
            $viewModel = array(
                'theme' => Theme::getTheme(),
                'user' => $this->_userSession,
                'types'  => array('Normal','Capital')
            );

            return Theme::make('finance.account-new',$viewModel);

        }else{
            $accounts = ApiRequest::getApiResponse(url('service/get-accounts'),array(),ApiRequest::$GET);
            $viewModel = array(
                'theme' => Theme::getTheme(),
                'user' => $this->_userSession,
                'accounts' => json_decode($accounts)
            );

            return Theme::make('finance.account',$viewModel);
        }

    }

    public function saveAccount()
    {
        $response = '';
        if(Request::isMethod('post'))
        {

            $url = url('service/create-account');
            $account_owner_name = Input::get('account_owner_name');
            $account_status = Input::get('account_status');
            $account_opening_balance = Input::get('account_opening_balance');
            $account_opening_date = Input::get('account_opening_date');

            $postFields = array('account_owner_name'=>$account_owner_name,
                                'account_status' => $account_status,
                                'account_opening_balance' => $account_opening_balance,
                                'account_opening_date' => $account_opening_date,

            );

            $response = ApiRequest::getApiResponse($url,$postFields,ApiRequest::$POST);

            $response = json_decode($response);
            Helpers::addMessage($response->status,$response->message);

        }else{
            Helpers::addMessage($response->status,$response->message);

        }
        return Redirect::to('finance/account');

    }

    public function students()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'classes' => SchoolClass::all(),
            'sections' => SchoolSection::all(),
            'registeredStudents' => Registration::where('deleted_at',0)->paginate($this->pageLimit)
        );

        return Theme::make('finance.student.registered-students',$viewModel);
    }

    public function teachers()
    {
        $viewModel = array(

            'user'  => $this->_userSession,
            'teachers' => Teacher::where('deleted_at','0')->paginate($this->pageLimit)
        );
        return Theme::make('finance.teacher.lists',$viewModel);
    }

    public function invoice($type,$id = null,$tCode = null)
    {
       $viewModel = array(
           'theme' => Theme::getTheme(),
           'user'  => $this->_userSession
       );

       if($this->_userSession->user_type != 'Admin')
           return Redirect::to('finance/transactions');
       switch(trim($type))
       {
           case 'student':

               if(!empty($id))
               {
                   if(Request::isMethod('post'))
                   {
                       $post_all        = Input::all();
                       $studentId       = $post_all['std_id'];
                       $regId           = $post_all['reg_id'];
                       $invoiceNumber   = $post_all['invoice_number'];
                       $heads           = $post_all['head'];
                       $refs            = $post_all['ref_no'];
                       $descriptions    = $post_all['description'];
                       $amounts         = $post_all['amount'];
                       $monthOfPayment  = $post_all['month'];
                       if(!count($heads))
                       {
                           return Redirect::to('finance/invoice/student/'.$id);
                       }
                       if(!count($refs))
                       {
                           return Redirect::to('finance/invoice/student/'.$id);
                       }
                       if(!count($descriptions))
                       {
                           return Redirect::to('finance/invoice/student/'.$id);
                       }
                       if(!count($amounts))
                       {
                           return Redirect::to('finance/invoice/student/'.$id);
                       }
                       foreach($heads as $i=> $head)
                       {
                          $transactionCode = str_random(20);
                          $stdTransaction =  StudentFinance::firstOrNew(array(
                                'head' => $head,
                                'invoice_number' => $invoiceNumber,
                                'transaction_code' => $transactionCode,
                                'reg_id'     => $regId,
                                'ref_no'     => $refs[$i]
                           ));


                           $stdTransaction->description = $descriptions[$i];
                           $stdTransaction->amount = $amounts[$i];
                           $stdTransaction->month  = (!empty($monthOfPayment))? $monthOfPayment : date('F');

                           $stdTransaction->save();

                           if($stdTransaction->id)
                           {
                               $transaction = new AccountTransaction();
                               $transaction->invoice_number   = $invoiceNumber;
                               $transaction->transaction_code = $transactionCode;
                               $transaction->user_id          = $this->_userSession->id;
                               $transaction->acc_type         = AccountTransaction::$STUDENT;
                               $transaction->transaction_type = AccountTransaction::$TYPE_INCOME;
                               $transaction->amount           = $stdTransaction->amount;
                               $transaction->save();

                           }
                       }

                       echo url('finance/invoice/details/'.$id.'/'.$invoiceNumber);
                       exit();
                   }

                   $registration =  Registration::with('getStudent')->where('reg_id',$id)->first();
                   $student = $registration->getStudent;
                   $viewModel['registration'] = $registration;
                   $viewModel['student']      = $student;
                   $viewModel['heads']        = AccountHead::where('acc_type','STUDENT')->get();
                   $tTemplate  = TransactionTemplate::where('acc_type','STUDENT')->first();
                   $templates  = TransactionTemplate::where('acc_type','STUDENT')->get();
                   $template = (!empty($tTemplate))? json_decode($tTemplate->template) : array();
                   $new_template = array();
                   foreach($template as $temp)
                   {
                       $new_template[$temp->head_id] = $temp;
                   }
                   $viewModel['transaction_template'] = $new_template;
                   $viewModel['templates'] = $templates;
                   return Theme::make('finance.student.invoice',$viewModel);
               }
               break;

           case 'teacher':
               if(!empty($id))
               {
                   if(Request::isMethod('post'))
                   {
                       $post_all        = Input::all();
                       $teacherId       = $post_all['teacher_id'];
                       $invoiceNumber   = $post_all['invoice_number'];
                       $heads           = $post_all['head'];
                       $refs            = $post_all['ref_no'];
                       $descriptions    = $post_all['description'];
                       $amounts         = $post_all['amount'];
                       $monthOfPayment  = $post_all['month'];
                       if(!count($heads))
                       {
                           return Redirect::to('finance/invoice/teacher/'.$id);
                       }
                       if(!count($refs))
                       {
                           return Redirect::to('finance/invoice/teacher/'.$id);
                       }
                       if(!count($descriptions))
                       {
                           return Redirect::to('finance/invoice/teacher/'.$id);
                       }
                       if(!count($amounts))
                       {
                           return Redirect::to('finance/invoice/teacher/'.$id);
                       }
                       foreach($heads as $i=> $head)
                       {
                           $transactionCode = str_random(20);
                           $stdTransaction =  TeacherFinance::firstOrNew(array(
                               'head' => $head,
                               'invoice_number' => $invoiceNumber,
                               'transaction_code' => $transactionCode,
                               'teacher_id'     => $teacherId,
                               'ref_no'     => $refs[$i]
                           ));


                           $stdTransaction->description = $descriptions[$i];
                           $stdTransaction->amount = $amounts[$i];
                           $stdTransaction->month  = (!empty($monthOfPayment))? $monthOfPayment : date('F');

                           $stdTransaction->save();

                           if($stdTransaction->id)
                           {
                               $transaction = new AccountTransaction();
                               $transaction->invoice_number   = $invoiceNumber;
                               $transaction->transaction_code = $transactionCode;
                               $transaction->user_id          = $this->_userSession->id;
                               $transaction->acc_type         = AccountTransaction::$TEACHER;
                               $transaction->transaction_type = AccountTransaction::$TYPE_EXPENSE;
                               $transaction->amount           = $stdTransaction->amount;
                               $transaction->save();

                           }
                       }

                       echo url('finance/invoice/tdetails/'.$id.'/'.$invoiceNumber);
                       exit();
                   }
                   $teacher = Teacher::find($id);
                   $viewModel['teacher'] = $teacher;
                   $viewModel['heads']   = AccountHead::where('acc_type','TEACHER')->get();
                   $tTemplate  = TransactionTemplate::where('acc_type','TEACHER')->first();
                   $templates  = TransactionTemplate::where('acc_type','TEACHER')->get();
                   $template = (!empty($tTemplate))? json_decode($tTemplate->template) : array();
                   $new_template = array();
                   foreach($template as $temp)
                   {
                       $new_template[$temp->head_id] = $temp;
                   }
                   $viewModel['transaction_template'] = $new_template;
                   $viewModel['templates'] = $templates;
                   return Theme::make('finance.teacher.invoice',$viewModel);
               }
               break;

           case 'details':

               if((!empty($id)) && (!empty($tCode)))
               {
                   $studentFinance = StudentFinance::where('reg_id',$id)->where('invoice_number',$tCode)->orderBy('id','asc')->get();
                   $registration = Registration::with('getStudent')->where('reg_id',$id)->first();
                   $viewModel['registration'] = $registration;
                   $viewModel['student'] = $registration->getStudent;
                   $viewModel['finance'] = $studentFinance;
                   //Helpers::debug($viewModel);
                   return Theme::make('finance.student.invoice-details',$viewModel);
               }
               else
               {
                   return Redirect::to('dashboard');
               }

               break;

           case 'tdetails':
               if((!empty($id)) && (!empty($tCode)))
               {
                   $teacherFinance = TeacherFinance::where('teacher_id',$id)->where('invoice_number',$tCode)->orderBy('id','asc')->get();

                   $viewModel['teacher'] = Teacher::find($id);
                   $viewModel['finance'] = $teacherFinance;
                   return Theme::make('finance.teacher.invoice-details',$viewModel);
               }
               else
               {
                   return Redirect::to('dashboard');
               }
               break;

           case 'misc':
               if((!empty($id)))
               {
                   $miscFinance = MiscFinance::where('invoice_number',$id)->orderBy('id','asc')->get();
                   $viewModel['finance'] = $miscFinance;
                   return Theme::make('finance.misc.invoice-details',$viewModel);
               }
               else
               {
                   return Redirect::to('dashboard');
               }
               break;

           default:
               return Redirect::to('dashboard');
               break;
       }

    }

    public function getTemplate()
    {
        if(Request::ajax())
        {
            $id = Input::get('id');
            $type = Input::get('type');
            $trasnsactionTemplate  = TransactionTemplate::find($id);
            $template = (!empty($trasnsactionTemplate))? json_decode($trasnsactionTemplate->template) : array();
            $new_template = array();
            foreach($template as $temp)
            {
                $new_template[$temp->head_id] = $temp;
            }
            $viewModel['heads']        = AccountHead::where('acc_type',$type)->get();
            $viewModel['template'] = $new_template;
            return Theme::make('finance.get-template',$viewModel);
        }
    }

    public function transactions()
    {
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession
        );
        if($this->_userSession->user_type == 'Teacher'){
            $viewModel['transactions'] = TeacherFinance::where('teacher_id',$this->_userSession->user_id)->groupBy('invoice_number')->select(DB::Raw('*,sum(`amount`) as total'))->orderBy('id','desc')->paginate($this->pageLimit);
            return Theme::make('finance.teacher.teacher-transactions',$viewModel);
        }elseif($this->_userSession->user_type == 'Student'){
            $viewModel['transactions'] = StudentFinance::groupBy('invoice_number')->select(DB::Raw('*,sum(`amount`) as total'))->orderBy('id','desc')->paginate($this->pageLimit);
            return Theme::make('finance.student.student-transactions',$viewModel);
        }else{
            $viewModel['transactions'] = AccountTransaction::groupBy('invoice_number')->select(DB::Raw('*,sum(IF(transaction_type = "INCOME",`amount`,-`amount`)) as total'))->orderBy('acc_transaction_id','desc')->paginate($this->pageLimit);
            return Theme::make('finance.transactions',$viewModel);
        }


    }

    public function transaction($type)
    {
        error_reporting(E_ALL);
        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession
        );
        $viewModel['heads']   = AccountHead::all();
        switch($type)
        {
            case 'new':
                    $tTemplate  = TransactionTemplate::where('acc_type','MISC')->first();
                    $templates  = TransactionTemplate::where('acc_type','MISC')->get();
                    $template = (!empty($tTemplate))? json_decode($tTemplate->template) : array();
                    $new_template = array();
                    foreach($template as $temp)
                    {
                        $new_template[$temp->head_id] = $temp;
                    }
                    $viewModel['transaction_template'] = $new_template;
                    $viewModel['templates'] = $templates;
                    return Theme::make('finance.misc.invoice',$viewModel);
                break;

            default:

                break;
        }
    }

    public function save_misc_transaction()
    {
        if(Request::isMethod('post'))
        {
            $post_all        = Input::all();

            $invoiceNumber   = $post_all['invoice_number'];
            $heads           = $post_all['head'];
            $refs            = $post_all['ref_no'];
            $descriptions    = $post_all['description'];
            $amounts         = $post_all['amount'];
            $monthOfPayment  = $post_all['month'];

            if(!count($heads))
            {
                return Redirect::to('finance/transaction/new');
            }
            if(!count($refs))
            {
                return Redirect::to('finance/transaction/new');
            }
            if(!count($descriptions))
            {
                return Redirect::to('finance/transaction/new');
            }
            if(!count($amounts))
            {
                return Redirect::to('finance/transaction/new');
            }

            foreach($heads as $i=> $head)
            {
                $transactionCode = str_random(20);
                $miscTransaction =  MiscFinance::firstOrNew(array(
                    'head' => $head,
                    'invoice_number' => $invoiceNumber,
                    'transaction_code' => $transactionCode,
                    'ref_no'     => $refs[$i]
                ));


                $miscTransaction->description = $descriptions[$i];
                $miscTransaction->amount = $amounts[$i];
                $miscTransaction->month  = (!empty($monthOfPayment))? $monthOfPayment : date('F');

                $miscTransaction->save();

                if($miscTransaction->id)
                {
                    $accountHead = AccountHead::where('head_name',$head)->first();
                    if($accountHead->head_type == "Expense" || $accountHead->head_type == "Liabilities")
                    {
                        $transactionType = AccountTransaction::$TYPE_EXPENSE;
                    }
                    else
                    {
                        $transactionType = AccountTransaction::$TYPE_INCOME;
                    }
                    $transaction = new AccountTransaction();
                    $transaction->invoice_number   = $invoiceNumber;
                    $transaction->transaction_code = $transactionCode;
                    $transaction->user_id          = $this->_userSession->id;
                    $transaction->acc_type         = AccountTransaction::$MISC;
                    $transaction->transaction_type = $transactionType;
                    $transaction->amount           = $miscTransaction->amount;
                    $transaction->save();

                }
            }

            echo url('finance/invoice/misc/'.$invoiceNumber);
            exit();
        }
    }


    public function report($type,$invoice_number)
    {

        switch($type)
        {
            case 'misc':
                $miscReport = new TransactionReport("P","mm","A4");
                $miscReport->AddPage();
                $miscReport->SetAutoPageBreak(true, 0.0);
                $viewModel['obj'] = $miscReport;
                //$miscReport->reportFooter($viewModel);
                if((!empty($invoice_number)))
                {
                    $miscHeader =  AccountTransaction::where('invoice_number',$invoice_number)->groupBy('invoice_number')->select(DB::Raw('*,sum(`amount`) as total'))->get();
                    $miscFinance = MiscFinance::where('invoice_number',$invoice_number)->orderBy('id','asc')->get();
                    $miscReport->reportHeader($miscHeader);
                    $miscReport->generateReport($miscFinance);
                    $miscReport->output();

                }else
                {
                    return Redirect::to('dashboard');
                }

                break;

            case 'teacher':
                $miscReport = new TeacherFinanceReport("P","mm","A4");
                $miscReport->AddPage();
                $miscReport->SetAutoPageBreak(true, 0.0);
                $viewModel['obj'] = $miscReport;
                //$miscReport->reportFooter($viewModel);
                if((!empty($invoice_number)))
                {
                    $tfHeader =  TeacherFinance::where('invoice_number',$invoice_number)->groupBy('invoice_number')->select(DB::Raw('*,sum(`amount`) as total'))->get();
                    $tFinance = TeacherFinance::where('invoice_number',$invoice_number)->orderBy('id','asc')->get();
                    $miscReport->reportHeader($tfHeader);
                    $miscReport->generateReport($tFinance);
                    $miscReport->output();

                }else
                {
                    return Redirect::to('dashboard');
                }

                break;
            case 'student':
                $miscReport = new StudentFinanceReport("P","mm","A4");
                $miscReport->AddPage();
                $miscReport->SetAutoPageBreak(true, 0.0);
                $viewModel['obj'] = $miscReport;
                //$miscReport->reportFooter($viewModel);
                if((!empty($invoice_number)))
                {
                    $stdfHeader =  StudentFinance::where('invoice_number',$invoice_number)->groupBy('invoice_number')->select(DB::Raw('*,sum(`amount`) as total'))->get();
                    $stdFinance = StudentFinance::where('invoice_number',$invoice_number)->orderBy('id','asc')->get();
                    $miscReport->reportHeader($stdfHeader);
                    $miscReport->generateReport($stdFinance);
                    $miscReport->output();

                }else
                {
                    return Redirect::to('dashboard');
                }

                break;


        }
        die();
    }

    public function incomeStatement($type)
    {
        $viewModel = array(
          'theme' => Theme::getTheme(),
          'user'  => $this->_userSession
        );
        $viewModel['incomeStatements'] = IncomeStatement::where('year',date('Y'))->get();
        switch($type)
        {
            case 'new':
                return Theme::make('finance.report.create-income-statement',$viewModel);
                break;
            case 'get':

                $response = array();
                $expense = array();
                $incomes = array();
                $totalExpense = 0;
                $totalIncome = 0;

                $searchBy = Input::get('search_by');
                
                if($searchBy == "month")
                {
                  $year  = Input::get('year');
                  $month = Input::get('month');
                  $date  = $year.'-'.$month;
                  $expenseTransactions = AccountTransaction::where('created_at','like',$date.'%')->where('transaction_type',AccountTransaction::$TYPE_EXPENSE)->groupBy('invoice_number')->get();
                  $incomeTransactions  = AccountTransaction::where('created_at','like',$date.'%')->where('transaction_type',AccountTransaction::$TYPE_INCOME)->groupBy('invoice_number')->get();   
                
                  $response['year']   =  $year;
                  $response['month']  =  $month;
                }else{
                  $dateFrom = Input::get('date_from');
                  $dateTo   = Input::get('date_to');
                  $expenseTransactions = AccountTransaction::whereRaw("created_at BETWEEN '".$dateFrom."' AND '".$dateTo."'")->where('transaction_type',AccountTransaction::$TYPE_EXPENSE)->get();
                  $incomeTransactions = AccountTransaction::whereRaw("created_at BETWEEN '".$dateFrom."' AND '".$dateTo."'")->where('transaction_type',AccountTransaction::$TYPE_INCOME)->get();
                  //Helpers::debug($expenseTransactions);die();
                }
                
                
                
                $monthWiseExpense = array();
                foreach($expenseTransactions as $et)
                {
                    foreach($et->getDetails() as $d)
                    {
                        $expense[$d->head]['head']        = $d->head;
                        $expense[$d->head]['description'] = $d->description;
                        $totalExpense += $d->amount;
                        $expense[$d->head]['amount']      = $totalExpense;
                        if($et->acc_type == AccountTransaction::$TEACHER)
                        {
                          $to = $d->getData->getAttributes();

                        }else if($et->acc_type == AccountTransaction::$STUDENT)
                        {
                         
                          $to = $d->getData()->getStudent->getAttributes();
                        
                        }else{
                          $to = array('name'=>'Misc');
                        }
                        if(!isset($monthWiseExpense[$d->head]['collection'][Helpers::dateTimeFormat('F',$et->created_at)]))
                          $monthWiseExpense[$d->head]['collection'][Helpers::dateTimeFormat('F',$et->created_at)] =$d->amount;
                        else
                          $monthWiseExpense[$d->head]['collection'][Helpers::dateTimeFormat('F',$et->created_at)] += $d->amount;
                        
                          
                         

                        $expense[$d->head]['collection'][Helpers::dateTimeFormat('F',$et->created_at)]['total'] = $monthWiseExpense[$d->head]['collection'][Helpers::dateTimeFormat('F',$et->created_at)];
                        $expense[$d->head]['collection'][Helpers::dateTimeFormat('F',$et->created_at)]['collection'][] = array(
                            'to' => array('name'=>$to['name']),
                            'date' => Helpers::dateTimeFormat('j F,Y',$et->created_at),
                            'amount' => $d->amount,
                            'acc_type' => $et->acc_type
                          );
                    }

                }
                
                $response['expenses'] = $expense;
                $monthWiseIncome = array();
                foreach($incomeTransactions as $it)
                {
                    foreach($it->getDetails() as $d)
                    {
                        $incomes[$d->head]['head']        = $d->head;
                        $incomes[$d->head]['description'] = $d->description;
                        $totalIncome += $d->amount;
                        $incomes[$d->head]['amount']      = $totalIncome;
                        if($it->acc_type == AccountTransaction::$TEACHER)
                        {
                          $to = $d->getData->getAttributes();

                        }else if($it->acc_type == AccountTransaction::$STUDENT)
                        {
                         
                          $to = $d->getData()->getStudent->getAttributes();
                        
                        }else{
                          $to = array('name'=>'Misc');
                        }
                        
                        if(!isset($monthWiseIncome[$d->head]['collection'][Helpers::dateTimeFormat('F',$et->created_at)]))
                          $monthWiseIncome[$d->head]['collection'][Helpers::dateTimeFormat('F',$et->created_at)] =$d->amount;
                        else
                          $monthWiseIncome[$d->head]['collection'][Helpers::dateTimeFormat('F',$et->created_at)] += $d->amount;
                        
                        $incomes[$d->head]['collection'][Helpers::dateTimeFormat('F',$it->created_at)]['total'] = $monthWiseIncome[$d->head]['collection'][Helpers::dateTimeFormat('F',$et->created_at)];
                        $incomes[$d->head]['collection'][Helpers::dateTimeFormat('F',$it->created_at)]['collection'][] = array(
                            'to' =>   array('name'=>$to['name']),
                            'date' => Helpers::dateTimeFormat('j F,Y',$it->created_at),
                            'amount' => $d->amount,
                            'acc_type' => $it->acc_type
                          );
                    }

                }
                $response['incomes'] = $incomes;
                
                echo json_encode($response);

                die();
                break;
            case 'save':

                if(Request::ajax()){

                    $income_statement = Input::all();
                    
                    $totalExpense = $income_statement['totalExpense'];
                    $totalIncome  = $income_statement['totalIncome'];
                    $netTotal     = $income_statement['netTotal'];
                    $profitLoss   = $income_statement['profitLoss'];
                    $year         = $income_statement['year'];
                    $month        = $income_statement['month'];
                    $search_by    = $income_statement['search_by'];
                    $date_from    = $income_statement['date_from'];
                    $date_to      = $income_statement['date_to'];

                    $incomeStatement = IncomeStatement::firstOrNew(array('year'=>$year,'month'=>$month));
                    $incomeStatement->income_statement = json_encode($income_statement);
                    $incomeStatement->total_expenses   = $totalExpense;
                    $incomeStatement->total_incomes    = $totalIncome;
                    $incomeStatement->total            = $netTotal;
                    $incomeStatement->profit_loss      = $profitLoss;
                    $incomeStatement->year             = $year;
                    $incomeStatement->month            = $month;
                    $incomeStatement->date_from        = $date_from;
                    $incomeStatement->date_to          = $date_to;
                    $incomeStatement->search_by        = $search_by;
                    $incomeStatement->save();
                    Helpers::addMessage(200, "Income Statement Updated");
                    echo url('finance/income-statement');
                    exit();
                }
                    return Redirect::to('finance/income-statement');


                break;
            case 'report':

                $segment  = Request::segment(4);
                $data = explode('_',$segment);

                $income_statement = IncomeStatement::where('year',$data[0])->where('month',$data[1])->first();
                if(count($income_statement))
                {
                    $incomeStatement = json_decode($income_statement->income_statement);

                    $reportObj = new IncomeStatementReport('P','mm','A4');
                    $reportObj->AddPage();
                    $reportObj->SetAutoPageBreak(true, 0.0);
                    $reportObj->SetFont('Arial','B',12);
                    $reportObj->reportHeader($income_statement);
                    $reportObj->generateExpenseReport($income_statement);
                    $reportObj->generateIncomeReport($income_statement);
                    $reportObj->generateNetTotal($income_statement);
                    $reportObj->output();
                }
                exit();
                break;

        }



        return Theme::make('finance.report.income-statement',$viewModel);
    }

}
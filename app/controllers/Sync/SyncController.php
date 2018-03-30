<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/28/14
 * Time: 12:23 PM
 */

class SyncController extends BaseController{

    protected $layout;
    protected $default_route;
    protected $_userSession;
    protected $pageLimit;

    public function __construct()
    {
        $this->layout = Theme::getLayout();
        $this->default_route = 'student/lists';
        $this->_userSession = Authenticate::check();
        $this->pageLimit = 20;
        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);
    }

    public function index()
    {
        $student = new Student();
        $syncStudent = new SyncStudent();
        $viewModel = array(
          'theme' => Theme::getTheme(),
          'user' => $this->_userSession,
          'new_columns' => $student->getAllColumnsNames(),
          'classes' => SchoolClass::all(),
          'students' =>  SyncStudent::all(),
          'old_columns' => $syncStudent->getAllColumnsNames(),

        );
        

        return Theme::make('sync.student',$viewModel);
    }

    public function saveStudent()
    {
        if(Request::isMethod('post'))
        {
            $class_id  = Input::get('class_id');
            $section_id = Input::get('section_id');
            $columns = Input::get('columns');
            $students =  SyncStudent::all();

            foreach($students as $stud)
            {
                $studentObj = new Student();
                $studentObj->class_id = $class_id;
                $studentObj->section_id = $section_id;
                $name = '';
                
                try{

                    foreach($columns as $colKey => $colValue)
                    {

                        if($colValue == 'name')
                        {
                            $name[] = $stud->{$colKey};

                        }


                            $studentObj->{$colValue} = $stud->{$colKey};
                    }
                    $studentObj->name = implode(" ",$name);
                    $studentObj->student_id = strtolower(str_replace(" ", "_",trim($studentObj->name)));
                    $studentObj->student_type = 'New';
                    if(trim($studentObj->name)){
                        $studentObj->save();

                        if($studentObj->id)
                        {
                            $userExist =  User::where('user_id',$studentObj->id)->first();
                            if(!count($userExist))
                            {
                                $user = new User();
                                $user->user_id = $studentObj->id;
                                $user->username = $studentObj->student_id;
                                $user->password = md5($studentObj->student_id);
                                $user->user_type = 'Student';
                                $user->user_status = 1;
                                $user->save();
                            }

                        }
                    }

                    Helpers::addMessage(200, 'Information Sync Successfully');
                }catch(Exception $e)
                {


                }
                //Helpers::debug($studentObj);

            }

        }


        return Redirect::to('student');
    }

    public function importStudent()
    {
        $viewModel = array(
          'theme' => Theme::getTheme(),
          'user'  => $this->_userSession,
          'shifts' => SchoolShift::all()
        );

        $columns = Schema::getColumnListing("student");
        
        if(Request::isMethod('post'))
        {
            $shiftId = Input::get('shift_id');
            if(Input::hasFile('students'))
            {

                $ext = Input::file('students')->getClientOriginalExtension();
                $name = Input::file('students')->getClientOriginalName();

                $path = 'data/import/';
                $name = time().'_'.$name;
                if(in_array(strtolower($ext),array('xls'))){
                    Input::file('students')->move($path,$name);
                    $data = new SpreadsheetExcelReader($path.$name);
                    $currentSheet = array_shift($data->sheets);
                    //Helpers::debug($currentSheet);die();
                    $studentImportXls = new StudentImportXls($currentSheet);
                   
                   
                    //$viewModel['saved'] = $studentImportXls->SaveStudent($shiftId);

                }
            }

            $viewModel['students'] = Schema::getColumnListing("student");
            $viewModel['registrations'] = Schema::getColumnListing("registration");
            $viewModel['sheet_columns'] = $studentImportXls->getRows()[1];
            //azHelpers::debug($viewModel['sheet_columns'],1);
            $viewModel['filename'] = $name;
            return Theme::make('sync.relations',$viewModel);
        }



        return Theme::make('sync.import-student',$viewModel);
    }

    public function saveImport()
    {
        if(Request::isMethod('post'))
        {
            $bind_student = Input::get('bind_student');
            $default_student = Input::get('default_student');
            $bind_reg = Input::get('bind_reg');
            $default_reg = Input::get('default_reg');

            $path = 'data/import/';
            $name = Input::get('filename');
            $data = new SpreadsheetExcelReader($path.$name);
            $currentSheet = array_shift($data->sheets);
                    
            $studentImportXls = new StudentImportXls($currentSheet);
            $result = $studentImportXls->saveImportStudent($bind_student,$default_student,$bind_reg,$default_reg);
            if(is_array($result))
                return Redirect::to('sync/import-student')->with('message','Student Imported Successfully '.$result['success'] . ' and failed '.$result['failed']);
            else
                return Redirect::to('sync/import-student')->with('message','Sorry Student import failed');
        }
        else
        {
            return Redirect::to('sync/import-student');
        }
    }

} 
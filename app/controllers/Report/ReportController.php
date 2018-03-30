<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/20/14
 * Time: 10:54 AM
 */

class ReportController extends BaseController{

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

    public function index()
    {
        //Helpers::debug($_POST);
        if(Request::isMethod('post'))
        {

            $session = Input::get('session');
            $classId = Input::get('class_id');
            $sectionId = Input::get('section_id');
            $students = Input::get('student');

            $class = SchoolClass::find($classId);
            $section = SchoolSection::find($sectionId);

            $shift = $section->getShift;
            $shiftId = $shift->shift_id;
            $terms = Terms::GetTerms();

            $viewModel = array();

            $viewModel['subjects'] = $class->Subjects;
            $viewModel['class'] = $class;
            $viewModel['section'] = $section;
            $viewModel['shift'] = $shift;
            $viewModel['terms'] = $terms;
            $viewModel['session'] = $session;
            $viewModel['students'] = $students;

            $viewModel['noStudentsInClass'] = Registration::where('session',$session)
                                                            ->where('class_id',$classId)
                                                            ->where('deleted_at',0)->count();
            $viewModel['noStudentsInSection'] = Registration::where('session',$session)
                                                            ->where('class_id',$classId)
                                                            ->where('section_id',$sectionId)
                                                            ->where('deleted_at',0)->count();

            

            

            //Helpers::debug($viewModel['position']);
            switch($class->class_type)
            {
                case 'PRIMARY':
                    foreach($terms as $term){   

                        $viewModel['position'][$term]['classWisePosition'] = ReportsData::where('class_id',$classId)
                                                                        ->where('term',$term)
                                                                        ->where('exam_year',$session)
                                                                        ->orderBy('total_mark',"DESC")
                                                                        ->orderBy('failed_counts',"ASC")->get();

                        $viewModel['position'][$term]['sectionWisePosition'] = ReportsData::where('class_id',$classId)
                                                                         ->where('section_id',$sectionId)
                                                                         ->where('exam_year',$session)
                                                                        ->where('term',$term)
                                                                        ->orderBy('total_mark',"DESC")
                                                                        ->orderBy('failed_counts',"ASC")->get();    
                        $viewModel['totalClass'][$term]['count'] = TotalClass::where('term',$term)->where('session',$session)->first();                                   
                        
                    }
                    $reportView = new IspahaniProgressReport("L","mm","Legal");
                    $this->PrimaryReportProcessing($reportView,$viewModel);
                    break;
                case 'HIGHSCHOOL':
                    foreach($terms as $term){   

                        $viewModel['position'][$term]['classWisePosition'] = ReportsData::where('class_id',$classId)
                                                                        ->where('term',$term)
                                                                        ->where('exam_year',$session)
                                                                        ->orderBy('cgpa',"DESC")
                                                                        ->orderBy('total_mark',"DESC")
                                                                        ->orderBy('failed_counts',"ASC")->get();

                        $viewModel['position'][$term]['sectionWisePosition'] = ReportsData::where('class_id',$classId)
                                                                         ->where('section_id',$sectionId)
                                                                         ->where('exam_year',$session)
                                                                        ->where('term',$term)
                                                                        ->orderBy('cgpa',"DESC")
                                                                        ->orderBy('total_mark',"DESC")
                                                                        ->orderBy('failed_counts',"ASC")->get();    
                        $viewModel['totalClass'][$term]['count'] = TotalClass::where('term',$term)->where('session',$session)->first();                                   
                        
                    }
                    $reportView = new IspahaniProgressReport("L","mm","Legal");
                    $this->HighSchoolReportProcessing($reportView,$viewModel);
                    break;
                case 'COLLEGE':
                    $reportView = new CbcProgressReport("L","mm","Legal");
                    $this->CollegeReportProcessing($reportView,$viewModel);
                    break;
            }
            
        }else{
            return Redirect::to('report/student');
        }

    }

    private function PrimaryReportProcessing($reportView,$options)
    {
        $markTypes = MarkTypes::getDistinctMarkTypeAssocClass($options['class']->class_id);
        $options['markTypes'] = $markTypes;

        foreach($options['students'] as $std)
        {
            $student = Student::find($std);

            $reportData = ReportsData::where('student_id',$student->id)
                ->where('section_id',$options['section']->section_id)
                ->where('shift_id',$options['shift']->shift_id)->get();
            $marks = array();
            $failed = array();
            $classRoll = '';
            foreach($reportData as $d)
            {
                $marks[$d->term] = json_decode($d->mark_info);
                $classRoll = $d->class_roll;
                $failed[$std][$d->term] = (!empty($marks[$d->term]->hasFail))? 'Fail' : 'Pass';
            }
            //Helpers::debug($failed);

            $options['student'] = $student;
            $options['classRoll'] = $classRoll;
            $reportView->AddPage();
            $reportView->SetAutoPageBreak(true, 0.0);
            $reportView->SetFont('Arial', 'B', 18);
            $options['failed'] = $failed;
            if(!empty($options['subjects']) && !empty($marks))
            {
                $reportView->reportHeader($options);
                $reportView->contentHeader($options);
                $reportView->SetFont('Arial', '', 10);
                foreach($options['subjects'] as $i=> $subject)
                {
                    $reportView->subjectsMarksArea($subject,$marks,$markTypes,$options['terms']);
                    $reportView->combineResultArea($i,count($options['subjects']),$subject,$marks,$options['terms']);
                }

                $reportView->totalMarkArea($marks,$markTypes,$options['terms']);

                
                $reportView->SetFont('Arial', 'B', 8);
                

                
                $reportView->reportFooter($options);
            }else{
                $reportView->Cell(329, 10,"Result Not found",0,1,"C");
            }
        }
        $reportView->output();

    }

    private function HighSchoolReportProcessing($reportView,$options)
    {
        $markTypes = MarkTypes::getDistinctMarkTypeAssocClass($options['class']->class_id);
        $options['markTypes'] = $markTypes;

        foreach($options['students'] as $std)
        {
            $student = Student::find($std);

            $reportData = ReportsData::where('student_id',$student->id)
                ->where('section_id',$options['section']->section_id)
                ->where('shift_id',$options['shift']->shift_id)->get();
            $marks = array();
            $failed = array();
            $classRoll = '';
            foreach($reportData as $d)
            {
                $marks[$d->term] = json_decode($d->mark_info);
                $classRoll = $d->class_roll;
                $failed[$std][$d->term] = (!empty($marks[$d->term]->hasFail))? 'Fail' : 'Pass';
            }
            //Helpers::debug($marks);die();

            $options['student'] = $student;
            $options['classRoll'] = $classRoll;
            $reportView->AddPage();
            $reportView->SetAutoPageBreak(true, 0.0);
            $reportView->SetFont('Arial', 'B', 18);
            $options['failed'] = $failed;

            if(!empty($options['subjects']) && !empty($marks))
            {
                $reportView->reportHeader($options);
                $reportView->contentHeader($options);
                $reportView->SetFont('Arial', '', 9.5);
                $combineSubjectIndexList = array();
                $k=0;

                foreach($options['subjects'] as $index=> $subject)
                {
                    $subjectName = explode(" ",$subject->subject_name);
                    if(is_array($subjectName) && ($subject->subject_dependency == 1))
                    {
                        if(!in_array($subjectName[0],$combineSubjectIndexList))
                        {
                            $combineSubjectIndexList[$k] = $subjectName[0];
                        }else{
                            $combineSubjectIndexList[$index] = $subjectName[0];
                            unset($combineSubjectIndexList[$k]);
                            $k=($index+1);
                        }

                    }
                }
                foreach($options['subjects'] as $i=> $subject)
                {
                    $reportView->subjectsMarksArea($subject,$marks,$markTypes,$options['terms'],$i);
                    $reportView->combineResultArea($i,count($options['subjects']),$subject,$marks,$options['terms'],$markTypes);
                    if(!empty($combineSubjectIndexList[$i]))
                    {
                        $reportView->combineSubjectMarkArea($combineSubjectIndexList[$i],$marks,$markTypes,$options['terms']);
                        $reportView->combineSubjectCombineResultArea($i,count($options['subjects']),$subject,$marks,$options['terms'],$markTypes);
                    }
                }

                $reportView->totalMarkArea($marks,$markTypes,$options['terms']);

                $reportView->SetFont('Arial', 'B', 8);
                
                $reportView->reportFooter($options);
            }else{
                $reportView->Cell(329, 10,"Result Not found",0,1,"C");
            }
        }
        $reportView->output();
    }

    private function CollegeReportProcessing($reportView,$options)
    {
        $markTypes = MarkTypes::getDistinctMarkTypeAssocClass($options['class']->class_id);
        $options['markTypes'] = $markTypes;

        foreach($options['students'] as $std)
        {
            $student = Student::find($std);

            $reportData = ReportsData::where('student_id',$student->id)
                ->where('section_id',$options['section']->section_id)
                ->where('shift_id',$options['shift']->shift_id)->get();
            $marks = array();
            $failed = array();
            $classRoll = '';

            $optionalSubject =$student->getOptionalSubject($options['session']);
            $optionalSubjectName = (!empty($optionalSubject)) ? $optionalSubject->getSubject->subject_name : '';


            foreach($reportData as $d)
            {

                $marks[$d->term] = json_decode($d->mark_info);

                //Helpers::debug($marks[$d->term]);die();
                $classRoll = $d->class_roll;
                $failed[$std][$d->term] = (!empty($marks[$d->term]->failed_subject))? 'Fail' : 'Pass';
            }


            $options['student'] = $student;
            $options['classRoll'] = $classRoll;
            $reportView->AddPage();
            $reportView->SetAutoPageBreak(true, 0.0);
            $reportView->SetFont('Arial', 'B', 18);
            $options['failed'] = $failed;
            if(!empty($options['subjects']) && !empty($marks))
            {
                $reportView->reportHeader($options);
                $reportView->contentHeader($options);
                $reportView->SetFont('Arial', '', 10);
                foreach($options['subjects'] as $i=> $subject)
                {
                    //Helpers::debug($student);die();
                    $reportView->subjectsMarksArea($subject,$marks,$markTypes,$options['terms'],$optionalSubjectName);
                    $reportView->combineResultArea($i,count($options['subjects']),$subject,$marks,$options['terms']);
                }

                $reportView->totalMarkArea($marks,$markTypes,$options['terms']);

                $x = 295; $w = 15; $h = 6;
                $reportView->SetFont('Arial', 'B', 8);
                $grades = $options['class']->Grades;

                $reportView->gradeChart($grades,$x,$w,$h);
                $reportView->reportFooter($options);
            }else{
                $reportView->Cell(329, 10,"Result Not found",0,1,"C");
            }
        }
        $reportView->output();

    }

    public function tabulation()
    {

        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession,
            'classes' => SchoolClass::all()
        );
        return Theme::make('reports.tabulation',$viewModel);

    }

    public function student()
    {
        $viewModel = array(
          'theme' => Theme::getTheme(),
          'user'  => $this->_userSession,
          'classes' => SchoolClass::all()
        );
        return Theme::make('reports.student',$viewModel);

    }

    public function card()
    {

        $user_id = $this->_userSession->user_id;
        $user_type = $this->_userSession->user_type;

        if($user_type != 'Student')
        {
            Helpers::addMessage(400, " Sorry! You don't any permission");
            return Redirect::to('dashboard');
        }
        
        $reg = Registration::where('student_id',$user_id)->get();

        $viewModel = array(
            'theme' => Theme::getTheme(),
            'user'  => $this->_userSession
        );
        $classes = array();
        $sessions = array();
        $sections = array();
        if(count($reg))
        {
            foreach($reg as $r)
            {
                $classes[]  = $r->getClass;
                $sessions[] = $r->session;
                $sections[] = $r->getSection;
            }
            $viewModel['regs']   = $reg;
            $viewModel['classes']   = $classes;
            $viewModel['sections'] = $sections;
            $viewModel['sessions'] = $sessions;
            return Theme::make('reports.card',$viewModel);
        }else{
            Helpers::addMessage(400, " You don't have any registration yet");
            return Redirect::to('dashboard');
        }


    }


} 
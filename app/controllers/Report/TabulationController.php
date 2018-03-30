<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/29/14
 * Time: 1:16 PM
 */

class TabulationController extends BaseController{

    protected $layout;
    protected $default_route;
    protected $_userSession;

    public function __construct() {

        $this->layout = Theme::getLayout();
        $this->default_route = 'tabulation/index';
        $this->_userSession = Authenticate::check();
        $inbox = Comment::where('receiver_id',$this->_userSession->id)->where('read_status',0)->where('type','Notification')->get();
        View::share('inbox',$inbox);

    }

    public function index()
    {
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

            switch($class->class_type)
            {
                case 'PRIMARY':
                    $reportView = new OnkurTabulationSheet("L","mm","Legal");
                    $reportView->AliasNbPages();
                    $this->PrimaryTabulationProcessing($reportView,$viewModel);

                    break;
                case 'HIGHSCHOOL':
                    $reportView = new IspHSTabulationSheet("L","mm","Legal");
                    $reportView->AliasNbPages();
                    $this->HighSchoolTabulationProcessing($reportView,$viewModel);
                    break;
                case 'COLLEGE':
                    $reportView = new CbcTabulationReport("L","mm","Legal");
                    $reportView->AliasNbPages();
                    $this->CollegeTabulationProcessing($reportView,$viewModel);

                    break;

            }

        }else{
            return Redirect::to('report/tabulation');
        }
    }

    public function PrimaryTabulationProcessing($reportView,$options)
    {
        $markTypes = MarkTypes::getDistinctMarkTypeAssocClass($options['class']->class_id);
        $options['markTypes'] = $markTypes;
        $reportView->AddPage();

        $reportView->SetAutoPageBreak(true, 10.0);
        $reportView->reportHeader($options);

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

            $options['student'] = $student;
            $options['classRoll'] = $classRoll;

            $reportView->SetFont('Arial', 'B', 18);
            $options['failed'] = $failed;
            if(!empty($options['subjects']) && !empty($marks))
            {

                $options['marks'] = $marks;
                $reportView->subjectsMarks($options);

            }else{
                $reportView->Cell(329, 10,"Result Not found",0,1,"C");
            }
        }
        $reportView->output();
    }

    public function HighSchoolTabulationProcessing($reportView,$options)
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

            $options['student'] = $student;
            $options['classRoll'] = $classRoll;
            $reportView->AddPage();
            $reportView->SetAutoPageBreak(true, 0.0);
            $reportView->reportHeader($options);
            $reportView->SetFont('Arial', 'B', 18);
            $options['failed'] = $failed;
          
            if(!empty($options['subjects']) && !empty($marks))
            {

                $options['marks'] = $marks;
                $reportView->subjectsMarks($options);

            }else{
                $reportView->Cell(329, 10,"Result Not found",0,1,"C");
            }
        }
        $reportView->output();
    }


    public function CollegeTabulationProcessing($reportView,$options)
    {
        $markTypes = MarkTypes::getDistinctMarkTypeAssocClass($options['class']->class_id);
        $options['markTypes'] = $markTypes;
        $reportView->AddPage();

        $reportView->SetAutoPageBreak(true, 10.0);
        $reportView->reportHeader($options);

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
               $failed[$std][$d->term] = (!empty($d->failed_counts))? 'Fail' : 'Pass';
              // $failed[$std][$d->term] = (!empty($marks[$d->term]->failed_subject))? 'Fail' : 'Pass';


            }


            $options['student'] = $student;
            $options['classRoll'] = $classRoll;

            $reportView->SetFont('Arial', 'B', 18);
            $options['failed'] = $failed;
            if(!empty($options['subjects']) && !empty($marks))
            {

                $options['marks'] = $marks;
                $reportView->subjectsMarks($options);

            }else{
                $reportView->Cell(329, 10,"Result Not found",0,1,"C");
            }
        }
        $reportView->output();
    }


} 
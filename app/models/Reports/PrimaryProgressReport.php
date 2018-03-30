<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/11/14
 * Time: 12:52 PM
 */

class PrimaryProgressReport extends Report{


    public function Header()
    {
        $this->SetTopMargin(10);
    }

    public function reportHeader($viewModel)
    {

        $student = $viewModel['student'];
        $studentClassRoll = $viewModel['classRoll'];
        $session = $viewModel['session'];
        $className = $viewModel['class']->class_name;
        $sectionName = $viewModel['section']->section_name;
        $shiftName = $viewModel['shift']->shift_name;
        $systemName = Option::getData('vendor_name');

        $this->cell(329, 10, $systemName , 0, 1, "C");
        $this->SetFont('Arial', 'B', 12);
        $this->SetX(round(329/2) -10);
        $this->cell(40,8, "Progress Report",1,1,"C");
        $this->SetLineWidth(.5);
        $this->Cell(250,8,$student->name,"B",1,"L");
        $this->SetLineWidth(0);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(329,5,"Returnable to class teacher within three days with guardian's signature",0,1,"L");
        $this->SetY(42);

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(25,5,"Session     :",0,0,"L");
        $this->SetFont('Arial', '', 9);
        $this->Cell(15,5,$session,0,0,"L");
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(20,5,"Group       :",0,0,"L");
        $this->SetFont('Arial', '', 9);
        $this->Cell(25,5,"-",0,0,"L");
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(25,5,"Shift              :",0,0,"L");
        $this->SetFont('Arial', '', 9);
        $this->Cell(20,5,$shiftName,0,0,"L");
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(15,5,"Roll  :",0,0,"L");
        $this->SetFont('Arial', '', 9);
        $this->Cell(20,5,$studentClassRoll,0,1,"L");
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(25,5,"Class         :",0,0,"L");
        $this->SetFont('Arial', '', 9);
        $this->Cell(15,5,$className,0,0,"L");
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(25,5,"Section    :",0,0,"L");
        $this->SetFont('Arial', '', 9);
        $this->Cell(20,5,$sectionName,0,0,"L");
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(25,5,"Stduent ID  :",0,0,"L");
        $this->SetFont('Arial', '', 9);

        $this->Cell(20,5,$student->id,0,1,"L");
    }

    public function contentHeader($viewModel)
    {

        $terms = $viewModel['terms'];
        $termCount = count($terms);
        $this->SetY(55);
        $this->SetLineWidth(.2);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(50, 12, "Subject", 1, 0, "C");
        foreach($terms as $term)
        {

            if($termCount == 2)
            {
                $w = 80; $h = 6;
            }else{
                $w = 60; $h=6;
            }
            $this->Cell($w, $h, $term, 1, 0, "C");
        }

        if($termCount == 2)
        {
            $w = 120; $h = 6;
        }else{
            $w = 108; $h=6;
        }
        $this->Cell($w, $h, "Combined Result", 1, 1, "C");
        $this->SetXY(60, 61);



        $w =''; $h = '';
        /*** for half yearly exam ***/


        switch(count($viewModel['markTypes']))
        {
            case 1:
                if(count($terms) == 2)
                {
                    $w = 26.66; $h=6;
                }
                else if(count($terms) == 3){
                    $w = 20; $h=6;
                }
                break;
            case 2:
                if($termCount == 2)
                {
                    $w = 20; $h = 6;
                }else if($termCount == 3){
                    $w = 15; $h = 6;
                }

                break;
            case 3:
                if(count($terms) == 2)
                {
                    $w = 16; $h=6;
                }else if(count($terms) == 3){
                    $w = 12; $h=6;
                }

                break;
            case 4:
                if(count($terms) == 2)
                {
                    $w = 13.33; $h=6;
                }else if(count($terms) == 3){
                    $w = 10; $h=6;
                }

                break;
        }



        foreach($terms as $term)
        {
            foreach($viewModel['markTypes'] as $type)
            {
                $this->Cell($w, $h, str_replace(" ","\n", ucwords($type)), "B,R", 0, "C");
            }
            $this->Cell($w, $h, "Total", "B,R", 0, "C");$this->Cell($w, $h, "Highest", "B,R", 0, "C");
        }

        if($termCount == 2)
        {
            $w =30; $h=6;
        }else{
            $w=16; $h=6;
        }
        $termRules = Option::getData('term_rules');
        $termRules = json_decode($termRules);
        foreach($terms as $trm)
        {
            $percentage = (!empty($termRules->{$trm}))?$termRules->{$trm}: 0;
            $a = trim(str_replace("term", "",strtolower($trm)));
            $this->Cell($w, $h, ucfirst($a).' ('.$percentage. '%)', "B,R", 0, "C");
        }
        $this->Cell(15, 6, "Total", "B,R", 0, "C");
        $this->Cell(15, 6, "GP", "B,R", 0, "C");$this->Cell(15, 6, "Grade", "B,R", 0, "C");$this->Cell(15, 6, "GPA", "B,R", 1, "C");



    }

    public function subjectsMarksArea($subject,$marks,$markTypes,$terms)
    {
        $subjectName = $subject->subject_name;

        switch(count($markTypes)){
            case 1:
                if(count($terms) == 2)
                {
                    $w = 26.66; $h=7;
                }
                else if(count($terms) == 3){
                    $w = 20; $h=7;
                }
                break;
            case 2:
                if(count($terms) == 2)
                {
                    $w = 20; $h=7;
                }
                else{
                    $w = 15; $h=7;
                }
                break;
            case 3:
                if(count($terms) == 2)
                {
                    $w = 16; $h=7;
                }
                else if(count($terms) == 3){
                    $w = 12; $h=7;
                }
                break;
            case 4:
                if(count($terms) == 2)
                {
                    $w = 13.33; $h=7;
                }
                else if(count($terms) == 3){
                    $w = 10; $h=7;
                }
                break;

        }

        $this->SetFont('Arial', '', 10);
        $this->Cell(50,7,$subjectName,"L,B,R",0,"C");



            foreach($terms as $index =>$term)
            {
                if(!empty($marks[$term]->subjects->{$subjectName}))
                {
                    foreach($markTypes as $type)
                    {
                        $types = $marks[$term]->subjects->{$subjectName}->types;


                            $mark = (!empty($types->{strtolower($type)}))? $types->{strtolower($type)}: '';

                        $this->Cell($w,$h,$mark,"L,B,R",0,"C");

                    }

                    $obtainedMark = $marks[$term]->subjects->{$subject->subject_name}->subject_total;
                    $this->Cell($w,$h,$obtainedMark,"L,B,R",0,"C");
                    $this->Cell($w,$h,$marks[$term]->subjects->{$subject->subject_name}->highest_mark,"L,B,R",0,"C");
                }else{
                    foreach($markTypes as $type)
                    {
                        $this->Cell($w,$h,"-","L,B,R",0,"C");
                    }
                    $this->Cell($w,$h,"-","L,B,R",0,"C");
                    $this->Cell($w,$h,"-","L,B,R",0,"C");
                }

            }
    }

    public function totalMarkArea($marks,$markTypes,$terms)
    {
        switch(count($markTypes)){
            case 1:
                if(count($terms) == 2)
                {
                    $w = 26.66; $h=7;
                }
                else if(count($terms) == 3){
                    $w = 20; $h=7;
                }

                break;
            case 2:
                if(count($terms) == 2)
                {
                    $w = 20; $h=7;
                }
                else{
                    $w = 15; $h=7;
                }
                break;
            case 3:
                if(count($terms) == 2)
                {
                    $w = 16; $h=7;
                }
                else if(count($terms) == 3){
                    $w = 12; $h=7;
                }
                break;
            case 4:
                if(count($terms) == 2)
                {
                    $w = 13.33; $h=7;
                }
                else if(count($terms) == 3){
                    $w = 10; $h=7;
                }
                break;
        }

        $this->Cell(50,7,"Total","L,B,R",0,"C");
        foreach($terms as $index =>$term)
        {
            foreach($markTypes as $type)
            {
                $this->Cell($w,$h," ","L,B,R",0,"C");
            }
            $total = (!empty($marks[$term]->total))? $marks[$term]->total : '';
            $this->Cell($w,$h,$total,"L,B,R",0,"C");
            $this->Cell($w,$h," ","L,B,R",0,"C");
        }


        // combine Area of Total
        if(count($terms) == 2)
        {
            $w =30; $h=7;
        }else{
            $w=16; $h=7;
        }

        foreach($terms as $trm)
        {

            $this->Cell($w, $h, " ", "B,R", 0, "C");

        }

        $total = (!empty($marks['COMBINE']->total))? $marks['COMBINE']->total : '';
        $cgpa_total = (!empty($marks['COMBINE']->cgpa_total))? $marks['COMBINE']->cgpa_total : '';
        $this->Cell(15, $h, $total, "B,R", 0, "C");
        $this->Cell(15, $h, " ", "B,R", 0, "C");
        $this->Cell(15, $h, $cgpa_total, "B,R", 0, "C");
        $this->Cell(15, $h, " ", "B,R", 1, "C");
    }

    public function combineResultArea($index,$count,$subject,$marks,$terms)
    {
        $subjectName = $subject->subject_name;
        if(count($terms) == 2)
        {
            $w =30; $h=7;
        }else{
            $w=16; $h=7;
        }

        foreach($terms as $trm)
        {
            $percentageTotalMark = (!empty($marks[$trm]->subjects->{$subjectName}->percentage_total))?
                $marks[$trm]->subjects->{$subjectName}->percentage_total: '-';
            $this->Cell($w, $h,$percentageTotalMark, "B,R", 0, "C");
        }

            $combineSubjectTotal = (!empty($marks['COMBINE']))? $marks['COMBINE']->subjects->{$subject->subject_name}->subject_total : '';
            $combineSubjectGP = (!empty($marks['COMBINE']))? $marks['COMBINE']->subjects->{$subject->subject_name}->gpa->grade : '';
            $combineSubjectPoint = (!empty($marks['COMBINE']))? $marks['COMBINE']->subjects->{$subject->subject_name}->gpa->point : '';

        $this->Cell(15, $h, $combineSubjectTotal, "B,R", 0, "C");
        $this->Cell(15, $h, $combineSubjectGP, "B,R", 0, "C");
        $this->Cell(15, $h, $combineSubjectPoint, "B,R", 0, "C");
        if(($count/2) == $index)
        {
            $totalCGPA = (!empty($marks['COMBINE']))? $marks['COMBINE']->cgpa : '';
            $this->Cell(15, $h,$totalCGPA , "R", 1, "C");
        }else{
            $this->Cell(15, $h, " ", "R", 1, "C");
        }

    }

    public function gradeChart($grades,$x,$w,$h,$y=4)
    {
        
        $this->SetXY($x,$y);
        $this->Cell($w,$h,"Range",1,0,"C");
        $this->Cell($w,$h,"Grade",1,0,"C");
        $this->Cell($w,$h,"GP",1,0,"C");
        $y += 6;
        foreach($grades as $grade)
        {
            $this->SetXY($x,$y);
            $this->Cell($w,$h,$grade->mark."%","L,B,R",0,"C");
            $this->Cell($w,$h,$grade->grade,"B,R",0,"C");
            $this->Cell($w,$h,$grade->point,"B,R",0,"C");
            $y += 6;
        }

    }


    public function reportFooter($viewModel)
    {

        $terms = $viewModel['terms'];
        $termCount = count($terms);
        if($termCount == 2)
        {

            $this->FooterContentForTwoTerms($viewModel);

        }else{

            $this->FooterContentForThreeTerms($viewModel);
        }
        $this->SetXY(170,148);
        $this->SetFont("Arial","B");
        $this->Cell(100,5,"Remark",1,0,"C");
        $this->Cell(70,5,"Result",1,1,"C");
        $this->SetXY(170,153);
        $this->SetFont("Arial","");
        $this->Cell(100,40,"","B,R",0,"C");

        /*$this->Cell(25,5,"Total Marks","B,R",0,"C");
        $this->Cell(25,5,"Pass Marks","B,R",1,"C");
        $this->SetX(170);
        $this->Cell(50,17.5,"Bangla \nEnglish","B,R",0,"L");
        $this->Cell(25,17.5,"100","B,R",0,"C");
        $this->Cell(25,17.5,"40","B,R",1,"C");
        $this->SetX(170);
        $this->Cell(50,17.5,"Mathematics \nReligion \nSocial Science \nGeneral Science","B,R",0,"L");
        $this->Cell(25,17.5,"100","B,R",0,"C");
        $this->Cell(25,17.5,"40","B,R",1,"C");*/
        $this->SetX(170);
        $this->SetXY(270,153);
        $this->Cell(70,40,"","B,R",1,"C");
        $this->SetXY(280,156);
        $this->Cell(50,5,(!empty($viewModel['failed'][$viewModel['student']->id]['COMBINE']))? $viewModel['failed'][$viewModel['student']->id]['COMBINE'] :'',1,1,"C");
        $this->SetXY(280,165);
        $this->Cell(50,5,"Position",1,1,"C");
        $this->SetXY(280,170);
        $this->Cell(25,5,"In Class","B,L,R",0,"C");
        $this->Cell(25,5,"In Sec","B,L,R",0,"C");
        $this->SetXY(280,175);
        $this->Cell(25,5,(!empty($this->data['finalTerm']['marks']))?$this->data['combineClassWiseMerit']:'',"B,L,R",0,"C");
        $this->Cell(25,5,(!empty($this->data['finalTerm']['marks']))?$this->data['combineSecWiseMerit']:'',"B,L,R",0,"C");
        $this->SetXY(280,188);
        $this->Cell(25,5,"Class Teacher","T",0,"C");
        $this->Cell(2,1,"",0,0,"C");
        $this->Cell(23,5,"Headmaster","T",0,"C");
        $this->SetY(193);
        $this->Cell(330,12,"","L,B,R",1,"C");
        $this->SetFont('Arial', 'I', 8);
        
        $x = 295; $w = 15; $h = 6;
        $grades = $viewModel['class']->Grades;
        $this->gradeChart($grades,$x,$w,$h);
    }

    public function FooterContentForTwoTerms($viewModel)
    {
        $this->SetY(148);
        $this->SetFont("Arial","B",8);
        $this->Cell(80,5,"Half Yearly Exam",1,0,"C");
        $this->Cell(80,5,"Final Preparatory Test",1,1,"C");

        $this->SetFont("Arial","");
        $this->Cell(40,6,"Attendace","L",0,"L");
        $this->Cell(40,6,(!empty($this->data['firstTerm']['marks']))?$this->data['get_attendance'][4][0]['num_attendance']:'',"R",0,"L");
        $this->Cell(40,6,"Attendace",0,0,"L");
        $this->Cell(40,6,(!empty($this->data['finalTerm']['marks']))?$this->data['get_attendance'][6][0]['num_attendance']:'',"R",1,"L");
        $this->SetFont("Arial","B");
        $this->Cell(80,6,"No. of Stduents","L,R",0,"L");
        $this->Cell(80,6,"No. of Stduents","R",1,"L");
        $this->SetFont("Arial","");
        $noOfStudentClass = (!empty($viewModel['noStudentsInClass']))? $viewModel['noStudentsInClass']:'';
        $noStudentsInSection = (!empty($viewModel['noStudentsInSection']))? $viewModel['noStudentsInSection']:'';
        $this->Cell(40,6,"In Class: ".$noOfStudentClass,"L",0,"L");
        $this->Cell(40,6,"In Sec: ".$noStudentsInSection,"R",0,"L");
        $this->Cell(40,6,"In Class: ".$noOfStudentClass,0,0,"L");
        $this->Cell(40,6,"In Sec: ".$noStudentsInSection,"R",1,"L");
        $this->SetFont("Arial","B");
        $this->Cell(80,6,"Position","L,R",0,"L");
        $this->Cell(80,6,"Position","R",1,"L");
        $this->SetFont("Arial","");
        $firstClassWiseMerit = (!empty($this->data['firstTerm']['marks']))?$this->data['firstClassWiseMerit']:'';
        $this->Cell(40,6,"In Class: ".$firstClassWiseMerit,"L",0,"L");
        $firstSecWiseMerit = (!empty($this->data['firstTerm']['marks']))?$this->data['firstSecWiseMerit']:'';
        $this->Cell(40,6,"In Sec: ".$firstSecWiseMerit,"R",0,"L");
        $finalClassWiseMerit = (!empty($this->data['finalTerm']['marks']))?$this->data['finalClassWiseMerit']:'';
        $this->Cell(40,6,"In Class: ".$finalClassWiseMerit,0,0,"L");
        $finalSecWiseMerit = (!empty($this->data['finalTerm']['marks']))?$this->data['finalSecWiseMerit'] :'';
        $this->Cell(40,6,"In Sec: ".$finalSecWiseMerit,"R",1,"L");
        $this->SetFont("Arial","B");
        $this->Cell(40,5,"Behaviour","L",0,"L");
        $this->SetFont("Arial","");
        $this->Cell(40,5,(!empty($this->data['firstTerm']['marks']))?$this->data['aptitude_rating'][$this->data['student_aptitude'][4][0]['aptitude_value']]:'',"R",0,"L");
        $this->SetFont("Arial","B");
        $this->Cell(40,5,"Behaviour",0,0,"L");
        $this->SetFont("Arial","");
        $this->Cell(40,5,(!empty($this->data['finalTerm']['marks']))?$this->data['aptitude_rating'][$this->data['student_aptitude'][6][0]['aptitude_value']]:'',"R",1,"L");
        foreach($viewModel['terms'] as $term)
        {
            $this->SetFont("Arial","B");
            $this->Cell(40,5,"Result","B,L",0,"L");
            $this->SetFont("Arial","");
            $this->Cell(40,5,(!empty($viewModel['failed'][$viewModel['student']->id][$term]))? $viewModel['failed'][$viewModel['student']->id][$term]:'',"B,R",0,"L");
        }

        /*$this->SetFont("Arial","B");
        $this->Cell(40,5,"Result","B",0,"L");
        $this->SetFont("Arial","");
        $this->Cell(40,5,(!empty($viewModel['failed'][$viewModel['student']->id]['Second Term']))? $viewModel['failed'][$viewModel['student']->id]['Second Term']:'',"B,R",1,"L");*/
        $this->SetY(200);
        $this->Cell(2,5," ","",0,"C");
        $this->Cell(22,5,"Class Teacher","T",0,"C");
        $this->Cell(4,5," ","",0,"C");
        $this->Cell(22,5,"Guardian","T",0,"C");
        $this->Cell(4,5," ","",0,"C");
        $this->Cell(25,5,"Headmaster","T",0,"C");
        $this->Cell(4,5," ","",0,"C");
        $this->Cell(22,5,"Class Teacher","T",0,"C");
        $this->Cell(4,5," ","",0,"C");
        $this->Cell(22,5,"Guardian","T",0,"C");
        $this->Cell(4,5," ","",0,"C");
        $this->Cell(25,5,"Headmaster","T",0,"C");
    }

    public function FooterContentForThreeTerms($viewModel)
    {
        
        $student = $viewModel['student'];
        $this->SetY(148);
        $this->SetFont("Arial","B",8);

        foreach($viewModel['terms'] as $i=> $term){
            
            
            if($i == (count($viewModel['terms'])-1))
                $this->Cell(53.25,5,$term,1,1,"C");
            else
                $this->Cell(53.25,5,$term.'s',1,0,"C");
        }

        $this->SetFont("Arial","");
        $attendanceObj = new Attendance();
        foreach($viewModel['terms'] as $i=> $term)
        {
            $classWisePosition = (!empty($viewModel['position'][$term]))? $viewModel['position'][$term]['classWisePosition']:'';
            $absent = $attendanceObj->countAttendance($student->id,$term);
            
            $this->Cell(26.625,6,"Attendace","L",0,"L");
            $totalClass = (!empty($viewModel['totalClass'][$term]['count']))? $viewModel['totalClass'][$term]['count']->no_of_class : '';
            $attendance = ($totalClass - $absent['attendance']);
            $attendance = (!empty($attendance))? $attendance:'';

            if($i < (count($viewModel['terms'])-1))
            {
                $this->Cell(26.625,6,((count($classWisePosition))? $attendance.'/'.$totalClass : ''),"R",0,"L");
            }   
            else
                $this->Cell(26.625,6,((count($classWisePosition))? $attendance.'/'.$totalClass : ''),"R",1,"L");

        }
        /*$this->Cell(26.625,6,"Attendace",0,0,"L");
        $this->Cell(26.625,6,(!empty($this->data['finalTerm']['marks']))?$this->data['get_attendance'][6][0]['num_attendance']:'',"R",0,"L");
        $this->Cell(26.625,6,"Attendace",0,0,"L");
        $this->Cell(26.625,6,(!empty($this->data['finalTerm']['marks']))?$this->data['get_attendance'][6][0]['num_attendance']:'',"R",1,"L");*/
        $this->SetFont("Arial","B");
        $this->Cell(53.25,6,"No. of Stduents","L",0,"L");
        $this->Cell(53.25,6,"No. of Stduents","L,R",0,"L");
        $this->Cell(53.25,6,"No. of Stduents","R",1,"L");
        $this->SetFont("Arial","");
        $noOfStudentClass = (!empty($viewModel['noStudentsInClass']))? $viewModel['noStudentsInClass']:'';
        $noStudentsInSection = (!empty($viewModel['noStudentsInSection']))? $viewModel['noStudentsInSection']:'';

        foreach($viewModel['terms'] as $i=> $term)
        {
            $classWisePosition = (!empty($viewModel['position'][$term]))? $viewModel['position'][$term]['classWisePosition']:'';
            $this->Cell(26.625,6,"In Class: ".((count($classWisePosition))? $noOfStudentClass : ''),"L",0,"L");

            if($i < (count($viewModel['terms'])-1))
                $this->Cell(26.625,6,"In Sec: ".((count($classWisePosition))? $noStudentsInSection : ''),"R",0,"L");
            else
                $this->Cell(26.625,6,"In Sec: ".((count($classWisePosition))? $noStudentsInSection : ''),"R",1,"L");
        }
        /*$this->Cell(26.625,6,"In Class: ".$noOfStudentClass,0,0,"L");
        $this->Cell(26.625,6,"In Sec: ".$noStudentsInSection,"R",0,"L");

        $this->Cell(26.625,6,"In Class: ".$noOfStudentClass,0,0,"L");
        $this->Cell(26.625,6,"In Sec: ".$noStudentsInSection,"R",1,"L");*/

        $this->SetFont("Arial","B");
        $this->Cell(53.25,6,"Position","L",0,"L");
        $this->Cell(53.25,6,"Position","L,R",0,"L");
        $this->Cell(53.25,6,"Position","R",1,"L");
        $this->SetFont("Arial","");
        
        foreach($viewModel['terms'] as $i=> $term)
        {
            $classWisePosition = (!empty($viewModel['position'][$term]))? $viewModel['position'][$term]['classWisePosition']:'';
            $sectionWisePosition = (!empty($viewModel['position'][$term]))? $viewModel['position'][$term]['classWisePosition']:'';
            
            $classPosition = $sectionPosition = '';

            foreach($classWisePosition as $p => $position)
            {
               if($position->student_id == $student->id)
               {
                    $classPosition = ($p+1);
               }
            }
            foreach($sectionWisePosition as $sp => $sposition)
            {
               if($sposition->student_id == $student->id)
               {
                    $sectionPosition = ($sp+1);
               }
            }
            $this->Cell(26.625,6,"In Class: ".$classPosition,"L",0,"L");
            
            if($i < (count($viewModel['terms'])-1))
                $this->Cell(26.625,6,"In Sec: ".$sectionPosition,"R",0,"L");
            else
                $this->Cell(26.625,6,"In Sec: ".$sectionPosition,"R",1,"L");
        }
        /*$finalClassWiseMerit = (!empty($this->data['finalTerm']['marks']))?$this->data['finalClassWiseMerit']:'cgh';
        $this->Cell(26.625,6,"In Class: ".$finalClassWiseMerit,0,0,"L");
        $finalSecWiseMerit = (!empty($this->data['finalTerm']['marks']))?$this->data['finalSecWiseMerit'] :'s';
        $this->Cell(26.625,6,"In Sec: ".$finalSecWiseMerit,"R",0,"L");
        $this->Cell(26.625,6,"In Class: ".$finalClassWiseMerit,0,0,"L");
        $finalSecWiseMerit = (!empty($this->data['finalTerm']['marks']))?$this->data['finalSecWiseMerit'] :'';
        $this->Cell(26.625,6,"In Sec: ".$finalSecWiseMerit,"R",1,"L");*/
        $this->SetFont("Arial","B");
        $this->Cell(26.625,5,"","L",0,"L");
        $this->SetFont("Arial","");
        $this->Cell(26.625,5,(!empty($this->data['firstTerm']['marks']))?$this->data['aptitude_rating'][$this->data['student_aptitude'][4][0]['aptitude_value']]:'',"R",0,"L");
        $this->SetFont("Arial","B");
        $this->Cell(26.625,5,"",0,0,"L");
        $this->SetFont("Arial","");
        $this->Cell(26.625,5,(!empty($this->data['finalTerm']['marks']))?$this->data['aptitude_rating'][$this->data['student_aptitude'][6][0]['aptitude_value']]:'',"R",0,"L");
        $this->SetFont("Arial","B");
        $this->Cell(26.625,5,"",0,0,"L");
        $this->SetFont("Arial","");
        $this->Cell(26.625,5,(!empty($this->data['finalTerm']['marks']))?$this->data['aptitude_rating'][$this->data['student_aptitude'][6][0]['aptitude_value']]:'',"R",1,"L");
        foreach($viewModel['terms'] as $term)
        {
        $this->SetFont("Arial","B");
        $this->Cell(26.625,5,"Result","B,L",0,"L");
        $this->SetFont("Arial","");
        $this->Cell(26.625,5,(!empty($viewModel['failed'][$viewModel['student']->id][$term]))?$viewModel['failed'][$viewModel['student']->id][$term]:'',"B,R",0,"L");
        }
        /*$this->SetFont("Arial","B");
        $this->Cell(26.625,5,"Result","B",0,"L");
        $this->SetFont("Arial","");
        $this->Cell(26.625,5,(!empty($this->data['firstTerm']['marks']))?$this->data['firstTermResult']:'',"B,R",0,"L");
        $this->SetFont("Arial","B");
        $this->Cell(26.625,5,"Result","B",0,"L");
        $this->SetFont("Arial","");
        $this->Cell(26.625,5,(!empty($this->data['finalTerm']['marks']))?$this->data['finalTermResult']:'',"B,R",1,"L");*/

        $this->SetY(200);
        $this->Cell(4,5," ","",0,"C");
        $this->Cell(20,5,"Class Teacher","T",0,"C");
        $this->Cell(4,5," ","",0,"C");
        $this->Cell(20,5,"Guardian","T",0,"C");
        $this->Cell(4,5," ","",0,"C");
        $this->Cell(24,5,"Headmaster","T",0,"C");
        $this->Cell(55,5," ","",0,"C");
        $this->Cell(20,5,"Class Teacher","T",0,"C");
        $this->Cell(4,5," ","",0,"C");
        $this->Cell(20,5,"Guardian","T",0,"C");
        $this->Cell(4,5," ","",0,"C");
        $this->Cell(24,5,"Headmaster","T",0,"C");
        $this->Cell(50,5," ","",0,"C");
        $this->Cell(20,5,"Class Teacher","T",0,"C");
        $this->Cell(4,5," ","",0,"C");
        $this->Cell(20,5,"Guardian","T",0,"C");
        $this->Cell(4,5," ","",0,"C");
        $this->Cell(24,5,"Headmaster","T",0,"C");
    }
}
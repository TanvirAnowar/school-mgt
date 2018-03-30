<?php

class IspahaniProgressReport extends HighSchoolProgressReport
{
	public function reportHeader($viewModel)
    {

        $student = $viewModel['student'];
        $studentClassRoll = $viewModel['classRoll'];
        $session = $viewModel['session'];
        $className = $viewModel['class']->class_name;
        $sectionName = $viewModel['section']->section_name;
        $shiftName = $viewModel['shift']->shift_name;
        $systemName = Option::getData('vendor_name');
        $systemAddress = Option::getData('vendor_address');
        $this->SetFont('Arial', 'B', 14);
        $this->cell(329, 10, $systemName , 0, 1, "C");
        $this->SetFont('Arial', '', 12);        
        $this->SetX(round(329/2) -10);
        $this->Cell(40,8,$systemAddress,0,1,"C");
        $this->SetX(round(329/2) -10);
        $this->SetFont('Arial', 'B', 12);     
        $this->cell(40,8, "Academic Transcript",0,1,"C");
        $this->SetLineWidth(.5);
        $this->Cell(250,10,"Student Name: ".$student->name,0,1,"L");
        $this->SetLineWidth(0);
        $this->SetFont('Arial', 'I', 10);
       	
       	$this->grossMarkDist();
       	$grades = $viewModel['class']->Grades;
        $this->gradeChart($grades,200,15,4.5,45.5);
        $this->relevantGrading(255,45.5,25,4.5);
    }

    public function grossMarkDist()
    {
    	$this->cell(180,4.5,"Gross Marks-Distribution",1,1,"C");
    	$this->SetFont('Arial', '', 8);
    	$this->Cell(45,4.5,"Subjects",1,0,"L");
    	$this->Cell(11.25,4.5,"MCQ.",1,0,"L");
    	$this->Cell(11.25,4.5,"Crtv.",1,0,"L");
    	$this->Cell(11.25,4.5,"Prac.",1,0,"L");
    	$this->Cell(11.25,4.5,"Total",1,0,"L");
    	$this->Cell(45,4.5,"Subjects",1,0,"L");
    	$this->Cell(11.25,4.5,"MCQ.",1,0,"L");
    	$this->Cell(11.25,4.5,"Crtv.",1,0,"L");
    	$this->Cell(11.25,4.5,"Prac.",1,0,"L");
    	$this->Cell(11.25,4.5,"Total",1,1,"L");

    	$subjects = array(
    			array('subject'=>'Bangla 1st','mcq'=>40,'crtv'=>60,'practical'=>'x','total'=>60),
    			array('subject'=>'Bangla 2nd','mcq'=>20,'crtv'=>30,'practical'=>'x','total'=>60),
    			array('subject'=>'English 1st','mcq'=>40,'crtv'=>60,'practical'=>'x','total'=>60),
    			array('subject'=>'English 2nd','mcq'=>40,'crtv'=>60,'practical'=>'x','total'=>60),
    			array('subject'=>'Mathematics','mcq'=>40,'crtv'=>60,'practical'=>'x','total'=>60),
    			array('subject'=>'Science','mcq'=>40,'crtv'=>60,'practical'=>'x','total'=>60),
    			array('subject'=>'Bangladesh & global studies','mcq'=>40,'crtv'=>60,'practical'=>'x','total'=>60),
    			array('subject'=>'Religion','mcq'=>40,'crtv'=>60,'practical'=>'x','total'=>60),
    			array('subject'=>'Physical Education','mcq'=>40,'crtv'=>60,'practical'=>'x','total'=>60),
    			array('subject'=>'Life & work oriented','mcq'=>40,'crtv'=>60,'practical'=>'x','total'=>60),
    			array('subject'=>'ICT','mcq'=>40,'crtv'=>60,'practical'=>'x','total'=>60),
    			array('subject'=>'Arts & crafts','mcq'=>40,'crtv'=>60,'practical'=>'x','total'=>60),
    			array('subject'=>'Agri. Education','mcq'=>40,'crtv'=>60,'practical'=>'x','total'=>60)
		);
	
		for($i=0; $i<14; $i++)
		{
	    	if($i<=6)
	    	{
	    		$this->Cell(45,4.5,(isset($subjects[$i]) ? $subjects[$i]['subject'] : ''),1,0,"L");
	    		$this->Cell(11.25,4.5,(isset($subjects[$i]) ? $subjects[$i]["mcq"]  : ''),1,0,"L");
	    		$this->Cell(11.25,4.5,(isset($subjects[$i]) ? $subjects[$i]["crtv"]  : ''),1,0,"L");
	    		$this->Cell(11.25,4.5,(isset($subjects[$i]) ? $subjects[$i]["practical"]  : ''),1,0,"L");
	    		$this->Cell(11.25,4.5,(isset($subjects[$i]) ? $subjects[$i]["total"]  : ''),1,1,"L");
	    	}
	    	else
	    	{

		    	$this->SetXY(100,(23.5+($i*4.5)));
		    	$this->Cell(45,4.5,(isset($subjects[$i]) ?  $subjects[$i]['subject'] : ''),1,0,"L");
		    	$this->Cell(11.25,4.5,(isset($subjects[$i]) ? $subjects[$i]["mcq"]  : ''),1,0,"L");
		    	$this->Cell(11.25,4.5,(isset($subjects[$i]) ? $subjects[$i]["crtv"]  : ''),1,0,"L");
		    	$this->Cell(11.25,4.5,(isset($subjects[$i]) ? $subjects[$i]["practical"]  : ''),1,0,"L");
		    	$this->Cell(11.25,4.5,(isset($subjects[$i]) ? $subjects[$i]["total"]  : ''),1,1,"L");
	    	}
    	}
    }

    public function relevantGrading($x,$y,$w,$h)
    {
    	$this->SetXY($x,$y);
        $this->Cell($w*2,$h*2,"Relevant Grading",1,1,"C");
        $this->SetXY($x,($y+$h*2));
        $this->Cell($w,$h,"Grade",1,0,"C");
        $this->Cell($w,$h,"Indication",1,1,"C");
		$this->SetX($x);
        $this->Cell($w,$h,"A",1,0,"C");
        $this->Cell($w,$h,"Excellent",1,1,"C");
        $this->SetX($x);
        $this->Cell($w,$h,"B",1,0,"C");
        $this->Cell($w,$h,"Good",1,1,"C");
        $this->SetX($x);
        $this->Cell($w,$h,"C",1,0,"C");
        $this->Cell($w,$h,"Satisfactory",1,1,"C");
        $this->SetX($x);
        $this->Cell($w,$h,"D",1,0,"C");
        $this->Cell($w,$h,"Guidance Needed",1,1,"C");
        $this->SetX($x);
        $this->Cell($w,$h,"",1,0,"C");
        $this->Cell($w,$h,"",1,1,"C");
        $this->SetX($x);
        $this->Cell($w,$h,"",1,0,"C");
        $this->Cell($w,$h,"",1,1,"C");
    }

    public function contentHeader($viewModel,$y=90)
    {

        $terms = $viewModel['terms'];
        $termCount = count($terms);
        $this->SetY($y);
        $this->SetLineWidth(.2);
        $this->SetFont('Arial', 'B', 8);
        if($termCount == 2)
        {
            $w = 50;
        }else if($termCount == 3){
            $w = 30;
        }
        $this->Cell(($w/4), 14, "Sl", 1, 0, "C");
        $this->Cell($w, 14, "Subject", 1, 0, "C");
        $this->Cell(($w/2), 14, "Full\nMark", 1, 0, "C");
        foreach($terms as $term)
        {

            if($termCount == 2)
            {
                $w = 65; $h = 7;
            }else if($termCount == 3){
                $w = 50; $h=7;
            }
            $this->Cell($w, $h, $term, 1, 0, "C");
        }

        if($termCount == 2)
        {
            $w = 160; $h = 7;
        }else if($termCount == 3){
            $w = 160; $h=7;
        }
        $this->Cell($w, $h, "Combined Result", 1, 1, "C");


        $w =''; $h = '';

        switch(count($viewModel['markTypes']))
        {
            case 1:
                if($termCount == 2)
                {
                    $w = 21.66; $h = 7; $y=$y+$h; $x = 87;
                    $this->SetXY($x, $y);
                }else if($termCount == 3){
                    $w = 16.66; $h = 7; $y=$y+$h; $x = 62.5;
                    $this->SetXY($x, $y);
                }
                break;
            case 2:
                if($termCount == 2)
                {
                    $w = 16.25; $h = 7; $y=$y+$h; $x = 87;
                    $this->SetXY($x, $y);
                }else if($termCount == 3){
                    $w = 12.5; $h = 7; $y=$y+$h; $x = 55;
                    $this->SetXY($x, $y);
                }

                break;
            case 3:
                if($termCount == 2)
                {
                    $w = 13; $h=7; $y=$y+$h; $x = 87;
                    $this->SetXY($x, $y);

                }else if($termCount == 3){
                    $w = 10; $h=7; $y=$y+$h; $x = 55;
                    $this->SetXY($x, $y);
                }

                break;
            case 4:
                if($termCount == 2)
                {
                    $w = 10.83; $h=7; $y=$y+$h;  $x = 87;
                    $this->SetXY($x, $y);
                }else if($termCount == 3){
                    $w = 8.33; $h = 7; $y=$y+$h;  $x = 55;
                    $this->SetFontSize(8);
                    $this->SetXY($x, $y);
                }

                break;
        }


        foreach($terms as $term)
        {

            foreach($viewModel['markTypes'] as $type)
            {
                $this->Cell($w, $h, str_replace(" ","\n", substr(ucwords($type),0,3)), "B,R", 0, "C");
            }
            $this->Cell($w, $h, "Total", "B,R", 0, "C");$this->Cell($w, $h, "Highest", "B,R", 0, "C");
        }

        if($termCount == 2)
        {
            $w =40; $h=3.5;
        }else if($termCount ==3){
            $w=32; $h=3.5;
        }

        $termRules = Option::getData('term_rules');
        $termRules = json_decode($termRules);
        foreach($terms as $trm)
        {
            $percentage = (!empty($termRules->{$trm}))?$termRules->{$trm}: 0;
            $a = trim(str_replace("term", "",strtolower($trm)));
            $this->Cell($w, $h, ucfirst($a).' ('.$percentage. '%)', "B,R", 0, "C");
        }

        if($termCount == 2)
        {
            $this->Cell(80, $h, "Total", "B,R", 1, "C");
            $this->SetX(190);

        }else if($termCount == 3){
            $this->Cell(64, $h, "Total", "B,R", 1, "C");
            $this->SetX(190);

        }


        switch(count($viewModel['markTypes']))
        {
            case 1:
                if($termCount == 2)
                {
                    $cW = 40;
                }else if($termCount == 3){
                    $cW = 32;
                }
                break;
            case 2:
                if($termCount == 2)
                {
                    $cW = 20;
                }else if($termCount == 3){
                    $cW = 16;
                }

                break;
            case 3:
                if($termCount == 2)
                {
                    $cW = 13.33;
                }else if($termCount == 3){
                    $cW = 10.66;
                }

                break;
            case 4:
                if($termCount == 2)
                {
                    $cW = 10;
                }else if($termCount == 3){
                    $cW = 8;
                }

                break;
        }

        foreach($terms as $term)
        {
            foreach($viewModel['markTypes'] as $type)
            {
                $this->Cell($cW ,$h,str_replace(" ","\n", substr(ucwords($type),0,3)),"B,R",0,"C");
            }

        }

        foreach($viewModel['markTypes'] as $type)
        {
            $this->Cell($cW ,$h,str_replace(" ","\n", substr(ucwords($type),0,3)),"B,R",0,"C");
        }

        switch(count($viewModel['markTypes']))
        {
            case 1:
                if($termCount == 2)
                {
                    $cW = 10;
                }else if($termCount == 3){
                    $cW = 8;
                }
                break;
            case 2:
                if($termCount == 2)
                {
                    $cW = 10;
                }else if($termCount == 3){
                    $cW = 8;
                }

                break;
            case 3:
                if($termCount == 2)
                {
                    $cW = 10;
                }else if($termCount == 3){
                    $cW = 8;
                }

                break;
            case 4:
                if($termCount == 2)
                {
                    $cW = 10;
                }else if($termCount == 3){
                    $cW = 8;
                }

                break;
        }

        $this->Cell($cW,$h,"Total","B,R",0,"C");
        $this->Cell($cW,$h,"Gp","B,R",0,"C");
        $this->Cell($cW,$h,"Grade","B,R",0,"C");
        $this->Cell($cW,$h,"GPA","B,R",1,"C");

    }

    public function subjectsMarksArea($subject,$marks,$markTypes,$terms,$i=0)
    {

        $dimension = $this->getNormalCellDimension($markTypes,$terms);
        $w = $dimension['w'];
        $h = $dimension['h'];
        $subW = $dimension['subW'];

        $subjectName = $subject->subject_name;

        $this->SetFont('Arial', '', 10);
        $this->Cell(($subW/4), $h, ($i+1), 1, 0, "C");
        $this->Cell($subW,$h,$subjectName,"L,B,R",0,"C");
        $this->Cell(($subW/2),$h, json_decode($subject->full_mark)->{'Continuous assessment'},"L,B,R",0,"C");
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
                    $this->Cell($w,$h,"","L,B,R",0,"C");
                }
                $this->Cell($w,$h,"","L,B,R",0,"C");
                $this->Cell($w,$h,"","L,B,R",0,"C");
            }

        }

    }

    public function combineResultArea($index,$count,$subject,$marks,$terms,$markTypes)
    {
        $subjectName = $subject->subject_name;
        $dimension = $this->getCombineAreaCellDimension($markTypes,$terms);
        $cW = $dimension['cW'];
        $h  = $dimension['h'];

        foreach($terms as $term)
        {


            foreach($markTypes as $type)
            {

                $percentageTotalMark = (!empty($marks[$term]->subjects->{$subjectName}->percentage_types->{strtolower($type)}))?
                    $marks[$term]->subjects->{$subjectName}->percentage_types->{strtolower($type)} : '';
                $this->Cell($cW ,$h,$percentageTotalMark,"B,R",0,"C");
            }

        }
       // Helpers::debug((array)$marks['COMBINE']->subjects->{$subject->subject_name});die();
        foreach($markTypes as $type)
        {
            $combineSubjectTotal = (!empty($marks['COMBINE']->subjects->{$subject->subject_name}->types->{strtolower($type)}))?
                $marks['COMBINE']->subjects->{$subject->subject_name}->types->{strtolower($type)} : '';
            $this->Cell($cW ,$h,$combineSubjectTotal,"B,R",0,"C");
        }

        $dimension = $this->getCombineTotalAreaDimension($markTypes,$terms);
        $cW = $dimension['cW'];
        $h  = $dimension['h'];

        $total = (!empty($marks['COMBINE']->subjects->{$subject->subject_name}->subject_total))?
                    $marks['COMBINE']->subjects->{$subject->subject_name}->subject_total : '';
        
        $this->Cell($cW,$h,$total,"B,R",0,"C");

        if($subject->subject_dependency){
            $gp = '';
            $grade = '';
        }else{
            $gp = (!empty($marks['COMBINE']->subjects->{$subject->subject_name}->gpa->point))?
                $marks['COMBINE']->subjects->{$subject->subject_name}->gpa->point : '';
            $grade = (!empty($marks['COMBINE']->subjects->{$subject->subject_name}->gpa->grade))?
                $marks['COMBINE']->subjects->{$subject->subject_name}->gpa->grade : '';
        }
        $this->Cell($cW,$h,$gp,"B,R",0,"C");
        $this->Cell($cW,$h,$grade,"B,R",0,"C");

        $this->Cell($cW,$h,"","R",1,"C");


    }


    public function totalMarkArea($marks,$markTypes,$terms)
    {

        $dimension = $this->getNormalCellDimension($markTypes,$terms);
        $w = $dimension['w'];
        $h = $dimension['h'];
        $subW = $dimension['subW'];

        $this->Cell($subW,$h,"Total","L,B,R",0,"C");
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
            $w =40; $h=4.5;
        }else if(count($terms) ==3){
            $w=32; $h=4.5;
        }

        foreach($terms as $trm)
        {

            $this->Cell($w, $h, " ", "B,R", 0, "C");

        }
        $this->Cell($w, $h, " ", "B,R", 0, "C");
        $total = (!empty($marks['COMBINE']->total))? $marks['COMBINE']->total : '';
        $cgpa_total = (!empty($marks['COMBINE']->cgpa_total))? $marks['COMBINE']->cgpa_total : '';
        $dimension = $this->getCombineTotalAreaDimension($markTypes,$terms);
        $cW = $dimension['cW'];
        $h  = $dimension['h'];
        $this->Cell($cW, $h, $total, "B,R", 0, "C");
        $this->Cell($cW, $h, $cgpa_total, "B,R", 0, "C");
        $this->Cell($cW, $h, "", "B,R", 0, "C");
        $this->Cell($cW, $h, " ", "B,R", 1, "C");
    }

    public function combineSubjectMarkArea($subject,$marks,$markTypes,$terms)
    {
        $dimension = $this->getNormalCellDimension($markTypes,$terms);
        $w = $dimension['w'];
        $h = $dimension['h'];
        $subW = $dimension['subW'];

        $subjectName = $subject;

        $this->SetFont('Arial', 'B', 9.5);

        $this->Cell($subW,$h,$subjectName.' Total',"L,B,R",0,"R");
        $this->SetFont('Arial', '', 9.5);
        foreach($terms as $index =>$term)
        {
            if(!empty($marks[$term]->subjects_dependent->{$subjectName}))
            {
                foreach($markTypes as $type)
                {
                    $types = $marks[$term]->subjects_dependent->{$subjectName}->types;


                    $mark = (!empty($types->{strtolower($type)}))? $types->{strtolower($type)}: '';

                    $this->Cell($w,$h,$mark,"L,B,R",0,"C");

                }

                $obtainedMark = $marks[$term]->subjects_dependent->{$subjectName}->subject_total;
                $this->Cell($w,$h,$obtainedMark,"L,B,R",0,"C");
                $this->Cell($w,$h,"","L,B,R",0,"C");
            }else{
                foreach($markTypes as $type)
                {
                    $this->Cell($w,$h,"","L,B,R",0,"C");
                }
                $this->Cell($w,$h,"","L,B,R",0,"C");
                $this->Cell($w,$h,"","L,B,R",0,"C");
            }

        }
    }

    public function combineSubjectCombineResultArea($index,$count,$subject,$marks,$terms,$markTypes)
    {
        //Helpers::debug($marks);die();
        $dimension = $this->getCombineAreaCellDimension($markTypes,$terms);
        $cW = $dimension['cW'];
        $h  = $dimension['h'];
        $subjectName = explode(" ",$subject->subject_name);


        foreach($terms as $term)
        {
            foreach($markTypes as $type)
            {
                $percentageTotalMark = (!empty($marks[$term]->subjects_dependent->{trim($subjectName[0])}->percentage_types->{strtolower($type)}))?
                    $marks[$term]->subjects_dependent->{trim($subjectName[0])}->percentage_types->{strtolower($type)} : '';
                $this->Cell($cW ,$h,$percentageTotalMark,"B,R",0,"C");
            }

        }

        foreach($markTypes as $type)
        {
            $combineSubjectTotal = (!empty($marks['COMBINE']->subjects_dependent->{trim($subjectName[0])}->types->{strtolower($type)}))?
                $marks['COMBINE']->subjects_dependent->{trim($subjectName[0])}->types->{strtolower($type)} : '';
            $this->Cell($cW ,$h,$combineSubjectTotal,"B,R",0,"C");
        }


        $dimension = $this->getCombineTotalAreaDimension($markTypes,$terms);
        $cW = $dimension['cW'];
        $h  = $dimension['h'];

        $total = (!empty($marks['COMBINE']->subjects_dependent->{trim($subjectName[0])}->subject_total))?
                     $marks['COMBINE']->subjects_dependent->{trim($subjectName[0])}->subject_total : '';

        $this->Cell($cW,$h,$total,"B,R",0,"C");


        $gp = (!empty($marks['COMBINE']->subjects_dependent->{trim($subjectName[0])}->gpa->point))?
            $marks['COMBINE']->subjects_dependent->{trim($subjectName[0])}->gpa->point : '';
        $grade = (!empty($marks['COMBINE']->subjects_dependent->{trim($subjectName[0])}->gpa->grade))?
            $marks['COMBINE']->subjects_dependent->{trim($subjectName[0])}->gpa->grade : '';

        $this->Cell($cW,$h,$gp,"B,R",0,"C");
        $this->Cell($cW,$h,$grade,"B,R",0,"C");

        $this->Cell($cW,$h,"","R",1,"C");

    }

    public function gradeChart($grades,$x,$w,$h,$y=4)
    {

    	$this->SetXY($x,$y);
    	parent::gradeChart($grades,$x,$w,$h,$y);
    }

    public function reportFooter($viewModel)
    {

    }
}
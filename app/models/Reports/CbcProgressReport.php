<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/7/15
 * Time: 1:55 PM
 */

class CbcProgressReport extends CollegeProgressReport{

    public function __construct($type,$size,$paper)
    {
        parent::__construct($type,$size,$paper);


    }

    public function reportFooter($viewModel)
    {
        $this->SetXY(10,188);
        $this->Cell(25,5,"Examiner","T",0,"C");
        $this->Cell(2,1,"",0,0,"C");
        $this->SetXY(320,188);
        $this->Cell(23,5,"Principal","T",0,"C");
        $this->SetY(193);
        //$this->Cell(270,12,"","L,B,R",1,"C");
        $this->SetFont('Arial', 'I', 8);
    }
} 
<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/7/15
 * Time: 1:55 PM
 */

class TransactionReport extends Report{

    public function __construct($type,$size,$paper)
    {
        parent::__construct($type,$size,$paper);


    }

    public function Header()
    {
        $this->SetTopMargin(10);
        $this->SetY(10);
        //$this->reportHeader();
    }

    public function reportHeader($headerData)
    {
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(190,260,'',1,1);
        $this->setY(10);
        $this->Cell(190,20,"INVOICE",0,1,"C");

        $this->SetFont('Arial','B',10);
        $this->Cell(25,10,"Invoice No:",0,0,"R");
        $this->SetFont('Arial','');
        $this->Cell(100,10,$headerData[0]->invoice_number,0,0);

        $this->SetFont('Arial','B',10);
        $this->Cell(25,10,"Date:",0,0,"R");
        $this->SetFont('Arial','');
        $this->Cell(25,10,Helpers::dateTimeFormat('j F, Y',$headerData[0]->created_at),0,1);

        /*$this->SetFont('Arial','B',10);
        $this->Cell(25,10,"Month:",0,0,"R");
        $this->SetFont('Arial','');
        $this->Cell(100,10,$headerData[0]->month,0,1);
        */
        $this->Cell(100,10,"",0,1);
        $this->SetX(12);
        $this->SetFont('Arial','B',10);
        $this->Cell(20,10,"Sl No.",1,0,"C");
        $this->Cell(38,10,"Head.",1,0,"C");
        $this->Cell(74,10,"Description",1,0,"C");
        $this->Cell(20,10,"Ref No.",1,0,"C");
        $this->Cell(34,10,"Amount (BDT).",1,1,"C");

    }

    public function generateReport($finance)
    {
        $total = 0;
        foreach($finance as $i=> $tr)
        {
            $transaction = AccountTransaction::where('transaction_code',$tr->transaction_code)->first();
            $index = ($i+1);
            $this->SetFont('Arial','',10);
            $this->SetX(12);
            $this->Cell(20,10,$index,"L,R,B",0,"C");
            $this->Cell(38,10,$tr->head,"R,B",0,"C");
            $this->Cell(74,10,$tr->description,"R,B",0,"C");
            $this->Cell(20,10,$tr->ref_no,"R,B",0,"C");

            if(trim($transaction->transaction_type) == AccountTransaction::$TYPE_INCOME)
            {
                $amount = ($tr->amount);
                $total += ($tr->amount);
            }else{
                $amount = -($tr->amount);
                $total -= ($tr->amount);
            }
            $this->Cell(34,10,$amount."  ","R,B",1,"R");
            if(($index%16) == 0)
            {

                $this->AddPage();
            }
        }
        $this->SetX(12);
        $this->SetFont('Arial','B',10);
        $this->Cell(152,10,"Total ","L,R,B",0,"R");

        $this->Cell(34,10,$total."  ","R,B",1,"R");

    }

    public function reportFooter($viewModel)
    {

    }




} 
<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/7/15
 * Time: 1:55 PM
 */

class IncomeStatementReport extends Report{

    public function __construct($type,$size,$paper)
    {
        parent::__construct($type,$size,$paper);


    }

    public function Header()
    {
        $this->SetTopMargin(10);
        $this->SetY(10);

    }

    public function reportHeader($data)
    {


        $this->SetFont('Arial', 'B', 18);
        $this->Cell(190,260,'',1,1);
        $this->setY(10);
        $this->Cell(190,20,"Income Statement",0,1,"C");
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(30,20,'Date:',0,0,"L");
        $this->Cell(30,20,'Date:'.Helpers::dateTimeFormat('j F, Y',$data->created_at),0,1,"L");
    }

    public function generateExpenseReport($incomeStatements)
    {
        $income_statement = json_decode($incomeStatements->income_statement);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(15);
        $this->Cell(180,12,'Expenses:',0,1,"L");
        $this->SetFont('Arial', '', 10);

        foreach($income_statement->expenses as $expense){
            $expense = json_decode($expense);
            $this->SetX(15);
            $this->Cell(60,10,$expense->head,"B",0,"L");
            $this->Cell(60,10,$expense->description,"B",0,"L");
            $this->Cell(60,10,$expense->amount,"B",1,"R");
        }
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(15);
        $this->Cell(60,10,'',"B",0,"L");
        $this->Cell(60,10,'Total',"B",0,"R");
        $this->Cell(60,10,$incomeStatements->total_expenses,"B",1,"R");


    }

    public function generateIncomeReport($incomeStatements)
    {
        $income_statement = json_decode($incomeStatements->income_statement);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(15);
        $this->Cell(180,12,'Incomes:',0,1,"L");
        $this->SetFont('Arial', '', 10);

        foreach($income_statement->incomes as $incomes){
            $incomes = json_decode($incomes);
            $this->SetX(15);
            $this->Cell(60,10,$incomes->head,"B",0,"L");
            $this->Cell(60,10,$incomes->description,"B",0,"L");
            $this->Cell(60,10,$incomes->amount,"B",1,"R");
        }

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(15);
        $this->Cell(60,10,'',"B",0,"L");
        $this->Cell(60,10,'Total',"B",0,"R");
        $this->Cell(60,10,$incomeStatements->total_incomes,"B",1,"R");


    }

    public function generateNetTotal($incomeStatements)
    {
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(15);
        $this->Cell(180,12,'Net Profit / Loss:',"B",1,"L");
        $this->SetX(15);
        $this->Cell(60,10,'',"B",0,"L");
        $this->Cell(60,10,'Total Expenses',"B",0,"R");
        $this->Cell(60,10,$incomeStatements->total_expenses,"B",1,"R");
        $this->SetX(15);
        $this->Cell(60,10,'',"B",0,"L");
        $this->Cell(60,10,'Total Incomes',"B",0,"R");
        $this->Cell(60,10,- $incomeStatements->total_incomes,"B",1,"R");
        $netTotal = ($incomeStatements->total_expenses-$incomeStatements->total_incomes);
        $profitLoss = ($netTotal>0)? 'Net Loss': 'Net Profit';
        $this->SetX(15);
        $this->Cell(60,10,'',"B",0,"L");
        $this->Cell(60,10,$profitLoss,"B",0,"R");
        $this->Cell(60,10,abs($netTotal),"B",1,"R");
    }

    public function reportFooter($viewModel)
    {

    }




} 
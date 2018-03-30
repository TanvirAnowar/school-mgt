<?php

class OrkidsOne extends ClassOne
{
	public function __construct(IResultPublish $r)
    {
        parent::__construct($r);

    }

    /**
    * @override pass_fail
    */
	public function pass_fail($subject,$student_id)
    {

        if(!empty($this->passMark[$subject['subject_name']]))
        {
           
            $passMarkTotal = 0;
            foreach($this->passMark[$subject['subject_name']] as $type)
            {
                $passMarkTotal = $type['pass']->{$this->currentTerm};
            }
            
            if($subject['subject_total'] < $passMarkTotal)
            {
                $this->failedSubjects[$student_id][$subject['subject_name']] = $subject['subject_total'];
               
            }

        }	
    }
}
<?php

class OnkurTabulationSheet extends PrimaryTabulationSheet
{
	public function __construct($type,$size,$paper)
    {
        parent::__construct($type,$size,$paper);
       
        $this->subjectWidth = 29.85;
        $this->cellWidth = 9.95;
    }
}
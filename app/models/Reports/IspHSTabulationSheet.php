<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/7/15
 * Time: 1:45 PM
 */

class IspHSTabulationSheet extends HighSchoolTabulationSheet{

    public function __construct($type,$size,$paper)
    {
        parent::__construct($type,$size,$paper);
        $this->cell_width = 9.75;
        $this->subjectWidth = 19.5;
    }

} 
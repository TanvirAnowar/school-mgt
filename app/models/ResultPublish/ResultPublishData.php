<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/24/14
 * Time: 12:54 PM
 */

class ResultPublishData implements IResultPublish{

    protected $observers = array();
    protected $currentSearchingData;
    protected $currentClass;
    protected $currentSection;
    protected $studentsMarks;

    public function __construct($searchMark)
    {
        $this->currentSearchingData = $searchMark;
        $this->currentClass = SchoolClass::find($this->currentSearchingData['class_id']);
        $this->currentSection = SchoolSection::find($this->currentSearchingData['section_id']);
    }

    public function registerObserver(IPublish $o)
    {
        $this->observers[] = $o;
    }

    public function unregisterObserver(IPublish $o)
    {
        $index = array_search($o,$this->observers);
        unset($this->observers[$index]);
    }

    public function populateResult()
    {
        $class = strtolower($this->currentClass->class_name);

        foreach($this->observers as $observer)
        {
            if(preg_match('/'.$class.'/',strtolower($observer->getName())))
            {
                if(!empty($this->studentsMarks))
                {
                    $observer->setMark($this->studentsMarks);
                    return $observer->update();
                }else{
                    return null;
                }
            }
        }

    }

    public function setStudentMark($marks)
    {
        $this->studentsMarks = $marks;
        return $this;
    }

    public function getStudentMark()
    {
        return $this->studentsMarks;
    }

    public function getClass()
    {
        return $this->currentClass;
    }

    public function getSection()
    {
        return $this->currentSection;
    }
} 
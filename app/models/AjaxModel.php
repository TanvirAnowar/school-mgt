<?php
/**
 * Created by PhpStorm.
 * User: sanzeeb
 * Date: 15-Feb-15
 * Time: 11:39 AM
 */

class AjaxModel{

    public function get_class_wise_section($class_id)
    {
        $classes = SchoolClass::find($class_id);
        if(count($classes))
        {
            $sections = $classes->Sections;
            foreach($sections as $key=> $section)
            {
                $sections[$key]['shift_name'] = $section->getShift->shift_name;
            }
            return $sections->toJson();
        }
        else{
            return json_encode(array());
        }
    }

    public function get_class_wise_subject($class_id)
    {
        $subjects = SchoolClass::find($class_id);
        if(count($subjects))
            return $subjects->Subjects->toJson();
        else
            return json_encode(array());
    }


}
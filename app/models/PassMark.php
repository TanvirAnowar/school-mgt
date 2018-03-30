<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/28/14
 * Time: 11:30 AM
 */

class PassMark {

    public static function getList($class_id,$term='')
    {

        $passMarkList = array();
        $results = CombineMarkSettings::where('class_id',$class_id)->where('deleted_at',0)->get();
        
        if(!empty($results))
        {
            foreach($results as $result)
            {
                $markType = strtolower($result->getMarkType->mark_type);
                $passMarkList[$result->title][$markType]['pass'] = $result->pass;
               // $passMarkList[$result->title][$markType]['convert_at'] = $result->convert_at;

            }
        }

        $results = MarkSettings::with('getSubject')->where('class_id',$class_id)->where('deleted_at',0)->get();

        if(!empty($results))
        {
            //Helpers::debug($results,1);
            foreach($results as $result)
            {
                $passMarks = 0;
                $subject = $result->getSubject;
                $markType  = strtolower($result->getMarkType->mark_type);
                if((count($subject)) && ($subject->show_pass_mark))
                {

                    $passMarks = json_decode($subject->pass_mark); 

                }else{
                    
                    $passMarks = json_decode($result->pass);
                }
                
                $passMarkList[$result->getSubject->subject_name][$markType]['pass'] = $passMarks;
                $passMarkList[$result->getSubject->subject_name][$markType]['convert_at'] = $result->convert_at;
            }
        }
        
      // Helpers::debug($passMarkList);die();
        return $passMarkList;
    }


} 
<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 3/19/14
 * Time: 2:56 PM
 */

class Terms {

    public static function GetTerms()
    {
        $data = Option::getData('terms');
        $results = (!empty($data))? explode(",",$data) : array();

        if(!empty($results))
        {
            foreach($results as $i=> $result)
            {
                $results[$i] = trim($result);
            }

        }
        return $results;
    }
} 
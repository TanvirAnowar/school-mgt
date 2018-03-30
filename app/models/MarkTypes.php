<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 3/12/14
 * Time: 5:59 PM
 */

class MarkTypes extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "mark_types";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'mark_type_id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('mark_type','mark_type_order');

    /**
     * mark type is joined with mark settings so we can find out Grouped mark types those are associate with a class
     * cause one class have many subjects and each subject may have several mark types
     * @param $classId
     * @return mixed
     */
    public static function getDistinctMarkTypeAssocClass($classId)
    {
        $markTypes = array();
        $results = CombineMarkSettings::where('class_id',$classId)->where('deleted_at',0)->get();
        if(!empty($results))
        {
            foreach($results as $result)
            {
                $markType = strtolower($result->getMarkType->mark_type);
                $markTypes[ucfirst($markType)] = ucfirst($markType);

            }
        }
        $results = MarkSettings::where('class_id',$classId)->where('deleted_at',0)->get();

        if(!empty($results))
        {
            foreach($results as $result)
            {
                $markType = strtolower($result->getMarkType->mark_type);
                $markTypes[ucfirst($markType)] = ucfirst($markType);
            }
        }
        return $markTypes;
    }

} 
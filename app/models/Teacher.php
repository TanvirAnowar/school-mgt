<?php
/**
 * Description of Teacher
 *
 * @author Tanvir Anowar
 */
class Teacher extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "teacher";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Soft delete
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('name_initial','name','dob','father_name','mother_name','age','cell_phone','cell_phone_2','marital_status','gender',
        'religion','blood_group','present_address','permanent_address','email','nationality','national_id','photo');


    /**
     * Search a teacher profile
     * @param $str_to_search
     * @return string
     */
    public function search($str_to_search)
    {
        $txt = $str_to_search;
        $result = $this->where(function($query) use ($txt){
            $query->where('name','like',$txt.'%');
            $query->where('name_initial','like',$txt.'%','or');
            $query->where('cell_phone','like',$txt.'%','or');
            $query->where('email','like',$txt.'%','or');
            $query->where('national_id','like',$txt.'%','or');
        })->where('deleted_at','0')->get();

        return count($result)? $result->toJson() : json_encode(array());
    }
    
}

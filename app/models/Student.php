<?php

/**
 * Description of Student
 *
 * @author Tanvir Anowar
 */
class Student extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $table = "student";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('student_id','name','religion','father_cell_phone','mother_cell_phone','gender');


    public function getClass()
    {
        return $this->belongsTo('SchoolClass','class_id','class_id');
    }

    public function getSection()
    {
        return $this->belongsTo('SchoolSection','section_id','section_id');
    }

    public function getAllColumnsNames()
    {
        switch (DB::connection()->getConfig('driver')) {
            case 'pgsql':
                $query = "SELECT column_name FROM information_schema.columns WHERE table_name = '".$this->table."'";
                $column_name = 'column_name';
                $reverse = true;
                break;

            case 'mysql':
                $query = 'SHOW COLUMNS FROM '.$this->table;
                $column_name = 'Field';
                $reverse = false;
                break;

            case 'sqlsrv':
                $parts = explode('.', $this->table);
                $num = (count($parts) - 1);
                $table = $parts[$num];
                $query = "SELECT column_name FROM ".DB::connection()->getConfig('database').".INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'".$table."'";
                $column_name = 'column_name';
                $reverse = false;
                break;

            default:
                $error = 'Database driver not supported: '.DB::connection()->getConfig('driver');
                throw new Exception($error);
                break;
        }

        $columns = array();

        foreach(DB::select($query) as $i=> $column)
        {
            if($i==0)
                continue;
            $columns[] = $column->$column_name;
        }

        if($reverse)
        {
            $columns = array_reverse($columns);
        }

        return $columns;
    }

    public function search($str_to_search,$type="json")
    {
        $txt = $str_to_search;
        $result = $this->where(function($query) use ($txt){
            $query->where('student_id','like',$txt.'%');
            $query->where('name','like',$txt.'%','or');
            $query->where('father_name','like',$txt.'%','or');
            $query->where('mother_name','like',$txt.'%','or');
            $query->where('options','like',$txt.'%','or');
			
        })->where('deleted_at','0')->get();

        if($type=="json")
            return count($result)? $result->toJson() : json_encode(array());
        else
            return $result;
    }

    public static function unregisteredStudents($classId,$studentType,$type="json")
    {
        $results = self::where('class_id',$classId)
                        ->where('student_type',$studentType)
                        ->where('deleted_at','0')
                        ->get();
        $students = array();

        if(count($results))
        {

            foreach($results as $i=> $result)
            {
                $reg = Registration::where('student_id',$result->id)->where('active_reg',1)->first();
                $results[$i]['class_name'] = (!empty($result->getClass->class_name))? $result->getClass->class_name : 'N/A';
                $results[$i]['section_name'] = (!empty($result->getSection->section_name))? $result->getSection->section_name : 'N/A';
                $results[$i]['session'] = (!empty($reg))? $reg->session : '';
            }
            $students = $results;
        }

        if($type=="json")

            return count($students)? $students->toJson() : json_encode(array());
        else
            return count($students)? $students : array();
    }

    public function getOptionalSubject($session)
    {
        return $this->hasOne('StudentSubject','student_id','id')->where('subject_status','Optional')->where('session',$session)->first();
    }

}

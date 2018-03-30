<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/28/14
 * Time: 12:24 PM
 */

class SyncStudent extends Eloquent{

    /**
     * Table Name
     * @var string
     */
    protected $connection = "mysql_old";

    /**
     * Table Name
     * @var string
     */
    protected $table = "student_info_tbl";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'student_id';

    public function getAllColumnsNames()
    {

        $query = 'SHOW COLUMNS FROM '.$this->table;
        $column_name = 'Field';
        $reverse = false;

        $columns = array();

        foreach(DB::connection($this->connection)->select($query) as $i=> $column)
        {
            if($i==0)
                continue;
            if(in_array($column->$column_name,array('student_fname','student_lname','student_sex','student_mobileno','student_phone','student_religion')))
            {
            $columns[] = $column->$column_name;
            }
        }

        if($reverse)
        {
            $columns = array_reverse($columns);
        }

        return $columns;
    }
} 
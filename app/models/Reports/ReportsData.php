<?php

/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 5/4/14
 * Time: 5:16 PM
 */
class ReportsData extends Eloquent
{

    /**
     * Table Name
     * @var string
     */
    protected $table = "reports_data";

    /**
     * Primary Key
     * @var string
     */
    protected $primaryKey = 'course_plan_id';

    /**
     * Soft delete
     * @var bool
     */
    protected $softDelete = false;

    /**
     * @var array  only attributes that can be fill-able
     */
    protected $fillable = array('student_id', 'class_id', 'section_id', 'shift_id', 'term', 'class_roll', 'exam_year', 'mark_info', 'total_mark', 'cgpa', 'failed_counts');


    public static function storeResult($data)
    {
        if (!empty($data['results'])) {
            foreach ($data['results'] as $id => $result) {
                $reg = Registration::where('student_id', $id)->where('active_reg', 1)->first();
                if (count($reg)) {
                    $obj = ReportsData::firstOrNew(array(
                        'student_id' => $id,
                        'class_id' => $data['class_id'],
                        'section_id' => $data['section_id'],
                        'shift_id' => $data['shift_id'],
                        'term' => $data['term'],
                        'exam_year' => $data['session'],

                    ));
                    if (!$obj->exists) {
                        $obj->class_roll = $reg->class_roll;
                        $obj->mark_info = (!empty($result)) ? json_encode($result) : '';
                        $obj->total_mark = $result['total'];
                        $obj->cgpa = $result['cgpa'];
                        $obj->failed_counts = (!empty($result['failed_subject'])) ? count($result['failed_subject']) : '';
                        $obj->save();

                    } else {

                        $mark_info = (!empty($result)) ? json_encode($result) : '';
                        ReportsData::where('reports_data_id', $obj->reports_data_id)
                            ->where('deleted_at', 0)->update(array(
                                'mark_info' => $mark_info,
                                'failed_counts' => (!empty($result['failed_subject'])) ? count($result['failed_subject']) : '',
                                'cgpa' => $result['cgpa'],
                                'total_mark' => $result['total']
                            ));
                    }
                }

            }
            return 1;
        }
        return 0;
    }

    public static function getResult($class_id, $section_id, $session, $term)
    {
        $result = self::with('Student', 'Student.getClass', 'Student.getSection')
            ->where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->where('exam_year', $session)
            ->where('term', $term)
            ->orderBy('class_roll', 'ASC')->get();

        return $result;

    }

    public static function getResultForClass($class_id, $session, $term)
    {

        $result = DB::table('reports_data')->select('name', 'class_roll', 'section_name', 'total_mark', 'cgpa')
            ->join('student', 'student.id', '=', 'reports_data.student_id', 'left')
            ->join('section', 'section.section_id', '=', 'reports_data.section_id', 'left')
            ->where('reports_data.class_id', $class_id)
            ->where('exam_year', $session)
            ->where('term', $term)
            ->orderBy('cgpa', 'DESC')
            ->orderBy('total_mark', 'DESC')
            ->get();

        return $result;

    }

    public static function getResultForSection($class_id, $section_id, $session, $term)
    {

        $result = DB::table('reports_data')->select('name', 'class_roll', 'section_name', 'total_mark', 'cgpa')
            ->join('student', 'student.id', '=', 'reports_data.student_id', 'left')
            ->join('section', 'section.section_id', '=', 'reports_data.section_id', 'left')
            ->where('reports_data.class_id', $class_id)
            ->where('reports_data.section_id', $section_id)
            ->where('exam_year', $session)
            ->where('term', $term)
            ->orderBy('cgpa', 'DESC')
            ->orderBy('total_mark', 'DESC')
            ->get();

        return $result;

    }

    public static function getResultForAllPassedStudents($class_id, $section_id, $session, $term)
    {

        $query = DB::table('reports_data')->select('name', 'class_roll', 'section_name', 'total_mark', 'cgpa')
            ->join('student', 'student.id', '=', 'reports_data.student_id', 'left')
            ->join('section', 'section.section_id', '=', 'reports_data.section_id', 'left')
            ->where('reports_data.class_id', $class_id);

        if ($section_id != 'all')
            $query->where('reports_data.section_id', $section_id);

        $result = $query->where('cgpa', '!=', '0.00')
            ->where('exam_year', $session)
            ->where('term', $term)
            ->orderBy('cgpa', 'DESC')
            ->orderBy('total_mark', 'DESC')
            ->get();

        return $result;

    }

    public static function getResultForAllFailedStudents($class_id, $section_id, $session, $term)
    {

        $query = DB::table('reports_data')->select('name', 'class_roll', 'section_name', 'total_mark', 'cgpa')
            ->join('student', 'student.id', '=', 'reports_data.student_id', 'left')
            ->join('section', 'section.section_id', '=', 'reports_data.section_id', 'left')
            ->where('reports_data.class_id', $class_id);

        if ($section_id != 'all')
            $query->where('reports_data.section_id', $section_id);

        $result = $query->where('cgpa', '=', '0.00')
            ->where('exam_year', $session)
            ->where('term', $term)
            ->orderBy('cgpa', 'DESC')
            ->orderBy('total_mark', 'DESC')
            ->get();

        return $result;

    }

    public function Student()
    {
        return $this->belongsTo('Student', 'student_id', 'id');
    }


} 
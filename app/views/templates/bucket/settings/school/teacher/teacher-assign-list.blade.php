@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Assigned Teachers List
                    <span class="tools pull-right col-lg-3">
                        {{ Form::open(array('url'=>'school/teacher-assign/add','method'=>'get','class'=>'col-lg-8')) }}
                                <button class="btn btn-primary panel-btn" id="teacherAssignBtn" type="submit"><i class="fa fa-plus-circle"></i> Assign Teacher</button>
                        {{ Form::close() }}
                        {{ Form::open(array('url'=>'school/teacher-assign/trash','method'=>'get','class'=>'col-lg-2')) }}
                                <button class="btn btn-danger panel-btn" id="teacherAssignBtn" type="submit"><i class="fa fa-trash-o"></i> Trash</button>
                        {{ Form::close() }}
                      </span>
                </header>
                <div class="panel-body">
                    {{ Form::open(array('class'=>'cmxform form-horizontal', 'method'=>'post','url'=>url('school/save-teacher-assign'))) }}
                    <table class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Teacher name</th>
                            <th>Teacher Type</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Subject</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($teachers))
                            @foreach($teachers as $index=> $teacher)
                                <tr>
                                    <td>{{{($index + 1)}}}</td>
                                    <td>{{{ucfirst($teacher->getTeacher->name)}}}</td>
                                    @if($teacher->class_teacher)
                                        <td>
                                            <span class="label label-success label-mini">Class Teacher</span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="label label-primary label-mini">Subject Teacher</span>
                                        </td>
                                    @endif
                                    <td>{{{$teacher->getSection->getClass->class_name or ''}}}</td>
                                    <td>{{{$teacher->getSection->section_name or ''}}}-{{{$teacher->getSection->getShift->shift_name or ''}}}</td>
                                    <td>{{{$teacher->getSubject->subject_name or ''}}}</td>
                                    <td class="center hidden-phone">
                                        <a href="{{{url('school/teacher-assign/edit/'.$teacher->teacher_assign_id)}}}" class="grid-action-link"><i class="fa fa-pencil" title="Edit"></i></a>
                                        <a href="{{{$teacher->teacher_assign_id}}}" class="grid-action-link delete-teacher-assign"><i class="fa fa-trash-o" title="Delete"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Sl.</th>
                            <th>Teacher name</th>
                            <th>Teacher Type</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Subject</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                    {{Form::close()}}
                </div>

            </section>
        </div>
    </div>
</section>
<script type="text/javascript" language="javascript" src="{{$theme}}assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{$theme}}assets/data-tables/DT_bootstrap.js"></script>
<script src="{{$theme}}js/dynamic_table/dynamic_table_init.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/settings.js"></script>
@stop
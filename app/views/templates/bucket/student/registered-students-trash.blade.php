@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
{{Helpers::showMessage()}}
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
    List of Students
                           <span class="tools pull-right col-lg-3">
                            <!--     <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>-->
                                {{ Form::open(array('url'=>'student/registered-students','class'=>'col-lg-6','method'=>'get')) }}
                                    <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-list"></i> List
                                    </button>
                                {{ Form::close() }}
                               {{ Form::open(array('url'=>'student/registered-students-trash-clear','class'=>'col-lg-2','method'=>'post')) }}
                                    <button class="btn btn-danger panel-btn" type="submit"><i class="fa fa-trash-o"></i> Clear Trash
                                    </button>
                                {{ Form::close() }}
                             </span>
</header>
<div class="panel-body">
<div class="adv-table">
<div class="form">
    <fieldset>
        <legend>Search Registerd Students</legend>
        {{Form::open(array('url'=>'#','method'=>'post','class'=>'cmxform form-horizontal'))}}
        <div class="form-group">

        </div>
        {{Form::close()}}
    </fieldset>

</div>
<table class="display table table-bordered table-striped" id="dynamic-table">
    <thead>
        <tr>
            <th>Sl</th>
            <th>Reg ID</th>
            <th>Student ID</th>
            <th>Session/Year</th>
            <th>Student Name</th>
            <th>Class</th>
            <th>Section</th>
            <th>Shift</th>
            <th>Group</th>
            <th>Class Roll</th>
            <th class="hidden-phone">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(count($registeredStudents))
            @foreach($registeredStudents as $index => $register)
                <tr>
                    <td>{{{($index + 1)}}}</td>
                    <td>{{{$register->reg_id}}}</td>
                    <td>{{{$register->student_id}}}</td>
                    <td>{{{$register->session}}}</td>
                    <td>{{{$register->getStudent->name}}}</td>
                    <td>{{{$register->getClass->class_name}}}</td>
                    <td>{{{$register->getSection->section_name}}}</td>
                    <td>{{{$register->getShift->shift_name}}}</td>
                    <td>{{{$register->getGroup->group_name}}}</td>
                    <td>{{{$register->class_roll}}}</td>
                    <td class="hidden-phone">
                        <a href="{{{url('student/register/edit/'.$register->id)}}}" title="Edit" class="register-edit"><i class="fa fa-pencil"></i></a>
                        <a href="{{{url('student/register/view/'.$register->id)}}}" title="View" class="register-view"><i class="fa fa-eye"></i></a>

                        <a href="{{{$register->id}}}" class="register-undo" title="Retrieve"><i class="fa fa-undo"></i></a>
                        <a href="{{{$register->id}}}" title="View" class="register-remove"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th>Sl</th>
            <th>Unique ID</th>
            <th>Student ID</th>
            <th>Session/Year</th>
            <th>Student Name</th>
            <th>Class</th>
            <th>Section</th>
            <th>Shift</th>
            <th>Group</th>
            <th>Class Roll</th>
            <th class="hidden-phone">Action</th>
        </tr>
        <tr>
            <td colspan="11">{{$registeredStudents->links()}}</td>
        </tr>
    </tfoot>
</table>
</div>
</div>
</section>
</div>
</div>
</section>
<script src="{{$theme}}js/custom/registration.js"></script>
@stop
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
                                {{ Form::open(array('url'=>'student/register','class'=>'col-lg-8','method'=>'get')) }}
                                    <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-plus-circle"></i> New Register
                                    </button>
                                {{ Form::close() }}

                                {{ Form::open(array('url'=>'student/registered-students-trash','class'=>'col-lg-2','method'=>'get')) }}
                                    <button class="btn btn-danger panel-btn" type="submit"><i class="fa fa-trash-o"></i> Trash
                                    </button>
                                {{ Form::close() }}
                             </span>
</header>
<div class="panel-body">
<div class="adv-table">
<div class="form">
    <fieldset>
        <legend>Search Registerd Students</legend>
        {{Form::open(array('url'=>'#','method'=>'post', 'id'=>'searchReg','class'=>'cmxform form-horizontal'))}}
        <div class="form-group">
            <label for="subjects" class="control-label col-lg-1">Session</label>
            <div class="col-lg-1">
                <select class="form-control-select2" id="session" name="session" required>
                    <option value="">Select Year</option>
                    <?php $year = (int)date("Y")-1; $to = $year+10; ?>
                    <?php for($i = $year; $i<=$to; $i++){ ?>
                        <option value="{{{$i}}}">{{{$i}}}</option>
                    <?php } ?>
                </select>
            </div>
            <label for="subjects" class="control-label col-lg-1">Class</label>
            <div class="col-lg-2">
                <select class="form-control" name="class_id">
                    <option value="">Select</option>
                    @if(count($classes))
                        @foreach($classes as $class)
                            <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <label for="subjects" class="control-label col-lg-1">Section</label>
            <div class="col-lg-2">
                <select class="form-control" name="section_id">

                </select>
            </div>
            <label for="subjects" class="control-label col-lg-1">Class Roll</label>
            <div class="col-lg-1">
                <input type="text" class="form-control" name="class_roll"/>
            </div>
            <div class="col-lg-1">
                <button class="btn btn-info" id="searchRegStudent" type="button">Search</button>
            </div>
        </div>
        {{Form::close()}}
    </fieldset>

</div>
{{Form::open(array('id'=>'updateRegFrm','url'=>'/','method'=>'post'))}}
<table class="display table table-bordered table-striped" id="dynamic-table">
    <thead>
        <tr>
            <th>Sl</th>
            <th>Reg. ID</th>
            <!--<th>Unique ID</th>-->
            <th>Student ID</th>
            <th style="width:20px;">Session<br/>/Year</th>
            <th>Student Name</th>
            <th>Contact No.</th>
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
                <?php  $phoneNo = (!empty($register->getStudent->father_cell_phone))? $register->getStudent->father_cell_phone : $register->getStudent->mother_cell_phone; ?>
                <tr>
                    <td>{{{($index + 1)}}}</td>
                    <td>{{{$register->reg_id}}}</td>
                    <!--<td>{{{$register->getStudent->id}}}</td>-->
                    <td>{{{$register->getStudent->student_id}}}</td>
                    <td>{{{$register->session}}}</td>
                    <td>{{{$register->getStudent->name}}}</td>
                    <td>{{{$phoneNo}}}</td>
                    <td>{{{$register->getClass->class_name}}}</td>
                    <td>{{{$register->getSection->section_name}}}</td>
                    <td>{{{$register->getShift->shift_name}}}</td>
                    <td>{{{$register->getGroup->group_name}}}</td>
                    <td>{{{$register->class_roll}}}</td>
                    <td class="hidden-phone">
                        <a href="{{{url('student/register/edit/'.$register->id)}}}" title="Edit" class="register-edit"><i class="fa fa-pencil"></i></a>
                        <a href="{{{url('student/view/'.$register->student_id)}}}" title="Profile" class="register-view"><i class="fa fa-user"></i></a>
                        <a href="{{{url('student/register/view/'.$register->id)}}}" title="View" class="register-view"><i class="fa fa-eye"></i></a>
                        <a href="{{{$register->id}}}" class="register-del" title="Delete"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th>Sl</th>
            <th>Reg. ID</th>
            <!--<th>Unique ID</th>-->
            <th>Student ID</th>
            <th>Session/Year</th>
            <th>Student Name</th>
            <th>Contact No.</th>
            <th>Class</th>
            <th>Section</th>
            <th>Shift</th>
            <th>Group</th>
            <th>Class Roll</th>
            <th class="hidden-phone">Action</th>
        </tr>

        <tr>
            <td colspan="8">{{$registeredStudents->links()}}</td>

        </tr>

    </tfoot>
</table>
{{Form::close()}}
</div>
</div>
</section>
</div>
</div>
</section>
<script src="{{$theme}}js/custom/Classes.js"></script>
<script src="{{$theme}}js/custom/registration.js"></script>
@stop
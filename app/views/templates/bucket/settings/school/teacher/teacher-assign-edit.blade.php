@extends('templates.bucket.bucket')


@section('wrapper')
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Edit Teacher Assign
                    <span class="tools pull-right">
                        <!-- <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>-->

                      </span>
                </header>
                <div class="panel-body">
                    {{ Form::open(array('class'=>'cmxform form-horizontal', 'method'=>'post','url'=>url('school/update-teacher-assign'))) }}
                    <div class="form">
                    <input type="hidden" name="refurl" value="{{{url('school/teacher-assign')}}}"/>
                        <h4>Teaacher: {{{$teacherAssign->getTeacher->name}}}</h4>

                        <div class="form-group">
                            @if(count($classes))
                            @foreach($classes as $class)
                            @if($teacherAssign->getSection->getClass->class_id == $class->class_id)
                            <span class="label label-success">{{{$class->class_name}}}</span>
                            @endif
                            @endforeach
                            @endif
                            <label for="class_id" class="control-label col-lg-2">Class</label>
                            <div class="col-lg-2">


                                <select class="form-control" name="class_id" required>
                                    <option value="">Select</option>
                                    @if(count($classes))
                                        @foreach($classes as $class)

                                                <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>

                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject_id" class="control-label col-lg-2">Subject</label>
                            <div class="col-lg-2">
                                <select class="form-control-select2" name="subject_id" style="width:150px;">
                                    <option value="{{{$subeject->subject_id}}}">{{{$subeject->subject_name}}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="section_id" class="control-label col-lg-2">Section</label>
                            <div class="col-lg-2">
                                <select class="form-control" name="section_id" required>
                                    @if(count($sections))
                                        @foreach($sections as $section)
                                                @if($teacherAssign->section_id == $section->section_id)
                                                    <option value="{{{$section->section_id}}}">{{{$section->section_name}}}-{{{$section->getShift->shift_name}}}</option>
                                                @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="teacher_assign_status" class="control-label col-lg-2">Teacher Assigned for a</label>
                            <div class="col-lg-2">

                                @if($teacherAssign->status == 'term')
                                    <span><input type="radio" name="teacher_assign_status" checked="checked" value="term" required/> Term</span>&nbsp;
                                @else
                                    <span><input type="radio" name="teacher_assign_status" value="term" required/> Term</span>&nbsp;
                                @endif

                                @if($teacherAssign->status == 'year')
                                    <span><input type="radio" name="teacher_assign_status" checked="checked" value="year" required/> Year</span>
                                @else
                                    <span><input type="radio" name="teacher_assign_status"  value="year" required/> Year</span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="class_teacher" class="control-label col-lg-2">Is Class Teacher ?</label>
                            <div class="col-lg-2">
                                @if($teacherAssign->class_teacher > 0)
                                    <span><input type="checkbox" name="class_teacher" checked="checked" value="1"/> Class Teacher <small>(optional)</small></span>&nbsp;
                                @else
                                    <span><input type="checkbox" name="class_teacher" value="1"/> Class Teacher <small>(optional)</small></span>&nbsp;
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id" value="{{{$teacherAssign->teacher_assign_id}}}"/>
                            <input type="hidden" name="teacher_id" value="{{{$teacherAssign->teacher_id}}}"/>
                            <input type="submit" id="updateTeacherAssignBtn" class="btn btn-primary col-lg-offset-2 col-lg-1" value="Update"/>
                        </div>

                </div>
                    {{Form::close()}}

                </div>
            </section>
        </div>
    </div>
</section>

<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/settings.js"></script>

@stop
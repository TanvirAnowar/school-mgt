@extends('templates.bucket.bucket')


@section('wrapper')
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Assign Teacher
                    <span class="tools pull-right">
                        <!-- <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>-->

                      </span>
                </header>
                <div class="panel-body">
                    {{ Form::open(array('class'=>'cmxform form-horizontal', 'method'=>'post','url'=>url('school/save-teacher-assign'))) }}
                    <div class="form">
                    <input type="hidden" name="refurl" value="{{{url('school/teacher-assign')}}}"/>
                    <table class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Teacher name</th>
                                <th>Initial</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($teachers))
                            @foreach($teachers as $index=> $teacher)
                                <tr>
                                    <td>
                                        <div class="square-green single-row">
                                            <div class="radio ">
                                                <input type="radio" name="teacher_id" value="{{{$teacher->id}}}"/>
                                                <!--<label></label>-->
                                            </div>
                                        </div>

                                    </td>
                                    <td>{{{$teacher->name}}}</td>
                                    <td>{{{$teacher->name_initial}}}</td>
                                    <td>@if($teacher->assigned_status)
                                        <span class="label label-success label-mini">Assigned</span>
                                        @else
                                        <span class="label label-info label-mini">Not Assigned</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Select</th>
                                <th>Teacher name</th>
                                <th>Initial</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                    </table>
                        <br/>
                        <div class="form-group">
                            <label for="class_id" class="control-label col-lg-2">Class</label>
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
                        </div>
                        <div class="form-group">
                            <label for="subject_id" class="control-label col-lg-2">Subject</label>
                            <div class="col-lg-2">
                                <select class="form-control-select2" name="subject_id" style="width:150px;" required>
                                    <option value="">Select</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="section_id" class="control-label col-lg-2">Section</label>
                            <div class="col-lg-2">
                                <select class="form-control" name="section_id" required>
                                    <option value="">Select</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="teacher_assign_status" class="control-label col-lg-2">Teacher Assigned for a</label>
                            <div class="col-lg-2">
                                <span><input type="radio" name="teacher_assign_status" value="term" required/> Term</span>&nbsp;
                                <span><input type="radio" name="teacher_assign_status" value="year" required/> Year</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="class_teacher" class="control-label col-lg-2">Is Class Teacher ?</label>
                            <div class="col-lg-2">
                                <span><input type="checkbox" name="class_teacher" value="1"/> Class Teacher <small>(optional)</small></span>&nbsp;

                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary col-lg-offset-2 col-lg-1" value="Save"/>
                        </div>

                </div>
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
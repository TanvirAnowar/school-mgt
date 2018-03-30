@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading panel-title">
                    Attendance Sheet
                        <span class="tools pull-right">
                            <!--<a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            {{ Form::open(array('url'=>'activities/tasks/create','method'=>'get','class'=>'leftalign')) }}
                                <button class="btn btn-info panel-btn" id="sendAttendanceSms" type="button"><i class="fa fa-location-arrow"></i> Send SMS</button>
                            {{ Form::close() }}

                         </span>
                </header>
                <div class="panel-body">
                    <div class="form">
                        {{ Form::open(array('class'=>'cmxform form-horizontal','url'=>url('activities/save-task'),'method'=>'post','id'=>'addTaskFrm')) }}
                            <div class="form-group">
                                <label for="session" class="control-label col-lg-3">Session</label>
                                <div class="col-lg-3">
                                    <select class="form-control" name="session" required>
                                        @for($i=(date('Y')-2); $i<=(date('Y')+10); $i++)
                                        <option @if($i==date('Y')) selected="selected"  @endif value="{{{$i}}}">{{{$i}}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <label for="attendance_date" class="control-label col-lg-1">Date</label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" name="attendance_date" value="{{{date('Y-m-d')}}}" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="class_id" class="control-label col-lg-3">Class</label>
                                <div class="col-lg-3">
                                    <select class="form-control" name="class_id" required>
                                        <option value="">Select</option>
                                        @if(count($classes))
                                            @foreach($classes as $class)
                                            <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <label for="section_id" class="control-label col-lg-1">Section</label>
                                <div class="col-lg-3">
                                    <select class="form-control" name="section_id" required>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="term" class="control-label col-lg-3">Select Term</label>
                                <div class="col-lg-3">
                                    <select class="form-control" name="term" required>
                                        <option value="">Select</option>
                                        @if(count($terms))
                                            @foreach($terms as $term)
                                                <option value="{{$term}}">{{$term}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3 col-lg-offset-3">
                                    <input type="button" id="loadStudent" value="Load Student" class="btn btn-primary"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="client_id" value="{{{$clientid}}}"/>
                                <input type="hidden" name="access_token" value="{{{$access_token}}}"/>
                                <input type="hidden" name="refresh_token" value="{{{$refresh_token}}}"/>
                            </div>
                        <table class="attendance_grid display table table-bordered table-striped" id="dynamic-table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Student</th>
                                    <th>Class Info</th>
                                    <th>Roll</th>
                                    <th>Attendance</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        {{ Form::close() }}
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/attendance.js"></script>
@stop
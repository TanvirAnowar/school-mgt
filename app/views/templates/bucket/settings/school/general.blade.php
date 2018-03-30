@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    General Settings
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            {{ Form::open(array('id'=>'appModeFrm','url'=>'school/change-app-mode','method'=>'post')) }}
                               <input type="checkbox" name="app-mode"  @if($app_mode) checked="checked" @endif /> Debug Mode
                            {{ Form::close() }}
                         </span>

                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        {{Form::open(array('url'=>'school/update-general-settings','method'=>'post','id'=>'genralForm','class'=>'cmxform
                        form-horizontal'))}}
                        <input type="hidden" name="refurl" value="{{{url('school/general')}}}"/>

                        <div class="form-group">
                            <label for="attendance_default" class="control-label col-lg-3">Attendance </label>

                            <div class="col-lg-6">
                                <select name="attendance_default" class="form-control" style="width:150px;" required>
                                    <option value="">-- Select --</option>
                                    <?php

                                    $attendanceType = array('Automatic', 'Manual');
                                    ?>
                                    @foreach($attendanceType as $attendance)

                                    @if($attendance == $attendance_default)
                                    <option value="{{{$attendance}}}" selected="selected">{{{$attendance}}}</option>
                                    @else
                                    <option value="{{{$attendance}}}">{{{$attendance}}}</option>
                                    @endif
                                    @endforeach


                                </select>
                            </div>
                        </div>
                        <div  class="form-group">

                            <?php $bindData = (!empty($attendance_sheet_bind))? json_decode($attendance_sheet_bind) : ''; ?>
                            <div class="col-lg-7">
                                <h5 class="col-lg-offset-4">Bind Column if Attendance Settings <b>Automatic</b> Selected. <small><br/>Csv file has '0' base column index</small></h5>
                                <table class="display table table-bordered table-striped col-lg-offset-4" id="dynamic-table">
                                    <thead>
                                    <tr>
                                        <th>Column Name</th>
                                        <th>Column to be bind</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Unique ID/ User ID</td>
                                        <td><input type="text" name="uid" class="form-control" value="{{{$bindData->user_id}}}" /></td>
                                    </tr>
                                    <tr>
                                        <td>In Time</td>
                                        <td><input type="text" name="intime" class="form-control" value="{{{$bindData->in_time}}}" /></td>
                                    </tr>
                                    <tr>
                                        <td>Out Time</td>
                                        <td><input type="text" name="outtime" class="form-control" value="{{{$bindData->out_time}}}" /></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">

                            <label class="control-label col-lg-3">SMS Present</label>
                            <div class="col-lg-3">
                                <input type="checkbox" id="presentChk" name="present" @if($present) checked="checked" @endif />
                            </div>
                            <label class="control-label col-lg-3">SMS Absent</label>
                            <div class="col-lg-3">
                                <input type="checkbox" id="absentChk" name="absent" @if($absent) checked="checked" @endif />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>
                                <button class="btn btn-default" type="button">Cancel</button>
                            </div>
                        </div>

                        {{Form::close()}}
                    </div>
                </div>
            </section>
        </div>
    </div>
    <form action="{{{url('settings/update-general-settings')}}}" id="markTypeFrm" method="post"
          class="cmxform form-horizontal">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Additional Type & Mark Settings
                        <!-- <span class="tools pull-right">
                             <a class="fa fa-chevron-down" href="javascript:;"></a>
                             <a class="fa fa-cog" href="javascript:;"></a>
                             <a class="fa fa-times" href="javascript:;"></a>
                          </span>-->
                    </header>
                    <div class="panel-body">

                        <input type="hidden" name="refurl" value="{{{url('school/general')}}}"/>

                        <div class="form-group">
                            <label for="aptitudes" class="control-label col-lg-3">Aptitudes</label>

                            <div class="col-lg-3">
                                <textarea class="form-control col-lg-6" style="width:350px;resize:none;" id="aptitudes"
                                          name="aptitudes">{{{$aptitudes}}}</textarea>
                                <small>Use comma (,) between values</small>
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>

                            </div>
                        </div>


                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Terms Settings
                        <!-- <span class="tools pull-right">
                             <a class="fa fa-chevron-down" href="javascript:;"></a>
                             <a class="fa fa-cog" href="javascript:;"></a>
                             <a class="fa fa-times" href="javascript:;"></a>
                          </span>-->
                    </header>
                    <div class="panel-body">

                        <input type="hidden" name="refurl" value="{{{url('school/general')}}}"/>

                        <div class="form-group">
                            <label for="terms" class="control-label col-lg-3">Terms</label>

                            <div class="col-lg-3">
                                <textarea class="form-control col-lg-6" style="width:350px;resize:none;" id="terms"
                                          name="terms">{{{$terms}}}</textarea>
                                <small>Use comma (,) between values</small>
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>

                            </div>
                        </div>


                    </div>


                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        SMS Options
                        <!-- <span class="tools pull-right">
                             <a class="fa fa-chevron-down" href="javascript:;"></a>
                             <a class="fa fa-cog" href="javascript:;"></a>
                             <a class="fa fa-times" href="javascript:;"></a>
                          </span>-->
                    </header>
                    <div class="panel-body">

                        <input type="hidden" name="refurl" value="{{{url('school/general')}}}"/>
                        <div class="form-group">
                            <label for="terms" class="control-label col-lg-3">Daily Sms Limit</label>

                            <div class="col-lg-3">
                                <input type="nubmer" class="form-control" name="daily_sms_limit" value="{{$daily_sms_limit}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="terms" class="control-label col-lg-3">Sent SMS to multiple number:</label>

                            <div class="col-lg-3">

                                <input type="checkbox" @if($teacher_sms_option) checked="checked" @endif id="teacherSmsOption" name="teacher_sms_option"/> Teacher

                            </div>
                            <div class="col-lg-3">
                                <input type="checkbox" @if($student_sms_option) checked="checked" @endif id="studentSmsOption" name="student_sms_option"/> Student
                            </div>


                        </div>
                        <div class="form-group">
                            <label for="terms" class="control-label col-lg-3">Sent SMS to multiple number For:</label>
                            <div class="col-lg-3">
                                <input type="checkbox" @if($notice_sms_option) checked="checked" @endif id="noticeSmsOption" name="notice_sms_option"/> Notice
                            </div>
                            <div class="col-lg-3">
                                <input type="checkbox" @if($attendance_sms_option) checked="checked" @endif id="attendanceSmsOption" name="attendance_sms_option"/> Attendace
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>

                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>

    </form>
</section>
<script type="text/javascript" src="{{$theme}}js/custom/general.js"></script>
@stop
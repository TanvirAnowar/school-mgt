@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading panel-title">
                    Upload Attendance Sheet
                        <span class="tools pull-right">
                            <!--<a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->

                         </span>
                </header>
                <div class="panel-body">
                    {{Form::open(array('url'=>'activities/save-automatic-attendance','method'=>'post','enctype'=>'multipart/form-data','id'=>'uploadAttendanceForm','class'=>'cmxform form-horizontal'))}}
                    <input type="hidden" name="refurl" value="{{{url('activities/attendance')}}}"/>
                    <div class="form-group">
                        <label for="attendance_date" class="control-label col-lg-3">Date <small>(Required)</small></label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" name="attendance_date" value="{{{date('Y-m-d')}}}" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Select Csv File</label>
                        <div class="controls col-md-2">

                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Browse file</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="attendance_file"/>
                                        </span>
                                <span class="fileupload-preview" style="margin-left:5px;"></span>
                                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="term" class="control-label col-lg-3">Select terms</label>
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
                        <div class="col-lg-offset-3 col-lg-6">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </section>
        </div>
    </div>
</section>
@stop
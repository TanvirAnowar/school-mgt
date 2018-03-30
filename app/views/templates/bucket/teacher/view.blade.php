@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <!-- code here -->

    <div class="row">
        {{Form::open(array('url'=>'teacher/update-teacher','enctype'=>'multipart/form-data','method'=>'post','id'=>'teacherEditForm','class'=>'cmxform form-horizontal'))}}
        <?php $page = Request::get('page'); ?>
        <input type="hidden" name="refurl" value="{{{url('teacher/lists')}}}{{{ (!empty($page))? '?page='.$page : ''}}}"/>
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                     {{{$teacher->name}}}'s Details Information
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    <div class="form col-lg-10">


                        <div class="form-group">
                            <label for="name_initial" class="control-label col-lg-3">Name Initial</label>
                            <div class="col-lg-6">
                                <span class=" form-control" >{{{$teacher->name_initial}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label col-lg-3">Name</label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->name}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dob" class="control-label col-lg-3">Date of birth</label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->dob}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="father_name" class="control-label col-lg-3">Father's Name </label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->father_name}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mother_name" class="control-label col-lg-3">Mother's Name </label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->mother_name}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="age" class="control-label col-lg-3">Age </label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->age}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cell_phone" class="control-label col-lg-3">Cell Phone</label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->cell_phone}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cell_phone" class="control-label col-lg-3">Cell Phone 2</label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->cell_phone_2}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="marital_status" class="control-label col-lg-3">Marital Status </label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->marital_status}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender" class="control-label col-lg-3">Gender</label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->gender}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="religion" class="control-label col-lg-3">Religion </label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->religion}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="blood_group" class="control-label col-lg-3">Blood Group </label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->blood_group}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="present_address" class="control-label col-lg-3">Present Address <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->present_address}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="permanent_address" class="control-label col-lg-3">Permanent Address </label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->permanent_address}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label col-lg-3">E-mail </label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->email}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nationality" class="control-label col-lg-3">Nationality </label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->nationality}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="national_id" class="control-label col-lg-3">National ID </label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$teacher->national_id}}}</span>
                            </div>
                        </div>
                        <input type="hidden" name="teacher_id" value="{{{$teacher->id}}}"/>
                        <!--<div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>
                                <button class="btn btn-default" type="reset">Clear</button>
                            </div>
                        </div>-->

                    </div>

                    <div class="form col-lg-2">
                        <div class="form-group">
                            <div class="fileupload-new thumbnail">
                                @if(!empty($teacher->photo))
                                    <img alt="" src="{{{url().'/'.$teacher->photo}}}" />
                                @else
                                    <img alt="" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"/>
                                @endif

                            </div>
                            <div class="controls col-md-9">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Browse file</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="file" />
                                        </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        {{Form::close()}}
    </div>

</section>
<script src="{{$theme}}js/custom/common.js"></script>
@stop
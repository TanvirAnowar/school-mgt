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
                    Add New Section Information
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    <div class="form col-lg-10">


                        <div class="form-group">
                            <label for="name_initial" class="control-label col-lg-3">Name Initial <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="name_initial" name="name_initial" value="{{{$teacher->name_initial}}}" type="text"  required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label col-lg-3">Name <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="name" name="name" value="{{{$teacher->name}}}" type="text" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dob" class="control-label col-lg-3">Date of birth <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <input class="form-control teacher-dob" id="dob" name="dob" value="{{{$teacher->dob}}}" type="text" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="father_name" class="control-label col-lg-3">Father's Name </label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="father_name" name="father_name" value="{{{$teacher->father_name}}}" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mother_name" class="control-label col-lg-3">Mother's Name </label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="mother_name" name="mother_name" value="{{{$teacher->mother_name}}}" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="age" class="control-label col-lg-3">Age </label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="age" name="age" value="{{{$teacher->age}}}" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cell_phone" class="control-label col-lg-3">Cell Phone <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="cell_phone" name="cell_phone" value="{{{$teacher->cell_phone}}}" type="text" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cell_phone" class="control-label col-lg-3">Cell Phone 2</label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="cell_phone" name="cell_phone_2" value="{{{$teacher->cell_phone_2}}}" type="text"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="marital_status" class="control-label col-lg-3">Marital Status </label>
                            <div class="col-lg-6">
                                <select class=" form-control-select2" id="marital_status" name="marital_status" />
                                    @foreach($maritalStatus as $value)
                                        @if($value == $teacher->marital_status)
                                            <option selected="selected" value="{{{$value}}}">{{{$value}}}</option>
                                        @else
                                            <option value="{{{$value}}}">{{{$value}}}</option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender" class="control-label col-lg-3">Gender <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <select class=" form-control-select2" id="gender" name="gender" required/>
                                    @foreach($gender as $g)
                                        @if($g == $teacher->gender)
                                        <option selected="selected" value="{{{$g}}}">{{{$g}}}</option>
                                        @else
                                        <option value="{{{$g}}}">{{{$g}}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="religion" class="control-label col-lg-3">Religion </label>
                            <div class="col-lg-6">
                                <select class=" form-control-select2" id="religion" name="religion" />
                                    @foreach($religion as $r)
                                            @if($r == $teacher->religion)
                                            <option selected="selected" value="{{{$r}}}">{{{$r}}}</option>
                                            @else
                                            <option value="{{{$r}}}">{{{$r}}}</option>
                                            @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="blood_group" class="control-label col-lg-3">Blood Group </label>
                            <div class="col-lg-6">
                                <select class=" form-control-select2" id="blood_group" name="blood_group" />
                                    @foreach($bloodGroup as $bg)
                                        @if($bg == $teacher->blood_group)
                                        <option selected="selected" value="{{{$bg}}}">{{{$bg}}}</option>
                                        @else
                                        <option value="{{{$bg}}}">{{{$bg}}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="present_address" class="control-label col-lg-3">Present Address <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <textarea name="present_address" class="form-control" required>{{{$teacher->present_address}}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="permanent_address" class="control-label col-lg-3">Permanent Address </label>
                            <div class="col-lg-6">
                                <!--<input type="checkbox" id="sameAsPresent"/> Same As Present-->
                                <textarea name="permanent_address" class="form-control" >{{{$teacher->permanent_address}}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label col-lg-3">E-mail </label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="email" name="email" value="{{{$teacher->email}}}" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nationality" class="control-label col-lg-3">Nationality </label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="nationality" name="nationality" value="{{{$teacher->nationality}}}" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="national_id" class="control-label col-lg-3">National ID </label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="national_id" name="national_id" value="{{{$teacher->national_id}}}" type="text" />
                            </div>
                        </div>
                        <input type="hidden" name="teacher_id" value="{{{$teacher->id}}}"/>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>
                                <button class="btn btn-default" type="reset">Clear</button>
                            </div>
                        </div>

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
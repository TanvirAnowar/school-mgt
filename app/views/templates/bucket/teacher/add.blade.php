@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <!-- code here -->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add New Teacher Profile
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    <div class="form">
                        {{Form::open(array('url'=>'teacher/save-teacher','method'=>'post','id'=>'teacherAddForm','class'=>'cmxform form-horizontal'))}}
                        <input type="hidden" name="refurl" value="{{{url('teacher/lists')}}}"/>
                        <div class="form-group">
                            <label for="name_initial" class="control-label col-lg-3">Name Initial <small>(Required)</small></label>
                            <div class="col-md-1">
                                <input class=" form-control" id="name_initial" name="name_initial" maxlength="5" type="text" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label col-lg-3">Name <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="name" name="name" type="text" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dob" class="control-label col-lg-3">Date of birth <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <input class="form-control teacher-dob" id="dob" name="dob" type="text" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="father_name" class="control-label col-lg-3">Father's Name </label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="father_name" name="father_name" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mother_name" class="control-label col-lg-3">Mother's Name </label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="mother_name" name="mother_name" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="age" class="control-label col-lg-3">Age </label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="age" name="age" type="number" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cell_phone" class="control-label col-lg-3">Cell Phone <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="cell_phone" name="cell_phone" type="text" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cell_phone" class="control-label col-lg-3">Cell Phone 2</label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="cell_phone" name="cell_phone_2" type="text"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="marital_status" class="control-label col-lg-3">Marital Status </label>
                            <div class="col-lg-6">
                                <select class=" form-control-select2" id="marital_status" name="marital_status" />
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender" class="control-label col-lg-3">Gender <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <select class=" form-control-select2" id="gender" name="gender" required/>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="religion" class="control-label col-lg-3">Religion </label>
                            <div class="col-lg-6">
                                <select class=" form-control-select2" id="religion" name="religion" />
                                    <?php $religion = array('Muslim','Christian','Buddhist','Hindu','Other'); ?>
                                    @foreach($religion as $r)
                                        <option value="{{$r}}">{{$r}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="blood_group" class="control-label col-lg-3">Blood Group </label>
                            <div class="col-lg-6">
                                <select class=" form-control-select2" id="blood_group" name="blood_group" />
                                    <?php $religion = array('A+','A-','B+','B-','AB+','AB-','O+','O-'); ?>
                                    @foreach($religion as $r)
                                        <option value="{{$r}}">{{$r}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="present_address" class="control-label col-lg-3">Present Address <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <textarea name="present_address" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="permanent_address" class="control-label col-lg-3">Permanent Address </label>
                            <div class="col-lg-6">
                                <input type="checkbox" id="sameAsPresent"/> Same As Present
                                <textarea name="permanent_address" class="form-control" ></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label col-lg-3">E-mail </label>
                            <div class="col-lg-6">
                                <input class=" form-control required" required id="email" name="email" type="email" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nationality" class="control-label col-lg-3">Nationality </label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="nationality" name="nationality" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="national_id" class="control-label col-lg-3">National ID </label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="national_id" name="national_id" type="text" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>
                                <button class="btn btn-default" type="reset">Clear</button>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<script src="{{$theme}}js/custom/common.js"></script>
<script src="{{$theme}}js/custom/teacher.js"></script>
@stop
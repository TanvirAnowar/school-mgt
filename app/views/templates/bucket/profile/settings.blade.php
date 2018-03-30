@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading panel-title">
                    Change Credentials
                        <span class="tools pull-right">
                            <!--<a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->

                         </span>
                </header>
                <div class="panel-body">
                    {{Form::open(array('url'=>'profile/update-settings','id'=>'changeSettings','class'=>'cmxform form-horizontal'))}}
                        <!--<div class="form-group">
                            <label for="name_initial" class="control-label col-lg-3">User Name</label>
                            <div class="col-lg-3">
                                <input class=" form-control" id="name_initial" name="user_name" value="{{{$username}}}" type="text"  required/>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label for="name_initial" class="control-label col-lg-3">Old Password</label>
                            <div class="col-lg-3">
                                <input class=" form-control" id="name_initial" name="old_password" value="" type="password"  required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name_initial" class="control-label col-lg-3">Password</label>
                            <div class="col-lg-3">
                                <input class=" form-control" id="name_initial" name="new_password" value="" type="password"  required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name_initial" class="control-label col-lg-3">Confirm Password</label>
                            <div class="col-lg-3">
                                <input class=" form-control" id="name_initial" name="confirm_password" value="" type="password"  required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <input type="hidden" name="user_id" value="{{{$user_id}}}"/>
                                <input type="hidden" name="refurl" value="{{{url('profile')}}}"/>
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
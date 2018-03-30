@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Add New User
                           <span class="tools pull-right">
                            <!--     <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>-->
                             </span>
                </header>
                <div class="panel-body">
                    {{Form::open(array('url' => 'users/save-user', 'class' => 'cmxform form-horizontal', 'id' => 'saveUserFrm' ))}}
                        <input type="hidden" name="refurl" value="{{url('users/lists')}}"/>
                        <div class="form-group">
                            <label class="control-label col-lg-3">Username</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="username" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3">Password</label>
                            <div class="col-lg-3">
                                <input type="password" class="form-control" name="password" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3">User Type</label>
                            <div class="col-lg-3">
                                <select name="user_type" class="form-control">
                                    @foreach($user_type as $type)
                                        <option value="{{{$type}}}">{{{$type}}}</option>
                                    @endforeach
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
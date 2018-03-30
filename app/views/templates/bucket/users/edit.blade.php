@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    List of Users
                           <span class="tools pull-right">
                            <!--     <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>-->
                             </span>
                </header>
                <div class="panel-body">
                    {{Form::open(array('url'=>'users/update-user','class'=>'cmxform form-horizontal','method'=>'post'))}}
                    <input type="hidden" name="refurl" value="{{{url('users/lists/edit/'.$user_edit->id)}}}"/>
                    <div class="form-group">
                        <label for="username" class="control-label col-lg-3">Username <small>(Not editable)</small></label>
                        <div class="col-lg-3">
                            <input class=" form-control" readonly id="username" name="username" value="{{{$user_edit->username or ''}}}" type="text" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_type" class="control-label col-lg-3">User Type</label>
                        <div class="col-lg-3">
                            <select name="user_type" class="form-control">
                                @foreach($user_type as $type)
                                    @if(strtolower($user_edit->user_type) == strtolower($type))
                                        <option selected="selected" value="{{{$type}}}">{{{$type}}}</option>
                                    @else
                                        <option value="{{{$type}}}">{{{$type}}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label for="password" class="control-label col-lg-3">New Password </label>
                        <div class="col-lg-3">
                            <input class=" form-control" id="password" name="password" value="" type="password" />
                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="{{{$user_edit->id}}}"/>
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
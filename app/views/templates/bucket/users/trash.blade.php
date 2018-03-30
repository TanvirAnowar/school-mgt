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
                                {{ Form::close() }}
                               {{ Form::open(array('url'=>'users/lists','method'=>'get')) }}
                                <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-list"></i> List
                                </button>
                                {{ Form::close() }}
                             </span>
                </header>
                <div class="panel-body">
                <table class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Username</th>
                            <th>User Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($users))
                        @foreach($users as $index => $user)
                            <tr>
                                <td>{{($index+1)}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->user_type}}</td>
                                <td>
                                    <a href="{{{url('users/edit/'.$user->id)}}}"><i class="fa fa-pencil" title="Edit"></i></a>
                                    <a href="{{{$user->id}}}" class="grid-action-link restore-trash-user"><i class="fa fa-undo" title="Restore"></i></a>
                                    <a href="{{{$user->id}}}" class="grid-action-link delete-trash-user"><i class="fa fa-trash-o" title="Delete"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" language="javascript" src="{{$theme}}assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{$theme}}assets/data-tables/DT_bootstrap.js"></script>
<script src="{{$theme}}js/dynamic_table/dynamic_table_init.js"></script>
<script src="{{$theme}}js/custom/users.js"></script>
@stop
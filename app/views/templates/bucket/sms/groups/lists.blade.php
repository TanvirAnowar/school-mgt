@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <!-- code here -->
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add New Group
                    <span class="tools pull-right">
                       <!--   <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>-->
                        {{ Form::open(array('url'=>'sms/group-add','method'=>'get')) }}
                                <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-plus-circle"></i> Add Group</button>
                        {{ Form::close() }}
                      </span>
                </header>
                <div class="panel-body">
                    <table class="display table table-bordered table-striped" id="dynamic-table">

                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Group Name</th>
                            <th>Group Type</th>
                            <th>Members</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($groups))
                                @foreach($groups as $index => $group)
                                    <tr>
                                        <td>{{($index+1)}}</td>
                                        <td>{{$group->group_name}}</td>
                                        <td>{{$group->group_type}}</td>
                                        <td>{{count($group->getMessageGroupDetail)}}</td>
                                        <td>
                                            <a href="{{{url('sms/group-view/'.$group->group_id)}}}" class="grid-action-link"><i class="fa fa-eye"></i></a>
                                            <a href="{{{$group->group_id}}}" class="grid-action-link del-group"><i class="fa fa-trash-o" title="Delete"></i></a>
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
<script src="{{$theme}}js/custom/group.js"></script>
@stop
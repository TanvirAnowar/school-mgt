@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <!-- page start-->
    {{Helpers::showMessage()}}
    <div class="row">
    <div class="col-sm-12">
    <section class="panel">
    <header class="panel-heading">
        Shifts
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->

                         </span>

    </header>
    <div class="panel-body">
    <div class="adv-table">
        {{ Form::open(array('url'=>'school/save-shift','method'=>'post')) }}
        <input type="hidden" name="refurl" value="{{{url('school/shift-group')}}}"/>
        <label for="shift_name" class="control-label col-lg-3">Shift Name</label>
        <div class="col-md-6">
            <input type="text" name="shift_name" class="form-control" required/>
        </div>
        <button class="btn btn-primary" type="submit"><i class="fa fa-plus-circle"></i> Add New</button>
        {{ Form::close() }}
        <hr/>
    <table  class="display table table-bordered table-striped" id="dynamic-table">
    <thead>
    <tr>
        <th>Sl</th>
        <th>Shift Name</th>
        <th>Created Date</th>
        <th class="hidden-phone">Action</th>
    </tr>
    </thead>
    <tbody>
    @if(count($shifts))
        @foreach($shifts as $index => $shift)
        <tr class="gradeX">
            <td>{{($index+1)}}</td>
            <td>{{{$shift->shift_name}}}</td>
            <td>{{{$shift->created_at}}}</td>
            <td class="center hidden-phone">
                <a data-toggle="modal" href="#myModal" data-shift-id="{{{$shift->shift_id}}}" class="grid-action-link shift_settings_edit"><i class="fa fa-pencil"  title="Edit"></i></a>
                <!--<a data-toggle="modal" href="#myModal" class="grid-action-link shift_settings_del"><i class="fa fa-trash-o" title="Delete"></i></a>-->
            </td>
        </tr>
        @endforeach
    @else
        <tr class="gradeX">
            <td colspan="4">No Record Found</td>
        </tr>
    @endif

    </tbody>
    <tfoot>
    <tr>
        <th>Sl</th>
        <th>Shift Name</th>
        <th>Created Date</th>
        <th class="hidden-phone">Action</th>
    </tr>
    </tfoot>
    </table>
    </div>
    </div>
    </section>
    </div>
    </div>

    <!-- page end--> <!-- page start-->
    <div class="row">
    <div class="col-sm-12">
    <section class="panel">
    <header class="panel-heading">
        Groups
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->

                         </span>

    </header>
    <div class="panel-body">
    <div class="adv-table">
        {{ Form::open(array('url'=>'school/save-group','method'=>'post')) }}
        <input type="hidden" name="refurl" value="{{{url('school/shift-group')}}}"/>
        <label for="group_name" class="control-label col-lg-3">Group Name</label>
        <div class="col-md-6">
            <input type="text" name="group_name" class="form-control" required/>
        </div>

        <button class="btn btn-primary" type="submit"><i class="fa fa-plus-circle"></i> Add New</button>
        {{ Form::close() }}
        <hr/>
    <table  class="display table table-bordered table-striped" id="dynamic-table">
    <thead>
    <tr>
        <th>Sl</th>
        <th>Group Name</th>
        <th>Created Date</th>
        <th class="hidden-phone">Action</th>
    </tr>
    </thead>
    <tbody>

    @if(count($groups))
        @foreach($groups as $index => $group)
        <tr class="gradeX">
            <td>{{{($index+1)}}}</td>
            <td>{{{$group->group_name}}}</td>
            <td>{{{$group->created_at}}}</td>
            <td class="center hidden-phone">
                <a data-toggle="modal" href="#myModal-1" data-group-id="{{{$group->group_id}}}" class="grid-action-link group_settings_edit"><i class="fa fa-pencil" title="Edit"></i></a>
                <!--<a data-toggle="modal" href="#myModal-1" class="grid-action-link group_settings_del"><i class="fa fa-trash-o" title="Delete"></i></a>-->
            </td>
        </tr>
        @endforeach
    @else
        <tr class="gradeX">
            <td colspan="4">No Record Found</td>
        </tr>
    @endif
    </tbody>
    <tfoot>
    <tr>
        <th>Sl</th>
        <th>Group Name</th>
        <th>Created Date</th>
        <th class="hidden-phone">Action</th>
    </tr>
    </tfoot>
    </table>
    </div>
    </div>
    </section>
    </div>
    </div>

    <!-- edit shift modal form -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Edit Shift</h4>
            </div>
            <div class="modal-body">

                {{Form::open(array('url'=>'school/update-shift','id'=>'editShiftFrm','method'=>'post'))}}
                    <input type="hidden" name="refurl" value="{{{url('school/shift-group')}}}"/>
                    <div class="form-group">
                        <label for="shift_name">Shift Name</label>
                        <input type="text" class="form-control" id="shift_name" name="shift_name" value="">
                        <input type="hidden" name="shift_id" />
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                {{Form::close()}}
            </div>
        </div>
    </div>
    </div>

    <!-- edit group modal form -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Edit Group</h4>
                </div>
                <div class="modal-body">

                    {{Form::open(array('url'=>'school/update-group','id'=>'editGroupFrm','method'=>'post'))}}
                        <input type="hidden" name="refurl" value="{{{url('school/shift-group')}}}"/>
                        <div class="form-group">
                            <label for="group_name">Group Name</label>
                            <input type="text" class="form-control" id="group_name" name="group_name" value="">
                            <input type="hidden" name="group_id" />
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>


    <!-- page end-->
</section>
<script type="text/javascript" src="{{$theme}}js/custom/settings.js"></script>
@stop
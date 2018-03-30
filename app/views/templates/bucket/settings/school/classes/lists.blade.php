@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
<!-- page start-->
{{Helpers::showMessage()}}
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
    Classes
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            {{ Form::open(array('url'=>'school/classes/add','method'=>'get')) }}
                                <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-plus-circle"></i> Add New</button>
                            {{ Form::close() }}
                         </span>

</header>
<div class="panel-body">
<div class="adv-table">
<table  class="display table table-bordered table-striped" id="dynamic-table">
<thead>
<tr>
    <th>Sl</th>
    <th>Class Name</th>
    <th>Class Code</th>
    <th>Class Type</th>
    <th class="hidden-phone">Created Date</th>
    <th class="hidden-phone">Action</th>
</tr>
</thead>
<tbody>
@if($classes)
    @foreach($classes as $index => $class)
    <tr class="gradeX">
        <td>{{($index+1)}}</td>
        <td>{{$class->class_name}}</td>
        <td>{{$class->class_code}}</td>
        <td>{{$class->class_type}}</td>
        <td class="center hidden-phone">{{Helpers::dateTimeFormat('j F, Y',$class->created_at)}}</td>
        <td class="center hidden-phone">
            <a data-toggle="modal" href="#myModal" data-class-id="{{{$class->class_id}}}" class="grid-action-link class_settings_edit"><i class="fa fa-pencil" title="Edit"></i></a>
            <!--<a href="#" class="grid-action-link"><i class="fa fa-trash-o" title="Delete"></i></a>-->
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
    <th>Class Name</th>
    <th>Class Code</th>
    <th>Class Type</th>
    <th class="hidden-phone">Created Date</th>
    <th class="hidden-phone">Action</th>
</tr>
</tfoot>
</table>
</div>
</div>
</section>
</div>
</div>

    <!-- edit group modal form -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Edit Class</h4>
                </div>
                <div class="modal-body">

                    {{Form::open(array('url'=>'school/update-class','id'=>'editClassFrm','method'=>'post'))}}
                    <input type="hidden" name="refurl" value="{{{url('school/classes')}}}"/>
                    <div class="form-group">
                        <label for="class_name">Class Name</label>
                        <input type="text" class="form-control" id="class_name" name="class_name" value="">
                        <input type="hidden" name="class_id" />
                    </div>
                    <div class="form-group">
                        <label for="class_code">Class Code</label>
                        <input type="text" class="form-control" id="class_code" name="class_code" value="">
                    </div>
                    <div class="form-group ">
                        <label for="class_code" class="control-label col-lg-3">Class Type</label>
                        <div class="col-lg-6">
                            @foreach($class_types as $index => $type)
                                    <span>
                                        <input name="class_type" type="radio" value="{{{$index}}}" required /> {{{$type}}}
                                    </span>

                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-default">Submit</button>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>

<!-- page end-->
</section>
<script type="text/javascript" language="javascript" src="{{$theme}}assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{$theme}}assets/data-tables/DT_bootstrap.js"></script>
<script src="{{$theme}}js/dynamic_table/dynamic_table_init.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/settings.js"></script>
@stop
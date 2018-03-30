@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
<!-- page start-->
{{Helpers::showMessage()}}
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
    Subjects
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            {{ Form::open(array('url'=>'school/subject/add','method'=>'get')) }}
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
    <th>Subject Name</th>
    <th>Class</th>
    <th>Group</th>
    <th>Subject Initial</th>
    <th>Subject Status</th>
    <th>Display Order</th>
    <th>Subject Code</th>
    <th class="hidden-phone">Action</th>
</tr>
</thead>
<tbody>
@if(count($subjects))
    @foreach($subjects as $index => $subject)
        <tr class="gradeX">
            <td>{{{($index+1)}}}</td>
            <td>{{{$subject->subject_name}}}</td>
            <td>{{{$subject->getClass->class_name}}}</td>
            <td>{{{$subject->getGroup->group_name}}}</td>
            <td>{{{$subject->subject_initial}}}</td>
            <td>{{{$subject_status[$subject->subject_status]}}}</td>
            <td>{{{$subject->subject_order}}}</td>
            <td>{{{$subject->subject_code}}}</td>
            <td class="center hidden-phone">
                <a target="_blank" href="{{{url('school/subject/edit/'.$subject->subject_id)}}}" class="grid-action-link"><i class="fa fa-pencil" title="Edit"></i></a>
                <a href="{{{$subject->subject_id}}}" class="grid-action-link delete-subject"><i class="fa fa-trash-o" title="Delete"></i></a>
            </td>
        </tr>
    @endforeach
@else
<tr>
    <td colspan=""></td>
</tr>
@endif
</tbody>
<tfoot>
<tr>
    <th>Sl</th>
    <th>Subject Name</th>
    <th>Class</th>
    <th>Group</th>
    <th>Subject Initial</th>
    <th>Subject Status</th>
    <th>Subject Code</th>
    <th class="hidden-phone">Action</th>
</tr>
</tfoot>
</table>
</div>
</div>
</section>
</div>
</div>

<!-- page end-->
</section>
<script type="text/javascript" language="javascript" src="{{$theme}}assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{$theme}}assets/data-tables/DT_bootstrap.js"></script>
<script src="{{$theme}}js/dynamic_table/dynamic_table_init.js"></script>
<script src="{{$theme}}js/custom/schoolsettings.js"></script>

@stop
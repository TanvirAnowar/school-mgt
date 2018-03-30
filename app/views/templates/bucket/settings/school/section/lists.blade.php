@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
<!-- page start-->
{{Helpers::showMessage()}}
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
    Sections
    <span class="tools pull-right">
       <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
        <a href="javascript:;" class="fa fa-cog"></a>
        <a href="javascript:;" class="fa fa-times"></a>-->
        {{ Form::open(array('url'=>'school/section/add','method'=>'get')) }}
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
    <th>Section Name</th>
    <th>Class</th>
    <th>Shift</th>
    <th class="hidden-phone">Action</th>
</tr>
</thead>
<tbody>
@if(count($sections))
    @foreach($sections as $index => $section)
        <tr class="gradeX">
            <td>{{($index+1)}}</td>
            <td>{{{$section->section_name}}}</td>
            <td>{{{$section->getClass->class_name}}}</td>
            <td>{{{$section->getShift->shift_name}}}</td>
            <td class="center hidden-phone">
                <a href="{{{url('school/section/edit/'.$section->section_id)}}}" class="grid-action-link"><i class="fa fa-pencil" title="Edit"></i></a>
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
    <th>Section Name</th>
    <th>Class</th>
    <th>Shift</th>
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

@stop
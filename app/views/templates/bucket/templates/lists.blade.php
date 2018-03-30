@extends('templates.bucket.bucket')

@section('wrapper')

<section class="wrapper">
    <!-- code here -->
    {{Helpers::showMessage()}}
    <div class="row">


        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   Message Templates
                     <span class="tools pull-right">
                        <!-- <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>-->
                         {{ Form::open(array('url'=>'templates/lists/add','method'=>'get')) }}
                                <button class="btn btn-primary panel-btn" id="teplateAddBtn" type="submit"><i class="fa fa-plus-circle"></i> Add Template</button>
                        {{ Form::close() }}
                      </span>
                </header>
                <div class="panel-body">
                    <table class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>Template Name</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($templates))
                            @foreach($templates as $index => $template)
                                <tr>
                                        <td>{{{($index+1)}}}</td>
                                        <td>{{{$template->template_name}}}</td>
                                        <td>{{{$template->template_type}}}</td>
                                        <td>
                                            <a href="{{{url('templates/edit/'.$template->template_id)}}}" class="grid-action-link"><i class="fa fa-pencil" title="Edit"></i></a>
                                            <a href="{{{$template->template_id}}}" class="grid-action-link delete-template"><i class="fa fa-trash-o" title="Delete"></i></a>
                                        </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Sl.</th>
                            <th>Template Name</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" language="javascript" src="{{$theme}}assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{$theme}}assets/data-tables/DT_bootstrap.js"></script>
<script src="{{$theme}}js/dynamic_table/dynamic_table_init.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/template.js"></script>
@stop
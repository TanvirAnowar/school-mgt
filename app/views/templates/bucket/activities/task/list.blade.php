@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading panel-title">
                    Search Tasks
                        <span class="tools pull-right">
                            <!--<a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            {{ Form::open(array('url'=>'activities/tasks/create','method'=>'get')) }}
                                <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-plus-circle"></i> Create Task</button>
                            {{ Form::close() }}
                         </span>
                </header>
                <div class="panel-body">
                    <table class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Task</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($tasks))
                                @foreach($tasks as $index => $task)
                                    <tr>
                                        <td>{{($index+ 1)}}</td>
                                        <td>{{{$task->getClass->class_name}}}</td>
                                        <td>{{{$task->getSection->section_name}}}-{{{$task->getSection->getShift->shift_name}}}</td>
                                        <td>{{{$task->task}}}</td>
                                        <td>{{{Helpers::dateTimeFormat('F j , Y',$task->date)}}}</td>
                                        <td>
                                            <a target="_blank" href="{{{url('activities/tasks/edit/'.$task->task_id)}}}{{{ (!empty($page))? '?page='.(int)Request::get('page') : ''}}}" class="grid-action-link"><i class="fa fa-pencil" title="Edit"></i></a>
                                            <!--<a target="_blank" href="{{{url('activities/tasks/view/'.$task->task_id)}}}{{{ (!empty($page))? '?page='.(int)Request::get('page') : ''}}}" class="grid-action-link"><i class="fa fa-eye" title="View Details"></i></a>-->
                                            <a href="{{{$task->task_id}}}" class="grid-action-link delete-task"><i class="fa fa-trash-o" title="Delete"></i></a>
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
<script src="{{$theme}}js/custom/CustomMessage.js"></script>
<script src="{{$theme}}js/custom/task.js"></script>
@stop
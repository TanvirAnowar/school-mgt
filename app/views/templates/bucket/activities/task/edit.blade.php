@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading panel-title">
                    Edit Task
                        <span class="tools pull-right">
                            <!--<a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            {{ Form::open(array('url'=>'activities/tasks/create','method'=>'post')) }}
                                <button class="btn btn-danger panel-btn" type="submit"><i class="fa fa-minus-circle"></i> Delete Task</button>
                            {{ Form::close() }}
                         </span>
                </header>
                <div class="panel-body">
                    <div class="form">
                        {{ Form::open(array('class'=>'cmxform form-horizontal','url'=>url('activities/update-task'),'method'=>'post','id'=>'editTaskFrm')) }}
                        <input type="hidden" name="refurl" value="{{{url('activities/tasks')}}}"/>
                        <div class="form-group">
                            <label for="class_id" class="control-label col-lg-3">Class</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="class_id" required>
                                    <option value="">Select</option>
                                    @if(count($classes))
                                        @foreach($classes as $class)
                                            @if($task->class_id == $class->class_id)
                                                <option value="{{{$class->class_id}}}" selected="selected">{{{$class->class_name}}}</option>
                                            @else
                                                <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="section_id" class="control-label col-lg-3">Section</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="section_id" required>
                                    @if(count($task))
                                    <option value="{{{$task->getSection->section_id}}}">{{{$task->getSection->section_name}}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task" class="control-label col-lg-3">Task</label>
                            <div class="col-lg-6">
                                <textarea maxlength="480" class="form-control" name="task" style="resize:none;width:350px;height:140px;" required>{{{$task->task}}}</textarea>
                                <p>
                                    <label>Characters:</label>
                                    <span id="countMsg">0</span>
                                    <span style="color:tomato;" id="single_smsCount"></span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task" class="control-label col-lg-3">Date</label>
                            <div class="col-lg-2">
                                <input type="text" name="task_date" class="form-control" value="{{{Helpers::dateTimeFormat('m/d/Y',$task->date)}}}" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <input type="hidden" value="{{{$task->task_id}}}" name="task_id"/>
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </div>

                        {{ Form::close()}}
                    </div>


                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/task.js"></script>
@stop
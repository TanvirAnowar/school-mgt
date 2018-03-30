@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading panel-title">
                    Create Task
                        <span class="tools pull-right">
                            <!--<a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->

                         </span>
                </header>
                <div class="panel-body">
                    <div class="form">
                        {{ Form::open(array('class'=>'cmxform form-horizontal','url'=>url('activities/save-task'),'method'=>'post','id'=>'addTaskFrm')) }}
                        <input type="hidden" name="refurl" value="{{{url('activities/tasks')}}}"/>
                        <div class="form-group">
                            <label for="class_id" class="control-label col-lg-3">Class</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="class_id" required>
                                    <option value="">Select</option>
                                    @if(count($classes))
                                        @foreach($classes as $class)
                                            <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="section_id" class="control-label col-lg-3">Section</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="section_id" required>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task" class="control-label col-lg-3">Task</label>
                            <div class="col-lg-6">
                                <textarea maxlength="480" class="form-control" name="task" style="resize:none;width:350px;height:140px;" required></textarea>
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
                                <input type="text" name="task_date" class="form-control" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>
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
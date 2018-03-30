@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading panel-title">
                    Create Course Plan
                        <span class="tools pull-right">
                            <!--<a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                         </span>
                </header>
                <div class="panel-body">
                    {{ Form::open(array('class'=>'cmxform form-horizontal','url'=>url('activities/save-course-plan'),'method'=>'post','id'=>'coursePlanFrm')) }}
                        <input type="hidden" name="refurl" value="{{{url('activities/course-plan')}}}"/>
                        <div class="form-group">
                            <label for="class_id" class="control-label col-lg-1">Class</label>
                            <div class="col-lg-2">
                                <select class="form-control" name="class_id" required>
                                    <option value="">Select</option>
                                    @if(count($classes))
                                        @foreach($classes as $class)
                                            <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <label for="subject_id" class="control-label col-lg-1">Subjects</label>
                            <div class="col-lg-2">
                                <select class="form-control" name="subject_id" required>
                                    <option value="">Select</option>

                                </select>
                            </div>
                            <input type="button" id="loadTeacherBtn" class="btn btn-info" value="Load Teachers"/>
                        </div>

                        <div id="assignedTeacherLists" class="form-group col-lg-12 hidden">
                            <div class="text-center">
                                <img src="{{$theme}}images/ajax-loader.gif"/>
                            </div>
                        </div>
                        <div id="courseDetailsHolder" class="col-lg-12 hidden">

                            <div class="courseDetails">
                                <header class="panel-heading panel-title">
                                    Create Course Plan
                                <span class="tools pull-right">

                                    <a data-toggle="modal" href="#myModal" class="btn btn-warning panel-btn" id="addPlanBtn"><i class="fa fa-plus-circle"></i> Add Plan</a>

                                 </span>
                                </header>
                                <div class="course-plans">
                                    <div class="text-center">
                                        <img src="{{$theme}}images/ajax-loader.gif"/>
                                    </div>
                                </div>

                            </div>

                        </div>

                    <!---dialog-->
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                    <h4 class="modal-title">Create Plan</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="session">Session </label>
                                        <input type="text" class="form-control" id="session" name="session" value="{{{date("Y")}}}"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="term">Term </label>
                                        <select type="text" class="form-control" id="term" name="term">
                                            @if(count($terms))
                                                @foreach($terms as $term)
                                                    <option value="{{{$term}}}">{{{$term}}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select type="text" class="form-control" id="type" name="type">

                                            <option value="Lecture">Lecture</option>
                                            <option value="Class Test">Class Test</option>
                                            <option value="Assignment">Assignment</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Title </label>
                                        <input type="text" class="form-control" id="title" name="title" />
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="text" style="z-index:10000;" class="form-control form-control-inline input-medium default-date-picker" id="date" name="date" />
                                    </div>

                                    <button type="buton" id="saveCPlanBtn" class="btn btn-default">Save</button>
                                    <script src="{{$theme}}js/custom/common.js"></script>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </section>
        </div>
    </div>
</section>

<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/activities.js"></script>

@stop
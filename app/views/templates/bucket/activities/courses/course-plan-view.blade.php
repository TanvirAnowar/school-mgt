@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading panel-title">
                    Details Course Plan
                        <span class="tools pull-right">
                            <!--<a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            {{ Form::open(array('url'=>'activities/course-plan/create','method'=>'get')) }}
                                <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-plus-circle"></i> Create Course Plan</button>
                            {{ Form::close() }}
                         </span>
                </header>
                <div class="panel-body">

                    <h3>Responsible Teacher : {{{$teacher->name}}}</h3>
                    <h4>Class : {{{$subject->getClass->class_name}}}, Section: {{{$section->section_name}}}, Shift: {{{$section->getShift->shift_name}}}</h4>
                    <h4>Course Plan for : {{{$subject->subject_name}}}</h4>
                    @if(count($coursePlans))
                        @foreach($coursePlans as $plan)

                        <div class="alert alert-success fade in">

                            @if($plan->type == 'Class Test')
                            <span class="label label-danger label-mini"> <strong>{{{$plan->title}}}</strong> &nbsp; {{{$plan->type}}}, Date: {{{Helpers::dateTimeFormat('Y-m-d',$plan->date)}}}</span>
                            <span> Best Count <input class="bestCount" type="checkbox" <?php if(!empty($plan->details)){ echo 'checked="checked"'; }?> value="{{{$plan->course_plan_id}}}"/></span>
                            @else
                            <span class="label label-success label-mini">  <strong>{{{$plan->title}}}</strong> &nbsp; {{{$plan->type}}}, Date: {{{Helpers::dateTimeFormat('Y-m-d',$plan->date)}}}</span>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <div class="alert alert-warning fade in">
                            <span class="text-center">No record found</span>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" language="javascript" src="{{$theme}}assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{$theme}}assets/data-tables/DT_bootstrap.js"></script>
<script src="{{$theme}}js/dynamic_table/dynamic_table_init.js"></script>
<script src="{{$theme}}js/custom/activities.js"></script>
@stop
@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading panel-title">
                    Course Plans
                        <span class="tools pull-right">
                            <!--<a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            {{ Form::open(array('url'=>'activities/course-plan/create','method'=>'get')) }}
                                <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-plus-circle"></i> Create Course Plan</button>
                            {{ Form::close() }}
                         </span>
                </header>
                <div class="panel-body">
                    <table class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th>Teacher ID</th>
                                <th>Responsible Teacher</th>
                                <th>Subject</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($courseplans))
                                @foreach($courseplans as $index => $courseplan)       <?php // $index == primary key for teacher entity ?>
                                    <tr>
                                        <td>{{{($index)}}}</td>
                                        <td>{{{($courseplan['teacher_name'])}}}</td>
                                        <td>

                                            @if(count($courseplan['subjects']))
                                                @foreach($courseplan['subjects'] as $subject)
                                                    <span class="label label-success"><a href="{{{url('activities/course-plan/view/'.$subject['subject_id'].'/'.$index)}}}">{{{$subject['subject_name']}}}</a></span>
                                                @endforeach
                                            @endif
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
@stop
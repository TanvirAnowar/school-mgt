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
                            {{ Form::open(array('url'=>'student/admit-form','method'=>'get')) }}
                                <button class="btn btn-primary" type="submit"><i class="fa fa-plus-circle"></i> Add New</button>
                            {{ Form::close() }}
                         </span>

                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <table  class="display table table-bordered table-striped" id="dynamic-table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Student Name</th>
                                <th>Exam Roll</th>
                                <th>Father Name</th>
                                <th>Contact no</th>
                                <th>Date of Birth</th>
                                <th>Application Date</th>
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
                                <td>{{{$subject->subject_code}}}</td>
                                <td class="center hidden-phone">
                                    <a href="{{{url('school/subject/edit/'.$subject->subject_id)}}}" class="grid-action-link"><i class="fa fa-pencil" title="Edit"></i></a>
                                    <!--<a href="#" class="grid-action-link"><i class="fa fa-trash-o" title="Delete"></i></a>-->
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
                                <th>Student Name</th>
                                <th>Exam Roll</th>
                                <th>Father Name</th>
                                <th>Contact no</th>
                                <th>Date of Birth</th>
                                <th>Application Date</th>
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
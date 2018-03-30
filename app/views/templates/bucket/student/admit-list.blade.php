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
                                <th>Session</th>
                                <th>Student Name</th>
                                <th>Exam Roll</th>
                                <th>Father Name</th>
                                <th>Contact no</th>
                                <th>Date of Birth</th>
                                <th>Status</th>
                                <th>Application Date</th>
                                <th class="hidden-phone">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($admitLists))
                            @foreach($admitLists as $index => $admit)
                            <tr class="gradeX">
                                <td>{{{($index+1)}}}</td>
                                <td>{{{$admit->session}}}</td>
                                <td>{{{$admit->name}}}</td>
                                <td>{{{$admit->exam_roll}}}</td>
                                <td>{{{$admit->father_name}}}</td>
                                <td>{{{$admit->mobile_number or $admit->phone}}}</td>
                                <td>{{{Helpers::dateTimeFormat("j F, Y",$admit->dob)}}}</td>
                                <td>
                                    @if($admit->status == 'Passed')
                                    <span class="label label-success label-mini">{{{$admit->status}}}</span>
                                    @elseif($admit->status == 'Terminate')
                                    <span class="label label-danger label-mini">{{{$admit->status}}}</span>
                                    @endif
                                </td>
                                <td>{{{Helpers::dateTimeFormat("j F, Y",$admit->created_at)}}}</td>
                                <td class="center hidden-phone">
                                    <a href="{{{url('student/admit-details/'.$admit->admit_form_id)}}}" class="grid-action-link"><i class="fa fa-pencil" title="Edit"></i></a>
                                    <a href="{{{url('student/add/'.$admit->exam_roll)}}}" class="grid-action-link"><i class="fa fa-user" title="Admit"></i></a>
                                    <!--<a href="#" class="grid-action-link"><i class="fa fa-trash-o" title="Delete"></i></a>-->
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>Session</th>
                                <th>Student Name</th>
                                <th>Exam Roll</th>
                                <th>Father Name</th>
                                <th>Contact no</th>
                                <th>Date of Birth</th>
                                <th>Status</th>
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
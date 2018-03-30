@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Grade Settings
                    <span class="tools pull-right">
                        <!--  <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>-->
                         {{ Form::open(array('url'=>'settings/grades/add','method'=>'get')) }}
                                <button class="btn btn-primary" type="submit"><i class="fa fa-plus-circle"></i> Add Grade</button>
                         {{ Form::close() }}
                      </span>
                </header>
                <div class="panel-body">
                    <div class="form col-lg-12">

                        <table  class="display table table-bordered table-striped" id="dynamic-table">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Class Name</th>
                                <th>Grade</th>
                                <th>Point</th>
                                <th class="hidden-phone">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($grades))
                                @foreach($grades as $index => $grade)
                                    <tr class="gradeX">
                                        <td>{{{($index + 1)}}}</td>
                                        <td>{{{$grade->getClass->class_name}}}</td>
                                        <td>{{{$grade->grade}}}</td>
                                        <td>{{{$grade->point}}}</td>
                                        <td class="center hidden-phone">
                                            &nbsp;
                                            <a  href="{{{url('settings/grades/edit/'.$grade->grade_id)}}}" class="grid-action-link edit-mark-type"><i class="fa fa-pencil" title="Edit"></i></a>
                                            <a  href="{{{$grade->grade_id}}}" class="grid-action-link undo-delete-grade-settings"><i class="fa fa-undo" title="Edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>Class Name</th>
                                <th>Grade</th>
                                <th>Point</th>
                                <th class="hidden-phone">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" language="javascript" src="{{$theme}}assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{$theme}}assets/data-tables/DT_bootstrap.js"></script>
<script src="{{$theme}}js/dynamic_table/dynamic_table_init.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/settings.js"></script>
@stop
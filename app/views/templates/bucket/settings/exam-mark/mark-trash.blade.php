@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Mark Settings Trash
                    <span class="tools pull-right col-lg-3">
                        <!--  <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>-->
                        {{ Form::open(array('url'=>'settings/mark','class'=>'col-lg-4', 'method'=>'get')) }}
                        <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-list"></i> List</button>
                        {{ Form::close() }}
                        {{ Form::open(array('url'=>'settings/clear-trash-mark-settings','id'=>'clearTrashFrm','class'=>'col-lg-2','method'=>'post')) }}
                        <button class="btn btn-danger panel-btn" type="submit"><i class="fa fa-trash-o"></i> Clear Trash</button>
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
                                <th>Subject Name</th>
                                <th>Mark Type</th>
                                <th>Pass</th>
                                <!--<th>Convert At</th>-->
                                <th class="hidden-phone">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($mark_settings))
                                @foreach($mark_settings as $index => $setting)
                                    <tr class="gradeX">
                                        <td>{{{($index + 1)}}}</td>
                                        <td>{{{$setting->getClass->class_name or ''}}}</td>
                                        <td>{{{$setting->getSubject->subject_name or ''}}}</td>
                                        <td>{{{$setting->getMarkType->mark_type or ''}}}</td>
                                        <td>{{{$setting->pass or ''}}}</td>
                                        <!--<td>{{{$setting->convert_at or ''}}}</td>-->
                                        <td class="center hidden-phone">
                                            &nbsp;
                                            <a  href="{{{url('settings/mark/edit/'.$setting->mark_settings_id)}}}" class="grid-action-link edit-mark-type"><i class="fa fa-pencil" title="Edit"></i></a>
                                            <a  href="{{{$setting->mark_settings_id}}}" class="grid-action-link undo-delete-mark-settings"><i class="fa fa-undo" title="Edit"></i></a>
                                            <a  href="{{{$setting->mark_settings_id}}}" class="grid-action-link delete-trash-mark-settings"><i class="fa fa-trash-o" title="Edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th>Class Name</th>
                                <th>Subject Name</th>
                                <th>Mark Type</th>
                                <th>Pass</th>
                                <!--<th>Convert At</th>-->
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
<script type="text/javascript" src="{{$theme}}js/custom/marksettings.js"></script>
@stop
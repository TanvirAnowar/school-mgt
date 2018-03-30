@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Combine Subject Mark Settings
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    {{Form::open(array('url'=>'settings/save-combine-mark','method'=>'post','id'=>'combineMarkSettingsForm','class'=>'cmxform form-horizontal'))}}
                        <input type="hidden" name="refurl" value="{{{url('settings/combine-mark')}}}"/>
                        <div class="form-group">
                            <label for="title" class="control-label col-lg-3">Title <small>(Required)</small></label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" id="title" name="title" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="class_id" class="control-label col-lg-3">Class <small>(Required)</small></label>
                            <div class="col-lg-2">
                                <select class="form-control" id="class_id" name="class_id" required>
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
                            <label for="class_id" class="control-label col-lg-3">Subjects</label>
                            <div class="col-lg-2">
                                <select multiple="multiple" class="form-control" id="subject_id" name="subject_id[]" required>

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mark_type_id" class="control-label col-lg-3">Mark Type <small>(Required)</small></label>
                            <div class="col-lg-5">
                                <select class="form-control-select2" id="mark_type_id" name="mark_type_id" style="width:150px;" required>
                                    <option value="">Select</option>
                                    @if(count($mark_types))
                                    @foreach($mark_types as $mark_type)
                                    <option value="{{{$mark_type->mark_type_id}}}">{{{$mark_type->mark_type}}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pass" class="control-label col-lg-3">Pass</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control col-lg-2" id="pass" name="pass"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="convert_at" class="control-label col-lg-3">Convert at</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control col-lg-2" id="convert_at" name="convert_at"/>
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>

                            </div>
                        </div>

                    <div class="form-group col-lg-12">
                        <table class="display table table-bordered table-striped " id="dynamic-table">
                            <thead>
                                <tr>
                                    <th>Sl.</th>
                                    <th>Title</th>
                                    <th>Class</th>
                                    <th>Combine Subjects</th>
                                    <th>Mark type</th>
                                    <th>Pass</th>
                                    <th>Convert at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($combineMarkSettings))
                                    @foreach($combineMarkSettings as $index=> $cm)
                                <tr>
                                    <td>{{{($index+1)}}}</td>
                                    <td>{{{$cm->title}}}</td>
                                    <td>{{{$cm->getClass->class_name or ''}}}</td>
                                    <td>{{{CombineMarkSettings::getSubjectNames($cm->subjects) or ''}}}</td>
                                    <td>{{{$cm->getMarkType->mark_type}}}</td>
                                    <td>{{{$cm->pass or ''}}}</td>
                                    <td>{{{$cm->convert_at or ''}}}</td>
                                    <td class="center hidden-phone">
                                        <a  href="{{{url('settings/combine-mark/edit/'.$cm->combine_mark_settings_id)}}}" class="grid-action-link edit-mark-type"><i class="fa fa-pencil" title="Edit"></i></a>
                                        <a  href="{{{$cm->combine_mark_settings_id}}}" class="grid-action-link delete-combine-mark-settings"><i class="fa fa-trash-o" title="Delete"></i></a>
                                    </td>
                                </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Sl.</th>
                                <th>Title</th>
                                <th>Class</th>
                                <th>Combine Subjects</th>
                                <th>Mark type</th>
                                <th>Pass</th>
                                <th>Convert at</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    {{Form::close()}}
                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" language="javascript" src="{{$theme}}assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{$theme}}assets/data-tables/DT_bootstrap.js"></script>
<script src="{{$theme}}js/dynamic_table/dynamic_table_init.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/combine_mark.js"></script>
@stop
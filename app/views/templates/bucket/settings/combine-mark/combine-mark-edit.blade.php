@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Edit Combine Subject Mark Settings
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    {{Form::open(array('url'=>'settings/update-combine-mark','method'=>'post','id'=>'combineMarkSettingsForm','class'=>'cmxform form-horizontal'))}}
                        <input type="hidden" name="refurl" value="{{{url('settings/combine-mark')}}}"/>
                        <div class="form-group">
                            <label for="title" class="control-label col-lg-3">Title <small>(Required)</small></label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" id="title" name="title" value="{{{$combineMarkSettings->title or ''}}}" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="class_id" class="control-label col-lg-3">Class <small>(Required)</small></label>
                            <div class="col-lg-2">
                                <select class="form-control" id="class_id" name="class_id" required>
                                    <option value="">Select</option>
                                    @if(count($classes))
                                        @foreach($classes as $class)
                                            @if($combineMarkSettings->class_id == $class->class_id)
                                                <option selected="selected" value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                            @else
                                                <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                            @endif
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
                                            @if($combineMarkSettings->mark_type_id == $mark_type->mark_type_id)
                                                <option selected="selected" value="{{{$mark_type->mark_type_id}}}">{{{$mark_type->mark_type}}}</option>
                                            @else
                                                <option value="{{{$mark_type->mark_type_id}}}">{{{$mark_type->mark_type}}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pass" class="control-label col-lg-3">Pass</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control col-lg-2" id="pass" value="{{{$combineMarkSettings->pass}}}" name="pass"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="convert_at" class="control-label col-lg-3">Convert at</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control col-lg-2" id="convert_at" value="{{{$combineMarkSettings->convert_at}}}" name="convert_at"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="combine_mark_settings_id" value="{{{$combineMarkSettings->combine_mark_settings_id}}}"/>
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>

                            </div>
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
@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Mark Settings
                    <span class="tools pull-right">
                        <!--  <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>-->

                    {{ Form::open(array('url'=>'settings/mark/trash','method'=>'get')) }}
                    <button class="btn btn-danger panel-btn" type="submit"><i class="fa fa-trash-o"></i> Trash</button>
                    {{ Form::close() }}
                     </span>
                </header>
                <div class="panel-body">
                    <form action="{{{url('settings/save-mark-settings')}}}" id="markFrm" method="post" class="cmxform form-horizontal">
                        <input type="hidden" name="refurl" value="{{{url('settings/mark')}}}"/>
                        <div class="form-group">
                            <label for="class_id" class="control-label col-lg-3">Class <small>(Required)</small></label>
                            <div class="col-lg-3">
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
                            <label for="subject_id" class="control-label col-lg-3">Subjects</label>
                            <div class="col-lg-5">
                                <select class="form-control" id="subject_id" name="subject_id" style="width:150px;" required>

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mark_type_id" class="control-label col-lg-3">Mark Type <small>(Required)</small></label>
                            <div class="col-lg-5">
                                <select class="form-control-select2" id="mark_type_id" name="mark_type_id" style="width:150px;" required>
                                    @if(count($mark_types))
                                        @foreach($mark_types as $mark_type)
                                            <option value="{{{$mark_type->mark_type_id}}}">{{{$mark_type->mark_type}}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <hr/>
                        @if(count($terms))
                            <div class="passMark hidden">
                            @foreach($terms as $term)

                                <div class="form-group">
                                    <label for="pass" class="control-label col-lg-3">{{$term}} Pass Mark</label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control col-lg-2" id="pass" name="pass[{{$term}}]"/>
                                    </div>
                                </div>

                            @endforeach
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="term" class="control-label col-lg-3">Term</label>
                            <div class="col-lg-2">
                                <select name="term" class="form-control">
                                    @foreach($terms as $term)
                                        <option value="{{$term}}">{{$term}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                       <!-- <div class="form-group">
                            <label for="convert_at" class="control-label col-lg-3">Convert at</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control col-lg-2" id="convert_at" name="convert_at"/>
                            </div>
                        </div>-->

                        <div class="form-group">

                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>

                            </div>
                        </div>
                    </form>
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
                                            <a  href="{{{$setting->mark_settings_id}}}" class="grid-action-link delete-mark-settings"><i class="fa fa-trash-o" title="Edit"></i></a>
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
                               <!-- <th>Convert At</th>-->
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
<script type="text/javascript">
    $("#subject_id").change(function(){
    
        var obj = $(this);
        for(s in subjects)
        {
            console.log('hi')
            var subject = subjects[s];
            if(subject.show_pass_mark)
            {
                $("div.passMark").addClass("hidden");
            }else{
                $("div.passMark").removeClass("hidden");
            }
        }    
    });
</script>
@stop
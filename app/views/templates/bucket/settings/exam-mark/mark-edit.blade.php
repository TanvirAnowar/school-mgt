@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Edit Mark Settings
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">

                    <form action="{{{url('settings/update-mark-settings')}}}" id="markFrm" method="post" class="cmxform form-horizontal">
                        <input type="hidden" name="refurl" value="{{{url('settings/mark')}}}"/>
                        <div class="form-group">
                            <label for="class_id" class="control-label col-lg-3">Class <small>(Required)</small></label>
                            <div class="col-lg-5">
                                <select class="form-control" id="class_id" name="class_id" required>
                                    <option value="">Select</option>
                                    @if(count($classes))
                                        @foreach($classes as $class)
                                            @if($class->class_id == $mark_setting->class_id)
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
                            <label for="subject_id" class="control-label col-lg-3">Subjects</label>
                            <div class="col-lg-5">
                                <select class="form-control-select2" id="subject_id" name="subject_id" style="width:150px;" required>
                                    <option value="{{{$mark_setting->subject_id}}}">{{{$mark_setting->getSubject->subject_name}}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mark_type_id" class="control-label col-lg-3">Mark Type <small>(Required)</small></label>
                            <div class="col-lg-5">
                                <select class="form-control-select2" id="mark_type_id" name="mark_type_id" style="width:150px;" required>
                                    @if(count($mark_types))
                                        @foreach($mark_types as $mark_type)
                                            @if($mark_type->mark_type_id == $mark_setting->mark_type_id)
                                            <option selected="selected" value="{{{$mark_type->mark_type_id}}}">{{{$mark_type->mark_type}}}</option>
                                            @else
                                            <option value="{{{$mark_type->mark_type_id}}}">{{{$mark_type->mark_type}}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <hr/>
                        <?php $items = json_decode($mark_setting->pass); ?>
                        @if(count($terms))
                            <div class="passMark hidden">
                            @foreach($terms as $term)
                            <div class="form-group">
                                <label for="pass" class="control-label col-lg-3">{{$term}} Pass mark</label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control col-lg-2" id="pass" name="pass[{{$term}}]" value="{{{$items->$term or ''}}}"/>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        @endif
                        <!--<div class="form-group">
                            <label for="convert_at" class="control-label col-lg-3">Convert at</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control col-lg-2" id="convert_at" name="convert_at" value="{{{$mark_setting->convert_at}}}"/>
                            </div>
                        </div>-->

                        <div class="form-group">
                            <input type="hidden" name="mark_settings_id" value="{{{$mark_setting->mark_settings_id}}}"/>
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Update</button>

                            </div>
                        </div>
                    </form>

                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/marksettings.js"></script>
<script type="text/javascript">
    $("#subject_id").change(function(){
    
        var obj = $(this);
        for(s in subjects)
        {
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
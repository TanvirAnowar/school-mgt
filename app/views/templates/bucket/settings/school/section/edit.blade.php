@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add New Section Information
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    <div class="form">
                        <!--<form class="cmxform form-horizontal " id="signupForm" method="get" action="#">-->
                        {{Form::open(array('url'=>'school/update-section','method'=>'post','class'=>'cmxform form-horizontal','id'=>'sectionForm'))}}
                        <input type="hidden" name="refurl" value="{{{url('school/section')}}}"/>
                        <div class="form-group ">
                            <label for="section_name" class="control-label col-lg-3">Section Name</label>
                            <div class="col-lg-6">
                                <input class="form-control" id="section_name" name="section_name" value="{{{$section->section_name}}}" type="text" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="class_id" class="control-label col-lg-3">Class</label>
                            <div class="col-lg-6">
                                <select class="form-control-select2" name="class_id" required>
                                    <option value="">-- Select --</option>
                                    @if(count($classes))
                                    @foreach($classes as $class)
                                        @if($class->class_id == $section->class_id)
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
                            <label for="shift_id" class="control-label col-lg-3">Shift</label>
                            <div class="col-lg-6">
                                <select class="form-control-select2" name="shift_id">
                                    <option value="">-- Select --</option>
                                    @if(count($shifts))
                                    @foreach($shifts as $shift)
                                        @if($shift->shift_id == $section->shift_id)
                                            <option selected="selected" value="{{{$shift->shift_id}}}">{{{$shift->shift_name}}}</option>
                                        @else
                                            <option value="{{{$shift->shift_id}}}">{{{$shift->shift_name}}}</option>
                                        @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="section_id" value="{{{$section->section_id}}}"/>

                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>
                                <button class="btn btn-default" type="reset">Cancel</button>
                            </div>
                        </div>
                        {{Form::close()}}
                        <!--</form>-->
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
@stop
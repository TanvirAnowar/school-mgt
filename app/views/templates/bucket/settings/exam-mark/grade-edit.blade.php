@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    New Grade
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    <form action="{{{url('settings/update-grade-settings')}}}" id="gradeFrm" method="post" class="cmxform form-horizontal">
                        <input type="hidden" name="refurl" value="{{{url('settings/grades')}}}"/>
                        <div class="form-group">
                            <label for="class_id" class="control-label col-lg-3">Class <small>(Required)</small></label>
                            <div class="col-lg-5">
                                <select class="form-control" id="class_id" name="class_id" required>
                                    <option value="">Select</option>
                                    @if(count($classes))
                                        @foreach($classes as $class)
                                            @if($class->class_id == $grade->class_id)
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
                            <label for="mark" class="control-label col-lg-3">Mark</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control col-lg-2" id="mark" name="mark" value="{{{$grade->mark}}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="grade" class="control-label col-lg-3">Grade <small>(Required)</small></label>
                            <div class="col-lg-5">
                                <select class="form-control-select2" id="grade" name="grade" style="width:150px;" required>
                                    @if(count($grades))
                                        @foreach($grades as $g)
                                            @if($g == $grade->grade)
                                                <option selected="selected" value="{{{$g}}}">{{{$g}}}</option>
                                            @else
                                                <option value="{{{$g}}}">{{{$g}}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="point" class="control-label col-lg-3">Point</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control col-lg-2" id="point" name="point" value="{{{$grade->point}}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <input type="hidden" name="grade_id" value="{{{$grade->grade_id}}}"/>
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </div>
                    </form>

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
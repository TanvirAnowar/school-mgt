@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <!-- code here -->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Class Routine
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    {{Form::Open(array('id'=>'classRoutineFrm','class'=>'cmxform form-horizontal','url'=>'routine/get-routine'))}}
                        <div class="col-lg-12">

                                <div class="form-group">
                                    <label class="control-label col-lg-3">Class</label>
                                    <div class="col-lg-3">
                                        <select class="form-control" name="class_id">
                                            <option value="">-- Select --</option>
                                            @if(count($classes))
                                            @foreach($classes as $class)
                                                <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-3">Section</label>
                                    <div class="col-lg-3">
                                        <select class="form-control" name="section_id">
                                            <option value="">-- Select --</option>
                                        </select>
                                    </div>
                                </div>

                        </div>
                        <!--<div class="calendar-bar col-lg-12">
                            <div class="col-lg-4 pull-left">
                                <input type="hidden" name="callback" value="{{Request::url()}}"/>
                                <input type="hidden" name="day" value="{{$prev}}"/>
                                <input type="hidden" name="current" value="{{$current}}"/>
                                <input class="btn btn-info" type="submit" name="dayBtn" value="Prev" />
                            </div>
                            <div class="col-lg-4 text-center"><?php
/*                            echo $day = date('d D, M, Y',$current);

                            */?>
                                <input type="hidden" value="{{$current}}" name="current"/>
                            </div>

                                <input type="hidden" name="callback" value="{{Request::url()}}"/>
                                <input type="hidden" name="current" value="{{$current}}"/>
                                <input type="hidden" name="day" value="{{$next}}"/>
                                <input class="btn btn-info pull-right" type="submit" name="dayBtn" value="Next" />

                        </div>-->
                        <div style="clear:both;margin-bottom:10px;"></div>
                        <div class="periods">

                        </div>
                    {{Form::Close()}}
                </div>
            </section>
        </div>
    </div>
</section>
<style type="text/css">
    .deleteRoutine{
     color:#fff;
     font-weight: bold;
     float: right;
     padding:2px;
    }
    .periods .col-lg-12{
        border-bottom:1px solid #777;
    }
    .periods .col-lg-12:first-child{
        border-top:1px solid #777;
    }

    #dialogBox .col-lg-12{
        border:none;
    }
</style>
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/routine.js"></script>
@stop

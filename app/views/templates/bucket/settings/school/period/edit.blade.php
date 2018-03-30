@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Period Settings
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    <div class="form">
                        {{ Form::open(array('class'=>'cmxform form-horizontal','method'=>'post','url'=>url('school/update-period'))) }}
                        <!--<form class="cmxform form-horizontal" id="signupForm" method="get" action="#">-->
                        <input type="hidden" name="refurl" value="{{{url('school/period')}}}"/>
                        <div class="form-group">
                            <label for="period_name" class="control-label col-lg-3">Period Name</label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="period_name" name="period_name" type="text" value="{{{$class_period->getPeriod->period_name}}}" required/>
                            </div>
                        </div>

                        <hr/>
                        <div class="form-group">
                            <label for="class_id" class="control-label col-lg-3">Class </label>
                            <div class="col-md-2">
                                <select class="form-control" name="class_id">
                                    <option value="">-- Select --</option>
                                    @if(count($classes))
                                        @foreach($classes as $class)
                                            @if($class->class_id == $class_period->class_id)
                                                <option selected="selected" value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                            @else
                                                <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                            @endif
                                        @endforeach
                                    @endif

                                </select>
                            </div>

                            <label for="section_id" class="control-label col-lg-1">Section </label>
                            <div class="col-md-2">
                                <select class="form-control" name="section_id">
                                    <option value="{{{$class_period->section_id}}}">{{{$class_period->getSection->section_name}}}</option>

                                </select>
                            </div>

                        </div>
                        <div class="col-lg-offset-3 popo">
                            <div id="load-view" class="col-lg-12">
                                <div id="gridHolder">
                                    <?php
                                    $period = $class_period->getPeriod;
                                    $period_details = json_decode($period->period_details);
                                    $periodCount = $period_details->periodCount;
                                    $start = $period_details->start;
                                    $end = $period_details->end;
                                    ?>
                                    @if(count($period_details))
                                    @for($i=1; $i<=$periodCount; $i++)
                                    <div class="periodGrid">
                                        <h4 class="text-center"> {{{$i}}} no period</h4>
                                        <div class="cell">
                                            <label class="col-xs-1">Start</label><input type="text" class="timepicker-default" name="start[]" value="{{{$start[$i-1]}}}"/>
                                            <label class="col-xs-1">End&nbsp;</label><input type="text" class="timepicker-default" name="end[]" value="{{{$end[$i-1]}}}"/>
                                        </div>
                                    </div>
                                    @endfor
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div clas="form-group" style="clear:both;">
                        <hr/>

                        </div>
                        <div class="form-group">
                            <input type="hidden" name="no_of_period" value="{{{$periodCount}}}"/>
                            <input type="hidden" name="period_id" value="{{{$class_period->period_id}}}"/>
                            <input type="hidden" name="classes_period_id" value="{{{$class_period->classes_period_id}}}"/>
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>
                                <button class="btn btn-default" type="reset">Cancel</button>
                            </div>
                        </div>

                        <!-- </form> -->
                        {{ Form::close() }}
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/settings.js"></script>
@stop
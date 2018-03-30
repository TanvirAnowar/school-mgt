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
                        {{ Form::open(array('class'=>'cmxform form-horizontal','method'=>'post','url'=>url('school/save-period'))) }}
                        <!--<form class="cmxform form-horizontal" id="signupForm" method="get" action="#">-->
                        <input type="hidden" name="refurl" value="{{{url('school/period')}}}"/>
                        <div class="form-group">
                            <label for="no_of_period" class="control-label col-lg-3">Select From Pre-created Period</label>
                            <div class="col-lg-6">
                                <select class="form-control" id="periodSuggest" name="periods">
                                    <option value="">--Select Saved Period --</option>
                                    @if(count($periods))
                                        @foreach($periods as $period)
                                            <option value="{{{$period->period_name}}}">{{{$period->period_name}}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="checkbox" name="create_new" id="createNewPeriod"/> Create New Period
                            </div>
                        </div>

                        <hr/>
                        <div class="form-group">
                            <label for="period_name" class="control-label col-lg-3">Period Name</label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="period_name" name="period_name" type="text" value="" required/>
                            </div>
                        </div>

                        <div id="createNewPeriodArea" class="hide">
                        <div class="form-group">
                            <label for="no_of_period" class="control-label col-lg-3">Number of Period</label>
                            <div class="col-lg-6">
                                <select class="form-control-select2" id="no_of_period" name="no_of_period" style="width:50px;">
                                    @for($i=1;$i<=10;$i++)
                                    <option value="{{{$i}}}">{{{$i}}}</option>
                                    @endfor
                                </select>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button id="populatePeriodGrid" class="btn btn-primary btn-info" type="button">Populate Grid</button>
                                <button id=clearPeriodGrid" class="btn btn-default" type="button">Cancel</button>
                            </div>
                        </div>
                        </div>
                        <hr/>
                        <div class="form-group hide populateGridHidden">
                            <label for="class_id" class="control-label col-lg-3">Class </label>
                            <div class="col-md-2">
                                <select class="form-control" name="class_id">
                                    <option value="">-- Select --</option>
                                    @if(count($classes))
                                        @foreach($classes as $class)
                                            <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>

                            <label for="section_id" class="control-label col-lg-1">Section </label>
                            <div class="col-md-2">
                                <select class="form-control" name="section_id" disabled="disabled">


                                </select>
                            </div>

                        </div>
                        <div class="col-lg-offset-3 popo">
                            <div id="load-view" class="col-lg-12">

                            </div>
                        </div>
                        <div clas="form-group" style="clear:both;">
                        <hr/>

                        </div>
                        <div class="form-group hide populateGridHidden">

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
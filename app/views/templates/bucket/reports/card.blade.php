@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Progress Report
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    {{Form::open(array('url'=>'report','id'=>'getReportFrm','target'=>'_blank','class'=>'cmxform form-horizontal'))}}
                    <div class="form-group">
                        <label class="control-label col-lg-3">Session</label>
                        <div class="col-lg-3">
                            <select name="session" class="form-control" required>

                                @foreach($sessions as $session)
                                <option value="{{{$session}}}">{{{$session}}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">Class</label>
                        <div class="col-lg-3">
                            <select name="class_id" class="form-control" required>
                                @if(count($classes))
                                @foreach($classes as $class)
                                <option value="{{{$class->class_id or ''}}}">{{{$class->class_name or ''}}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">Section</label>
                        <div class="col-lg-3">
                            <select name="section_id" class="form-control" required>
                                @if(count($sections))
                                @foreach($sections as $section)
                                <option value="{{{$section->section_id or ''}}}">{{{$section->section_name or ''}}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">Reg.</label>
                        <div class="col-lg-3">
                            <select name="student[]" class="form-control" required>
                                @if(count($regs))
                                @foreach($regs as $reg)
                                <option value="{{{$reg->student_id or ''}}}">{{{$reg->reg_id or ''}}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-lg-offset-3">


                            <button type="submit" id="viewAllReport" name="viewAllReport" class="btn btn-info">View Result</button>
                        </div>
                    </div>

                    {{Form::close()}}
                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/settings.js"></script>

@stop
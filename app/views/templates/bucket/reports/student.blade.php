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
                                    <?php $from = (date('Y')-2); $to = (date('Y')+1); ?>
                                    @for($i = $from; $i<=$to; $i++)
                                        <option value="{{{$i}}}" @if(date('Y') == $i) selected @endif >{{{$i}}} </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3">Class</label>
                            <div class="col-lg-3">
                                <select name="class_id" class="form-control" required>
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
                                <select name="section_id" class="form-control" required>

                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-lg-3 col-lg-offset-3">
                                <input type="button" id="loadStudent" class="btn btn-primary" value="Load Student"/>
                                <button type="submit" id="viewAllReport" name="viewAllReport" class="btn btn-info hidden">View All</button>
                            </div>
                        </div>
                        <table class="studentReportList display table table-bordered table-striped" id="dynamic-table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"/> Select All</th>
                                    <th>Name</th>
                                    <th>Reg. Id</th>
                                    <th>Class Roll</th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    {{Form::close()}}
                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/settings.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/report.js"></script>
@stop

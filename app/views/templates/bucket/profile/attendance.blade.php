@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading panel-title">
                    Student
                        <span class="tools pull-right">
                            <!--<a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->

                         </span>
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label col-lg-3">Registered Year: {{{$reg->session}}}</label>
                    </div>
                    <table class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Absent</th>
                                <th>Present</th>
                                <th>Class Days</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($months as $month => $monthInWord)
                            @if($month <= date('m'))
                        
                                <tr>
                                    <td>{{{$monthInWord or ''}}}</td>
                                    <td>{{{$attendance[$month]['absent']}}}</td>
                                    <td>{{{($attendance[$month]['class_taken'] - $attendance[$month]['absent'])}}}</td>
                                    <td>{{{$attendance[$month]['class_taken']}}}</td>
                                </tr>
                        

                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
@stop
@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading panel-title">
                    My Subjects
                        <span class="tools pull-right">
                            <!--<a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->

                         </span>
                </header>
                <div class="panel-body">
                    <table class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($subjects))
                                @foreach($subjects as $subject)
                                    <tr>
                                        <td>{{{$subject->getSubject->subject_name or ''}}}</td>
                                        <td>{{{$subject->getSubject->getClass->class_name or ''}}}</td>
                                        <td>{{{$subject->getSection->section_name or ''}}}-{{{$subject->getSection->getShift->shift_name or ''}}}</td>
                                        <td>
                                            <a href="#"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
@stop
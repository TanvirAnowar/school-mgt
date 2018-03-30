@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
{{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Edit Register Student {{{$registration->getStudent->name}}}
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    <form action="{{{url('student/update-registration')}}}" id="editRegisterFrm" method="post" class="cmxform form-horizontal">
                    <input type="hidden" name="refurl" value="{{{url('student/registered-students')}}}"/>
                    <div class="form col-lg-12">

                            <div class="form-group">
                                <label for="session" class="control-label col-lg-3">Session</label>
                                <div class="col-lg-6">
                                    <span class="form-control">{{{$registration->session}}}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="shift_id" class="control-label col-lg-3">Shift</label>
                                <div class="col-lg-6">
                                    <span class="form-control">
                                        @if(count($shifts))
                                            @foreach($shifts as $shift)
                                                @if($shift->shift_id == $registration->shift_id)
                                                    {{{$shift->shift_name}}}
                                                @endif
                                            @endforeach
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="class_id" class="control-label col-lg-3">Class</label>
                                <div class="col-lg-6">
                                    <span class="form-control">
                                        @if(count($classes))
                                            @foreach($classes as $class)
                                                @if($class->class_id == $registration->class_id)
                                                    {{{$class->class_name}}}
                                                @endif
                                            @endforeach
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="section_id" class="control-label col-lg-3">Section</label>
                                <div class="col-lg-6">
                                    <span class="form-control">
                                        @if(count($sections))
                                            @foreach($sections as $section)
                                                @if($section->section_id == $registration->section_id)
                                                    {{{$section->section_name}}}
                                                @endif
                                            @endforeach
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="group_id" class="control-label col-lg-3">Group</label>
                                <div class="col-lg-6">
                                    <span class="form-control">
                                         @if(count($groups))
                                            @foreach($groups as $group)
                                                @if($group->group_id == $registration->group_id)
                                                    {{{$group->group_name}}}
                                                @endif
                                            @endforeach
                                        @endif
                                    </span>

                                </div>
                            </div>


                            <div id="gridHolder">
                                <h5>Assigned Subjects to Student</h5>
                                <hr/>
                                @if(count($registration->StudentSubjects))
                                    @foreach($registration->StudentSubjects as $studentSubject)
                                        <div class="subjectGrid">
                                            <h4 class="text-center">{{{$studentSubject->getSubject->subject_name}}}</h4>
                                            <div class="cell">
                                                @if($studentSubject->subject_status == 'Optional')
                                                    <span>{{{$studentSubject->subject_status}}} </span>
                                                @else
                                                    <span>{{{$studentSubject->subject_status}}} </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
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
<!--<script src="{{$theme}}js/dynamic_table/dynamic_table_init.js"></script>-->
<script src="{{$theme}}js/custom/common.js"></script>
<script src="{{$theme}}js/custom/Classes.js"></script>
<script src="{{$theme}}js/custom/Subjects.js"></script>
<script src="{{$theme}}js/custom/student.js"></script>
<script src="{{$theme}}js/custom/registration.js"></script>
@stop
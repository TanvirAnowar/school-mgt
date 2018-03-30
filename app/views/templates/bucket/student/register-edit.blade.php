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
                                <label for="session" class="control-label col-lg-3">Session <small>(Required)</small></label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" readonly="readonly" name="session" value="{{{$registration->session}}}"/>
                                </div>
                            </div>

                            <!--<div class="form-group">
                                <label for="shift_id" class="control-label col-lg-3">Shift <small>(Required)</small></label>

                                <div class="col-lg-6">
                                    <select class="form-control" id="shift_id" name="shift_id" required>
                                        <option value="">Select</option>
                                        @if(count($shifts))
                                            @foreach($shifts as $shift)
                                                @if($shift->shift_id == $registration->shift_id)
                                                    <option selected="selected" value="{{{$shift->shift_id}}}">{{{$shift->shift_name}}}</option>
                                                @else
                                                    <option value="{{{$shift->shift_id}}}">{{{$shift->shift_name}}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label for="class_id" class="control-label col-lg-3">Class <small>(Required)</small></label>
                                <div class="col-lg-6">
                                    <select class="form-control" id="class_id" name="class_id" required>
                                        <option value="">Select</option>
                                        @if(count($classes))
                                            @foreach($classes as $class)
                                                @if($class->class_id == $registration->class_id)
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
                                <label for="section_id" class="control-label col-lg-3">Section <small>(Required)</small></label>
                                <div class="col-lg-6">
                                    <select class="form-control" id="section_id" name="section_id"  style="width:150px;" required>
                                        @if(count($sections))
                                            @foreach($sections as $section)
                                                @if($section->section_id == $registration->section_id)
                                                    <option selected="selected" value="{{{$section->section_id}}}">{{{$section->section_name}}}-{{{$section->getShift->shift_name}}}</option>
                                                @else
                                                    <option value="{{{$section->section_id}}}">{{{$section->section_name}}}-{{{$section->getShift->shift_name}}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="group_id" class="control-label col-lg-3">Group <small>(Required)</small></label>
                                <div class="col-lg-6">
                                    <select class="form-control" id="group_id" name="group_id" required>
                                        <option value="">Select</option>
                                        @if(count($groups))
                                            @foreach($groups as $group)
                                                @if($group->group_id == $registration->group_id)
                                                    <option selected="selected" value="{{{$group->group_id}}}">{{{$group->group_name}}}</option>
                                                @else
                                                    <option value="{{{$group->group_id}}}">{{{$group->group_name}}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="subjects" class="control-label col-lg-3">Subjects</label>
                                <div class="col-lg-4">
                                    <select class="form-control" multiple="multiple" id="subjects" name="subjects">
                                        @if(count($subjects))
                                            @foreach($subjects as $subject)


                                                        <option value="{{{$subject->subject_id}}}">{{{$subject->subject_name}}}</option>


                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <select class="form-control" multiple="multiple" id="student_subjects" name="student_subjects[]">

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="subjects" class="control-label col-lg-4"></label>
                                <button class="btn btn-primary" id="includeSelected" type="button">></button>
                                <button class="btn btn-primary" id="includeAll" type="button">>></button>
                                <button class="btn btn-primary" id="excludeSelected" type="button"><</button>
                                <button class="btn btn-primary" id="excludeAll" type="button"><<</button>
                            </div>


                            <!--<div class="form-group">
                                <label for="medium" class="control-label col-lg-3">Medium</label>
                                <div class="col-lg-4">
                                    <select type="text" class="form-control" id="medium" name="medium" required>
                                        <option value="">Select</option>
                                        <option value="Bangla">Bangla</option>
                                        <option value="O-Level">O-Level</option>
                                        <option value="A-Level">A-Level</option>
                                        <option value="College">College</option>
                                    </select>
                                </div>
                            </div>-->
                            <div id="gridHolder">
                                <h5>Assigned Subjects to Student</h5>
                                <hr/>

                                @if(count($registration->StudentSubjects))
                                    @foreach($registration->StudentSubjects as $studentSubject)
                                        <div class="subjectGrid">
                                            <h4 class="text-center">{{{$studentSubject->getSubject->subject_name or 'Subject not found'}}} <a href="{{{$studentSubject->student_subject_id}}}" class="del-stud-sub fa fa-trash-o"></a></h4>
                                            <div class="cell">
                                                @if($studentSubject->subject_status == 'Optional')
                                                <span>{{{$studentSubject->subject_status}}} <input type="checkbox" class="changeStudentSubjectStatus" checked="checked" value="{{{$studentSubject->student_subject_id}}}"/></span>
                                                @else

                                                <span>
                                                    @if(count($studentSubject->getSubject) && $studentSubject->getSubject->subject_status == 3)
                                                    <input type="checkbox" class="changeStudentSubjectStatus" value="{{{$studentSubject->student_subject_id}}}"/>
                                                    @endif
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <hr style="clear:both;"/>
                            <div class="form-group">
                                <input type="hidden" name="id" value="{{{$registration->id}}}"/>
                                <input type="hidden" name="student_id" value="{{{$registration->student_id}}}"/>
                                <div class="col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                    <button class="btn btn-default" type="reset">Clear</button>
                                </div>
                            </div>

                            <!--<div class="form-group">
                                <label for="optional" class="control-label col-lg-3">Optional Subjects</label>
                                <div class="col-lg-4">
                                    <select class="form-control" multiple="multiple" id="optional_subjects" name="optional_subjects">

                                    </select>
                                </div>
                            </div>-->

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
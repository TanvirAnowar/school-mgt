@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
{{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Register Student
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    <form action="{{{url('student/save-registration')}}}" id="registerFrm" method="post" class="cmxform form-horizontal">
                    <input type="hidden" name="refurl" value="{{{url('student/registered-students')}}}"/>
                    <div class="form col-lg-5">

                            <div class="form-group">
                                <label for="session" class="control-label col-lg-3">Session <small>(Required)</small></label>
                                <div class="col-lg-6">
                                    <select class="form-control-select2" id="session" name="session" required>
                                        <option value="">Select Year</option>
                                        <?php $year = (int)date("Y")-1; $to = $year+10; ?>
                                        <?php for($i = $year; $i<=$to; $i++){ ?>
                                        <option value="{{{$i}}}">{{{$i}}}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                           <!-- <div class="form-group">
                                <label for="shift_id" class="control-label col-lg-3">Shift <small>(Required)</small></label>

                                <div class="col-lg-6">
                                    <select class="form-control" id="shift_id" name="shift_id" required>
                                        <option value="">Select</option>
                                        @if(count($shifts))
                                            @foreach($shifts as $shift)
                                                <option value="{{{$shift->shift_id}}}">{{{$shift->shift_name}}}</option>
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
                                                <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="section_id" class="control-label col-lg-3">Section <small>(Required)</small></label>
                                <div class="col-lg-6">
                                    <select class="form-control" id="section_id" name="section_id"  style="width:150px;" disabled required>
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
                                                <option value="{{{$group->group_id}}}">{{{$group->group_name}}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="subjects" class="control-label col-lg-3">Subjects</label>
                                <div class="col-lg-4">
                                    <select class="form-control" multiple="multiple" id="subjects" name="subjects">

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
                            </hr style="clear:both;">
                            <div class="form-group">

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
                    <div class="form col-lg-6">
                        <div class="form-group">
                            <label for="student_type" class="control-label col-lg-1">Type</label>
                            <div class="col-lg-4">
                                <select class="form-control" id="student_type" name="student_type">
                                    <option value="New">New</option>
                                    <option value="Running">Running</option>
                                </select>
                            </div>

                            <label for="optional" class="control-label col-lg-3">Filter</label>
                            <div class="col-lg-4">
                                <select class="form-control" id="filter" name="filter">
                                    <option value="All">Select</option>
                                    @if(count($classes))
                                        @foreach($classes as $class)
                                            <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <table  class="unregisteredStudentsList Zdisplay table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                    <tr>
                                        <th>Select All <input type="checkbox" id="selectTopAll"/></th>
                                        <th>Reg. Year</th>
                                        <th>Student Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th class="hidden-phone">Class Roll</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr class="gradeX">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="center hidden-phone">
                                            &nbsp;
                                            <!--<a href="#" class="grid-action-link"><i class="fa fa-trash-o" title="Delete"></i></a>-->
                                        </td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Select All <input type="checkbox" id="selectBottomAll"/></th>
                                        <th>Reg. Year</th>
                                        <th>Student Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th class="hidden-phone">Class Roll</th>
                                    </tr>
                                </tfoot>
                            </table>
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
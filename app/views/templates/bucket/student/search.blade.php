@extends('templates.bucket.bucket')


@section('wrapper')
<section class="wrapper">
    <div class="row">
        {{Form::open(array('url'=>'student/search','method'=>'post','id'=>'studentSearchForm','class'=>'cmxform form-horizontal'))}}
        <input type="hidden" name="refurl" value="{{{url('student/lists')}}}"/>
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Search Information
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    <div class="form">
                        <div class="form-group">
                            <label for="name_initial" class="control-label col-lg-3">Search Here</label>
                            <div class="col-lg-4">
                                <input class="form-control" id="searchStudentTxt" type="text" required/>
                            </div>
                            <div class="col-lg-2"><input class="btn btn-primary" id="searchStudentBtn" type="button" value="Search"/></div>
                        </div>
                    </div>

                    <div class="adv-table">
                        <table class="display table table-bordered table-striped searchStudentTable" id="dynamic-table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Unique ID</th>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Father Name</th>
                                    <th>Mother Name</th>
                                    <th>Date of Birth</th>
                                    <th>Contact No</th>
                                    <th class="hidden-phone">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                </div>
            </section>
        </div>

        {{Form::close()}}
    </div>

</section>
<script src="{{$theme}}js/custom/student.js"></script>
@stop
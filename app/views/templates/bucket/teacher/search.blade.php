@extends('templates.bucket.bucket')


@section('wrapper')
<section class="wrapper">
    <div class="row">
        {{Form::open(array('url'=>'teacher/update-teacher','method'=>'post','id'=>'teacherSearchForm','class'=>'cmxform form-horizontal'))}}
        <input type="hidden" name="refurl" value="{{{url('teacher/lists')}}}"/>
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
                            <label for="name_initial" class="control-label col-lg-3">Search Here </label>
                            <div class="col-lg-4">
                                <input class="form-control" id="searchTeacherTxt" type="text" required/>
                            </div>
                            <div class="col-lg-2"><button class="btn btn-primary" id="searchTeacherBtn" type="button">Search</button></div>
                        </div>
                    </div>

                    <div class="adv-table">
                        <table class="display table table-bordered table-striped searchTeacherTable" id="dynamic-table">
                            <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>Teacher Initial</th>
                                <th>Teacher Name</th>
                                <th>Cell no</th>
                                <th>E-mail</th>
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
<script src="{{$theme}}js/custom/teacher.js"></script>
@stop
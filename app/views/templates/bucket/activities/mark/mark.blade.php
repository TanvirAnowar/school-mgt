@extends('templates.bucket.bucket')


@section('wrapper')
<section class="wrapper">
    <form id="markInputFrm" method="post">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading panel-title">
                    Award Mark
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                </header>
                <div class="panel-body">
                    <div class="row">

                        <div class="col-lg-4 popo-tbl">
                            <span>Session :</span>

                            <div class="col-lg-8">
                                <select class="form-control" name="session" title="Session" required>
                                    <option value="">Select Year</option>
                                    <?php $year = (int)date("Y")-1; $to = $year+10; ?>
                                    <?php for($i = $year; $i<=$to; $i++){ ?>
                                        <option value="{{{$i}}}">{{{$i}}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 popo-tbl">
                            <span>Class :</span>

                            <div class="col-lg-8">
                                <select class="form-control" name="class_id" title="Class" required>
                                    <option value="">Select Class</option>
                                    @if(count($classes))
                                        @foreach($classes as $class)
                                            <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 popo-tbl">
                            <span>Group :</span>

                            <div class="col-lg-8">
                                <select class="form-control" name="group_id" title="Group" required>
                                    <option value="">Select Group</option>
                                    @if(count($groups))
                                        @foreach($groups as $group)
                                        <option value="{{{$group->group_id}}}">{{{$group->group_name}}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 popo-tbl">
                            <span>Term :</span>

                            <div class="col-lg-8">
                                <select class="form-control" name="term" title="Term" required>
                                    @if(count($terms))
                                        @foreach($terms as $term)
                                            <option value="{{{$term}}}">{{{$term}}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 popo-tbl">
                            <span>Section :</span>

                            <div class="col-lg-8">
                                <select class="form-control" name="section_id" title="Section" required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 popo-tbl">
                            <span>Subject :</span>

                            <div class="col-lg-8">
                                <select class="form-control" name="subject_id" title="Subject" required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 popo-tbl">
                            <button id="saveMarkBtn" class="btn btn-warning col-lg-4 hidden" type="button">Save</button>
                            <button class="btn btn-warning col-lg-5" id="loadStudentForMarkBtn" type="button">Load Students</button>
                        </div>

                    </div>
                    <br/>
                    <section id="unseen" class="popo-ttbl">

                    <div class="col-lg-6 tbl-part">
                        <table class="table table-bordered table-striped table-condensed" style="margin-bottom:0 !important;box-shadow: 0 7px 12px -7px #777777; position:relative;z-index:1000;">
                            <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Student Roll</th>
                            </tr>
                            </thead>
                        </table>
                    </div>



                    <div style="clear:both;"></div>

                    <div  id="markGrid" style="height:400px; overflow:auto; display:none; ">




                    </div>


                    </section>
                </div>
            </section>
        </div>
    </div>
    </form>
</section>
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/Validate.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/CustomMessage.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/activities.js"></script>
<script type="text/javascript">
    $("select").change(function(){
        $("#markGrid").html("");
    });
</script>
@stop
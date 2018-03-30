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

<div class="col-lg-6 tbl-part tbl-partt">
    <section class="table tab-tbl" style="margin-bottom:0 !important;box-shadow: 0 7px 12px -7px #777777; position:relative;z-index:1000;">
        <header>
            <ul class="nav nav-tabs">
                @if(count($markSettings))
                    @foreach($markSettings as $i => $s)
                    @if($i==0)
                        <li class="active"><a data-toggle="tab" href="#{{str_replace(' ','',$s->getMarkType->mark_type)}}">{{$s->getMarkType->mark_type}}</a></li>
                    @else
                        <li><a data-toggle="tab" href="#{{str_replace(' ','',$s->getMarkType->mark_type)}}">{{$s->getMarkType->mark_type}}</a></li>
                    @endif
                    @endforeach
                @endif
            </ul>
        </header>
    </section>
</div>

<div style="clear:both;"></div>

<div id="markGrid" style="height:250px; overflow:auto;">

<div class="col-lg-6 tbl-part">
    <table class="table table-bordered table-striped table-condensed">

        <tbody>
        @if(count($students) && (!empty($teacher)))
            @foreach($students as $student)
                <tr>
                    <td>{{{$student->reg_id}}}</td>
                    <td style="font-size:12px;">{{{$student->name}}}</td>
                    <td>{{{$student->class_roll}}}</td>
                </tr>

            @endforeach
        @endif

        </tbody>
    </table>
</div>
<div class="col-lg-6 tbl-part tbl-partt">
    <?php  $markTypes = (!empty($marks->subjects->{$subject->subject_name}))? $marks->subjects->{$subject->subject_name} : '' ; ?>
<section class="table tab-tbl">

<div class="panel-body h-tab-body">
<div class="tab-content">
    @if(count($markSettings))
    @foreach($markSettings as $i=> $s)

        <?php
        $mark_type = strtolower($s->getMarkType->mark_type); // subjective or class test
        $markType = (!empty($markTypes->{$mark_type}))? $markTypes->{$mark_type} : '';
        ?>
<div id="{{str_replace(' ','',$s->getMarkType->mark_type)}}" class="tab-pane {{($i==0)? 'active' : ''}} ">
    <table id="marks" width="100%" class="table table-bordered table-striped table-condensed tab-tbl-row" border="0"
           cellspacing="0" cellpadding="0">
        <tbody>
        @if(count($students) && (!empty($teacher)))
            @foreach($students as $student)
                    <?php $studentMark = ((!empty($markType)) && (!empty($markType->{$student->sid})))? $markType->{$student->sid} : '';  ?>
                    @if(str_replace(' ','',strtolower($s->getMarkType->mark_type)) != 'classtest')
                        <tr>
                            <td ><input data-id="{{{$student->sid}}}" data-regid="{{{$student->reg_id}}}" data-type="{{{strtolower($s->getMarkType->mark_type)}}}" data-index="1"  class="form-control input-sm mark markAdded"  style="width:15%;" type="text" value="<?php echo (!empty($studentMark))? $studentMark->marks->{1} : ''; ?>"></td>
                        </tr>
                    @else
                        <tr>
                            @foreach($classTests as $index=> $ct)
                                <td><input data-id="{{{$student->sid}}}" data-regid="{{{$student->reg_id}}}" data-type="{{{strtolower($s->getMarkType->mark_type)}}}" data-index="{{{($index+1)}}}" class="form-control input-sm mark markAdded" type="text" value="<?php echo ((!empty($studentMark)) && (!empty($studentMark->marks->{($index+1)}))) ? $studentMark->marks->{($index+1)} : ''; ?>"></td>
                            @endforeach
                        </tr>
                    @endif
            @endforeach
        @endif


        </tbody>

    </table>
</div>
    @endforeach
    @endif
<!--<div id="objective" class="tab-pane">
    <table width="100%" class="table table-bordered table-striped table-condensed tab-tbl-row" border="0"
           cellspacing="0" cellpadding="0">
        <tbody>
        @if(count($students))
            @foreach($students as $student)
                <tr>

                    <td><input class="form-control input-sm" type="text"></td>
                </tr>
            @endforeach
        @endif

        </tbody>

    </table>
</div>
<div id="class_test" class="tab-pane">
    <table width="100%" class="table table-bordered table-striped table-condensed tab-tbl-row" border="0"
           cellspacing="0" cellpadding="0">
        <tbody>
        @if(count($students))
            @foreach($students as $student)
                <tr>
                    <td><input class="form-control input-sm" type="text"></td>

                    <td><input class="form-control input-sm" type="text"></td>
                </tr>
            @endforeach
        @endif


        </tbody>

    </table>
</div>
<div id="practical" class="tab-pane">
    <table width="100%" class="table table-bordered table-striped table-condensed tab-tbl-row" border="0"
           cellspacing="0" cellpadding="0">
        <tbody>
        @if(count($students))
            @foreach($students as $student)
                <tr>
                    <td><input class="form-control input-sm" type="text"></td>
                    <td><input class="form-control input-sm" type="text"></td>

                </tr>
            @endforeach
        @endif

        </tbody>

    </table>
</div>-->
</div>
</div>


</section>
</div>

</div>
<script type="text/javascript">
    $("#markGrid").slimscroll({
        height: '250px',
        alwaysVisible:true
    });
</script>
/**
 * Created by Tanvir Anowar on 2/24/14.
 */
//public/themes/bucket/js/custom/settings.js
$(function(){

    // populate grid for period settings
    $("#populatePeriodGrid").click(function(){

        var $n = parseInt($("#no_of_period").val());
        var $gridHolder = $("#load-view");

        var $gridHtml = '<div id="gridHolder">';
        for(var $i=1; $i<=$n;$i++)
        {
            $gridHtml += '<div class="periodGrid"><h4 class="text-center">'+$i+' no period</h4><div class="cell">';
            $gridHtml += '<label class="col-xs-1">Start</label><input type="text" class="timepicker-default start" name="start[]"/>';
            $gridHtml += '<label class="col-xs-1">End&nbsp;</label><input type="text" class="timepicker-default end" name="end[]"/>';
            $gridHtml += '</div></div>';
        }
        $gridHtml += '</div>';
        $gridHolder.html($gridHtml);
        $(".populateGridHidden").removeClass('hide');
        $(".timepicker-default").timepicker(
           /* {
            autoclose: true,
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        }*/
        );

    });

    $(".edit-mark-type").click(function(){
        var $editMarkTypeFrm = $("#editMarkTypeFrm");
        var obj = $(this);
        var $prevValue = obj.parent().siblings().eq(1).text();
        var markTypeId = obj.attr('data-marktype-id');
        var markTypeOrder = obj.attr('data-mark-type-order');
        $editMarkTypeFrm.find('input[name=mark_type]').val($prevValue);
        $editMarkTypeFrm.find('input[name=mark_type_order]').val(markTypeOrder);
        $editMarkTypeFrm.find('input[name=mark_type_id]').val(markTypeId);
    });

    // show edit form for shift settings
    $(".shift_settings_edit").click(function(){
        var $editShiftFrm = $("#editShiftFrm");
        var obj = $(this);
        var $prevValue = obj.parent().siblings().eq(1).text();
        var shiftId = obj.attr('data-shift-id');
        $editShiftFrm.find('input[name=shift_name]').val($prevValue);
        $editShiftFrm.find('input[name=shift_id]').val(shiftId);
    });

    // show edit form for group settings
    $(".group_settings_edit").click(function(){
        var $editGroupFrm = $("#editGroupFrm");
        var obj = $(this);
        var $prevValue = obj.parent().siblings().eq(1).text();
        var groupId = obj.attr('data-group-id');
        $editGroupFrm.find('input[name=group_name]').val($prevValue);
        $editGroupFrm.find('input[name=group_id]').val(groupId);
    });

    // show edit form for class settings
    $(".class_settings_edit").click(function(){
        var $editClassFrm = $("#editClassFrm");
        var obj = $(this);
        var $prevClassName = obj.parent().siblings().eq(1).text();
        var $prevClassCode = obj.parent().siblings().eq(2).text();
        var $prevClassType = obj.parent().siblings().eq(3).text();

        var classId = obj.attr('data-class-id');
        $editClassFrm.find('input[name=class_name]').val($prevClassName);
        $editClassFrm.find('input[name=class_code]').val($prevClassCode);
        $classTypes = $("input[name=class_type]");
        $.each($classTypes,function(i,el){
           if($(this).val() == $prevClassType)
           {
               $(this).attr('checked','checked');
           }
        });
        $editClassFrm.find('input[name=class_id]').val(classId);
    });

    // get section by class
    $("select[name=class_id]").change(function(){

        var obj = $(this);
        var classes = new Classes();
        classes.sections(obj.val(),$("select[name=section_id]"));
        classes.subjects(obj.val(),$("select[name=subject_id]"));

    });



    $("#createNewPeriod").change(function(){
        var obj = $(this);
        if(obj.attr('checked'))
        {
            $("#createNewPeriodArea").removeClass('hide');

        }else{
            $("#createNewPeriodArea").addClass('hide');
        }
    });

    $("#periodSuggest").change(function(){
        var obj = $(this);
        var $gridHolder = $("#load-view");
        $.ajax({
            type:"POST",
            url : BASE+'ajax/get-period-by-name',
            data: {period_name:obj.val()},
            success:function(e)
            {
                var data = $.parseJSON(e);
                if(data.periodCount)
                {
                    var $gridHtml = '<div id="gridHolder">';
                    var n = data.periodCount;
                    $("select[name=no_of_period]").children().eq(n-1).attr('selected','selected');
                    var start = data.start;
                    var end = data.end;

                    for(var i=0; i<n; i++){
                        var startTime = start[i];
                        var endTime = end[i];

                        $gridHtml += '<div class="periodGrid"><h4 class="text-center">'+(i+1)+' no period</h4><div class="cell">';
                        $gridHtml += '<label class="col-xs-1">Start</label><input type="text" class="timepicker-default" name="start[]" value="'+(startTime)+'"/>';
                        $gridHtml += '<label class="col-xs-1">End&nbsp;</label><input type="text" class="timepicker-default" name="end[]" value="'+(endTime)+'"/>';
                        $gridHtml += '</div></div>';

                    }
                    $gridHtml += '</div>';

                    $gridHolder.html($gridHtml);
                    $("input[name=period_name]").val(obj.val());
                    $(".populateGridHidden").removeClass('hide');

                }


            }
        });
    });




    $(".delete-grade-settings").click(function(){
        var obj = $(this);
        if(confirm('Are you sure to delete this record ?'))
        {
            $.ajax({
                type:"POST",
                url : BASE + 'settings/delete-grade-setting',
                data:{id:obj.attr('href')},
                success:function(e){
                    var data = $.parseJSON(e);
                    if(data.status == 200)
                    {
                        obj.parent().parent().remove();
                        window.location.reload();
                    }
                }
            });
        }
        return false;
    });

    $(".undo-delete-grade-settings").click(function(){
        var obj = $(this);
        if(confirm('Are you sure to retrieve this record ?'))
        {
            $.ajax({
                type:"POST",
                url : BASE + 'settings/undo-delete-grade-setting',
                data:{id:obj.attr('href')},
                success:function(e){
                    var data = $.parseJSON(e);
                    if(data.status == 200)
                    {
                        obj.parent().parent().remove();
                        window.location.reload();
                    }
                }
            });
        }
        return false;
    });


    $("#teacherAssignFrm select[class_id]").change(function(){
       var obj = $(this);
       var classObj = new Classes();
       classObj.subjects(obj.val(),$("#teacherAssignFrm select[subject_id]"));
    });


    $(".delete-teacher-assign").live('click',function(){
       var obj = $(this);
        if(confirm('Are you sure to delete this record ?'))
        {
            $.ajax({
               type:"POST",
               url : BASE + 'school/delete-teacher-assign',
               data: { id: obj.attr('href')},
               success:function(e)
               {
                   obj.parent().parent().remove();
                   window.location.reload();
               }
            });
        }
        return false;
    });


    $("#clearTrashTeacherFrm").submit(function(){
        if(confirm('Are you sure to clear trash?'))
        {
            return true;
        }else{
            return false;
        }
    });




});
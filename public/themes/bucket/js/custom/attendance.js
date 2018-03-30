/**
 * Created by Tanvir Anowar on 4/16/14.
 */
$(function(){

    var classElm = $("select[name=class_id]");
    var sectionElm = $("select[name=section_id]");
    $("input[name=attendance_date]").datepicker();
    if(classElm.val())
    {
        var classObj = new Classes();
        classObj.sections(classElm.val(),sectionElm);
    }

    classElm.change(function(){
       var obj = $(this);
       var classObj = new Classes();
       classObj.sections(obj.val(),sectionElm);
    });

    sectionElm.change(function(){
        $(".attendance_grid tbody").html('');
    });

    $("#loadStudent").click(function(){
        var obj = $(this);
        var session = $("select[name=session]").val();
        var classId = $("select[name=class_id]").val();
        var sectionId = $("select[name=section_id]").val();
        var attendanceDate = $("input[name=attendance_date]").val();

        // for manual system
        if(session && classId && sectionId){
            $.ajax({
               type:"POST",
               url : BASE + 'activities/get-student-attendance',
               data: { session:session, class_id:classId, section_id:sectionId, attendance_date:attendanceDate},
               beforeSend:function()
               {

                   $("#loader").remove();
                   obj.after('<div id="loader" class="text-center"><img src="'+BASE+'public/themes/bucket/images/ajax-loader.gif"/></div>');
               },
               success:function(e)
               {
                    $("#loader").remove();
                    var data = $.parseJSON(e);

                    var attendance = $.parseJSON(data.attendance);
                    if(attendance.length)
                    {
                        //console.log(e);
                        var trHtml = '';
                        $.each(attendance,function(i,elm){
                            trHtml += '<tr>';
                            trHtml += '<td>'+(i+1)+'</td>';
                            trHtml += '<td><input type="hidden" name="reg_id[]" value="'+attendance[i].id+'"/>'+attendance[i].name+'</td>';
                            trHtml += '<td>'+attendance[i].class_name+', Section:'+attendance[i].section_name+', Shift: '+attendance[i].shift_name+'</td>'
                            trHtml += '<td>'+attendance[i].class_roll+'</td>';
                            if(data.type == 'Automatic')
                            {
                                if(attendance[i].attendance_id > 0)
                                {
                                    trHtml += '<td><input type="hidden" name="attendance['+attendance[i].id+']" value="Present"/><input type="button" id="attendanceAutoBtn" data-id="'+attendance[i].sid+'" class="btn btn-success" value="Present"/></td>';

                                }else{
                                    trHtml += '<td><input type="hidden" name="attendance['+attendance[i].id+']" value="Absent"/><input type="button" id="attendanceAutoBtn" data-id="'+attendance[i].sid+'" class="btn btn-danger" value="Absent"/></td>';
                                }
                            }
                            else{
                                if(attendance[i].attendance_id > 0)
                                {
                                    trHtml += '<td><input type="hidden" name="attendance['+attendance[i].id+']" value="Absent"/><input type="button" id="attendanceBtn" data-id="'+attendance[i].sid+'" class="btn btn-danger" value="Absent"/></td>';
                                }else{
                                    trHtml += '<td><input type="hidden" name="attendance['+attendance[i].id+']" value="Present"/><input type="button" id="attendanceBtn" data-id="'+attendance[i].sid+'" class="btn btn-success" value="Present"/></td>';
                                }
                            }

                            trHtml += '</tr>'
                        });
                        $(".attendance_grid tbody").html(trHtml);
                        $("input[name=refresh_token]").val(data.refresh_token);
                    }
               }
            });
        }else{
            alert("Please select all options");
        }

    });

    $("#attendanceBtn").live('click',function(){
        var obj = $(this);
        var session = $("select[name=session]").val();
        var classId = $("select[name=class_id]").val();
        var sectionId = $("select[name=section_id]").val();
        var attendanceDate = $("input[name=attendance_date]").val();
        var term = $("select[name=term]").val();
        
        if(obj.val() == 'Present')
        {
            $.ajax({
               type:"POST",
               url : BASE + 'activities/change-attendance',
               data:{ term:term, attendance:1,class_id:classId,section_id:sectionId,attendance_date:attendanceDate,id:obj.attr('data-id')},
               success:function(e)
               {
                   obj.removeClass('btn-success').addClass('btn-danger').val('Absent');
                   obj.prev().val('Absent');
               }
            });
        }else{

            $.ajax({
                type:"POST",
                url : BASE + 'activities/change-attendance',
                data:{ term:term, attendance:0,class_id:classId,section_id:sectionId,attendance_date:attendanceDate,id:obj.attr('data-id')},
                success:function(e)
                {

                    obj.removeClass('btn-danger').addClass('btn-success').val('Present');
                    obj.prev().val('Present');
                }
            });

        }
    });

    $("#attendanceAutoBtn").live('click',function(){
        var obj = $(this);
        var session = $("select[name=session]").val();
        var classId = $("select[name=class_id]").val();
        var sectionId = $("select[name=section_id]").val();
        var attendanceDate = $("input[name=attendance_date]").val();
        if(obj.val() == 'Present')
        {
            $.ajax({
               type:"POST",
               url : BASE + 'activities/change-attendance',
               data:{ attendance:0,class_id:classId,section_id:sectionId,attendance_date:attendanceDate,id:obj.attr('data-id')},
               success:function(e)
               {
                   obj.removeClass('btn-success').addClass('btn-danger').val('Absent');
                   obj.prev().val('Absent');
               }
            });
        }else{

            $.ajax({
                type:"POST",
                url : BASE + 'activities/change-attendance',
                data:{ attendance:1,class_id:classId,section_id:sectionId,attendance_date:attendanceDate,id:obj.attr('data-id')},
                success:function(e)
                {

                    obj.removeClass('btn-danger').addClass('btn-success').val('Present');
                    obj.prev().val('Present');
                }
            });

        }
    });

    $("#sendAttendanceSms").click(function(){
        var students = $(".attendance_grid tbody").children();

        if(students.length){
            if(confirm('Are you sure to send attendance SMS?'))
            {

                $.ajax({
                    type:"POST",
                    url : BASE + 'sms/send-attendance-sms',
                    data: $("#addTaskFrm").serialize(),
                    success:function(e)
                    {
                        var data = $.parseJSON(e);
                        if(data.status == 400)
                        {
                            alert(data.message);

                        }else if(data.status == 200){

                            alert(data.message);
                        }


                    }
                });

            }
        }else{
            alert('Load Student Please');
        }

    });

});
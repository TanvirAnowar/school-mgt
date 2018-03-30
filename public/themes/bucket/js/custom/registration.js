/**
 * Created by Tanvir Anowar on 3/10/14.
 */
$(function(){
    $("select[name=filter]").change(function(){
        var obj = $(this);
        var classes = new Classes();
        var studentObj = new Student();
        classes.sections(obj.val(),$("select[name=section_id]"));
        classes.subjects(obj.val(),$("select[name=subjects]"));
        $("select[name=class_id]").val(obj.val());
        $("select[name=group_id]").children().eq(0).attr('selected','selected');
        classId = obj.val();
        studentType = $("select[name=student_type]").val();
        $("#selectTopAll").removeAttr('checked');
        $("#selectBottomAll").removeAttr('checked');
        switch(studentType)
        {
            case 'New':
                studentObj.getNewStudent(classId,studentType,$(".unregisteredStudentsList tbody"));
                break;
            case 'Running':
                studentObj.getRunningStudent(classId,studentType,$(".unregisteredStudentsList tbody"));
                break;
        }

    });

    $("select[name=filter]").children().eq(0).attr('selected','selected');

    $("select[name=student_type]").change(function(){
        $("select[name=filter]").children().eq(0).attr('selected','selected');
    });

    $("#registerFrm select[name=class_id]").change(function(){
        var obj = $(this);
        var classes = new Classes();
        classes.sections(obj.val(),$("select[name=section_id]"));
        classes.subjects(obj.val(),$("select[name=subjects]"));
        $("select[name=group_id]").children().eq(0).attr('selected','selected');
    });

    $("#searchReg select[name=class_id]").change(function(){
        var obj = $(this);
        var classes = new Classes();
        classes.sections(obj.val(),$("select[name=section_id]"));
    });

    var searchFrmClassElm = $("#searchReg select[name=class_id]");
    if(searchFrmClassElm.val())
    {
        var classes = new Classes();
        classes.sections(searchFrmClassElm.val(),$("select[name=section_id]"));
    }
    $("#editRegisterFrm select[name=class_id]").change(function(){
        var obj = $(this);
        var classes = new Classes();
        classes.sections(obj.val(),$("select[name=section_id]"));
        classes.subjects(obj.val(),$("select[name=subjects]"));

    });

    $("#includeSelected").click(function(){
        if($("select[name=subjects] option:selected").length)
            $("select#student_subjects").append($("select[name=subjects] option:selected").remove());
            $("select#student_subjects").children().attr('selected','selected');
    });
    $("#includeAll").click(function(){
        if($("select[name=subjects] option").length)
            $("select#student_subjects").append($("select[name=subjects] option").remove());
            $("select#student_subjects").children().attr('selected','selected');
    });

    $("#excludeSelected").click(function(){
        if($("select#student_subjects option:selected").length)
            $("select[name=subjects]").append($("select#student_subjects option:selected").remove());
    });
    $("#excludeAll").click(function(){
        if($("select#student_subjects option").length)
            $("select[name=subjects]").append($("select#student_subjects option").remove());
    });

    $("select[name=group_id]").change(function(){
        var $groupId = $(this).val();
        var $classId = $("select[name=class_id]").val();
        var subjectObj = new Subjects();
        subjectObj.optionalSubjects($classId,$groupId,$("select[name=subjects]"));
    });

    $("input.changeStudentSubjectStatus").change(function(){
        var obj = $(this);
        var subjectStatus = '';
        if(obj.attr('checked'))
        {
            subjectStatus = 'Optional';
        }else{
            subjectStatus = 'Compulsory';
        }

        $.ajax({
            type: "POST",
            url : BASE + 'ajax/change-student-subject-status',
            data: { id:obj.val(), subject_status:subjectStatus },
            success:function(e)
            {
                obj.parent().text(subjectStatus);
            }
        });
    });

    $(".register-del").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to delete this record?'))
        {
            $.ajax({
               type:"POST",
               url : BASE + 'student/delete-registration',
               data: {id:obj.attr('href')},
               success:function(e)
               {

                   var data = $.parseJSON(e);
                   if(data.status == 200)
                   {
                       obj.parent().parent().remove();
                      // window.location = BASE+'student/registered-students';
                   }
               }
            });
        }
        return false;
    });

    $(".register-remove").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to delete this record?'))
        {
            $.ajax({
                type:"POST",
                url : BASE + 'student/delete-trash-registration',
                data: {id:obj.attr('href')},
                beforeSend:function()
                {
                    obj.parent().parent().hide();
                },
                success:function(e)
                {

                    var data = $.parseJSON(e);
                    if(data.status == 200)
                    {
                        obj.parent().parent().remove();
                        // window.location = BASE+'student/registered-students';
                    }
                }
            });
        }
        return false;
    });

    $(".register-undo").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to retrieve this record?'))
        {
            $.ajax({
               type:"POST",
               url : BASE + 'student/undo-del-registration',
               data: {id:obj.attr('href')},
               success:function(e)
               {

                   var data = $.parseJSON(e);
                   if(data.status == 200)
                   {
                       obj.parent().parent().remove();

                   }
               }
            });
        }
        return false;
    });

    $("#searchRegStudent").click(function(){
        var session   = $("select[name=session]").val();
        var classId   = $("select[name=class_id]").val();
        var sectionId = $("select[name=section_id]").val();
        var classRoll = $("input[name=class_roll]").val();

        if(session)
        {
            $.ajax({
                type:"POST",
                url : BASE + 'ajax/get-registered-student',
                data:{session:session,class_id:classId,section_id:sectionId,class_roll:classRoll},
                beforeSend:function(){
                  $("#updateRegFrmBtn").remove();
                },
                success:function(e)
                {
                    var data = $.parseJSON(e);

                    if(data.length)
                    {
                        var trHtml = '';

                        $.each(data,function(i,el){
                            var phoneNo = (data[i].father_cell_number)? data[i].father_cell_number : data[i].mother_cell_number;
                            trHtml += '<tr><td>'+(i+1)+'</td>';
                            trHtml += '<td>'+data[i].reg_id+'</td>';
                            /*trHtml += '<td>'+data[i].sid+'</td>';*/
                            trHtml += '<td>'+data[i].student_id+'</td>';
                            trHtml += '<td>'+data[i].session+'</td>';
                            trHtml += '<td>'+data[i].name+'</td>';
                            trHtml += '<td>'+phoneNo+'</td>'
                            trHtml += '<td>'+data[i].class_name+'</td>';
                            trHtml += '<td>'+data[i].section_name+'</td>';
                            trHtml += '<td>'+data[i].shift_name+'</td>';
                            trHtml += '<td>'+data[i].group_name+'</td>';
                            trHtml += '<td><input type="text" class="form-control" style="width:80px;" name="reg_id['+data[i].reg_id+']" value="'+data[i].class_roll+'"/></td>';
                            trHtml += '<td>';
                            trHtml += '<a href="'+BASE+'student/register/edit/'+data[i].id+'" title="Edit" class="register-edit"><i class="fa fa-pencil"></i></a>';
                            trHtml += '&nbsp;<a href="'+BASE+'student/view/'+data[i].sid+'" title="Profile" class="register-view"><i class="fa fa-user"></i></a>';
                            trHtml += '&nbsp;<a href="'+BASE+'student/register/view/'+data[i].id+'" title="View" class="register-view"><i class="fa fa-eye"></i></a>';
                            trHtml += '&nbsp;<a href="'+data[i].id+'" class="register-del" title="Delete"><i class="fa fa-trash-o"></i></a>';
                            trHtml += '</td></tr>';
                        });


                    }else{
                        trHtml += '<tr ><td colspan="11" class="text-center">No Record Found</td></tr>'
                    }
                    $("#dynamic-table tbody").html(trHtml);
                    $("ul.pagination").hide();
                    $("ul.pagination").after('<input type="button" id="updateRegFrmBtn" class="btn btn-info" value="Update"/>');

                }
            });
        }
    });

    $("a.del-stud-sub").click(function(){

        var obj = $(this);
        if(confirm('Are you sure to delete this record?, It will also delete all marks related with this subject for thsi student'))
        {
            $.ajax({
                type:"POST",
                url : BASE + 'student/del-stud-sub',
                data: {id: obj.attr('href')},
                success:function(e)
                {
                    obj.parent().parent().remove();
                }
            });
        }
        return false;
    });


    $("#registerFrm").submit(function(){
        if($("#student_subjects option:selected").length){
            return true;
        }else{
            alert("Please select subjects");
            return false;
        }

    });


    $("#updateRegFrmBtn").live('click',function(){

        $.ajax({
           type:"POST",
           url : BASE + 'student/update-class-roll',
           data: $("#updateRegFrm").serialize(),
           success:function(e)
           {
                window.location.reload();
           }
        });
    });


});
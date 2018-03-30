/**
 * Created by Tanvir Anowar on 3/19/14.
 */
$(function(){

    var classId = $("#coursePlanFrm select[name=class_id]").val();
    if(classId)
    {
        var $classObj = new Classes();
        $classObj.subjects(classId,$("#coursePlanFrm select[name=subject_id]"));
    }


    $("#markInputFrm select").each(function(){
       var obj = $(this);
        obj.change(function(){
            $("#saveMarkBtn").addClass('hidden');
        });
    });

    $("#coursePlanFrm select[name=class_id]").change(function(){
       var obj = $(this);
       var $classObj = new Classes();
       $classObj.subjects(obj.val(),$("#coursePlanFrm select[name=subject_id]"));
    });

    $("#loadTeacherBtn").click(function(){
        var classId   = $("#coursePlanFrm select[name=class_id]").val();
        var subjectId = $("#coursePlanFrm select[name=subject_id]").val();
        if(classId && subjectId)
        {
            $.ajax({
                type: "POST",
                url : BASE + 'ajax/get-assigned-teacher-by-subject',
                data: {class_id:classId, subject_id: subjectId},
                beforeSend:function()
                {
                    $("#assignedTeacherLists").removeClass('hidden');
                    $("#courseDetailsHolder").addClass('hidden');
                },
                success:function(e)
                {
                    $("#assignedTeacherLists").html(e);
                }
            });
        }

    });

    // Populate course plan Teacher , Class & Subject wise.
    $("input[name=teacher_id]").live('change',function(){
       var obj = $(this);
        var teacherId = obj.val();
        var subjectId = $("select[name=subject_id]").val();
        if(obj.attr('checked'))
        {
            $.ajax({
                type: "POST",
                url : BASE + 'ajax/get-course-plans',
                data: {teacher_id:teacherId,subject_id:subjectId},
                beforeSend:function(e)
                {
                    $("#courseDetailsHolder").removeClass('hidden');
                    $(".course-plans").html('<div class="text-center"><img src="'+BASE+'public/themes/bucket/images/ajax-loader.gif"/></div>');
                },
                success:function(e)
                {
                   $(".course-plans").html(e);
                }

            });

        }
    });

    $("#saveCPlanBtn").click(function(){
        var title = $("input[name=title]").val();
        var type = $("select[name=type]").val();
        $.ajax({
           type: "POST",
           url : BASE +  'activities/save-course-plan',
           data: $("#coursePlanFrm").serialize(),
           beforeSend:function(e){
                var htmlElm = '<div class="alert alert-success fade">';
                    htmlElm += '<strong>'+title+'</strong> <span class="label label-success label-mini">'+type+'</span>';
                    htmlElm += '</div>';
                $(".course-plans").append($(htmlElm).addClass('in').slideDown());
           },
           success:function(e){
               var data = $.parseJSON(e);
               if(data.status == 200)
               {
                   $("#myModal").removeClass('in').attr('aria-hidden','true');
                   $("input[name=title]").val('');
                   $("input[name=date]").val('');

                   window.location = data.refurl;
               }

           }
        });
        return false;
    });


    $(".bestCount").change(function(){
       var obj = $(this);
       var val = '';
       if(obj.attr('checked'))
       {
           val = 1;
       }
       else
       {
            val = '';
       }

        $.ajax({
           type:"POST",
           url : BASE + 'activities/update-best-count',
           data: {id:obj.val(),val:val},
           success:function(e)
           {
              // window.location.reload();
           }
        });
    });

    $("#markInputFrm select[name=class_id]").change(function(){
        var obj = $(this);
        var classObj = new Classes();
        classObj.sections(obj.val(),$("#markInputFrm select[name=section_id]"));
        classObj.subjects(obj.val(),$("#markInputFrm select[name=subject_id]"));
    });



        var markFrmClassId = $("#markInputFrm select[name=class_id]");
        if(markFrmClassId.val()){
            var classObj = new Classes();
            classObj.sections(markFrmClassId.val(),$("#markInputFrm select[name=section_id]"));
            classObj.subjects(markFrmClassId.val(),$("#markInputFrm select[name=subject_id]"));
        }




    $("#loadStudentForMarkBtn").click(function(){
        var obj = $(this);

        var formValidate = new SimpleValidate();
        var isOk = formValidate.isEmpty($("#markInputFrm select"),$("#markInputFrm"),'before');
        if(!isOk)
        {
            $("#markGrid").addClass('text-center').html('<h2>Please wait data loading...</h2>');
            $.ajax({
                type:"POST",
                url : BASE + 'activities/ajax-get-students-for-mark',
                data: $("#markInputFrm").serialize(),
                beforeSend:function(){
                    $("#saveMarkBtn").addClass('hidden');
                    $("#errorMsg").remove();
                    obj.after('<img id="loaderGif" style="position:relative;left:320px;top:2px;" src="'+BASE+'public/themes/bucket/images/ajax-loader.gif"/>');

                },
                success:function(e)
                {
                    $("#loaderGif").remove();
                    $("#saveMarkBtn").removeClass('hidden');
                    $("#unseen").html(e);

                    // Set default value to "0" for unassigned fields
                    $('input[type=text]').each(function(i,elm){

                        if(jQuery.isEmptyObject($(this).val()))
                        {
                            $(this).val(0);
                        }

                    });
                }
            });
        }
    });

    $(".mark").live('blur',function(){
        var pattern = /(\d+|\d+(\.\d{1,2}))/;
        var obj = $(this);
        if(pattern.test(obj.val()))
        {
            obj.css('border','1px solid green');
            obj.addClass('markAdded');
        }else
        {
            obj.css('border','1px solid red');
            obj.removeClass('markAdded');
        }

        if(obj.val() >= 0 && obj.val() <=100)
        {



        }else{
            SimpleValidate.notify('Enter Mark between 0 - 100');
            obj.removeClass('markAdded');
            obj.css('border','1px solid red');

            obj.val('');
        }
    });

    $("#saveMarkBtn").click(function(){
        var students = Array();
        var term = $("#markInputFrm select[name=term]").val();
        var classId = $("#markInputFrm select[name=class_id]").val();
        var sectionId = $("#markInputFrm select[name=section_id]").val();
        var subjectId = $("#markInputFrm select[name=subject_id]").val();
        var groupId = $("#markInputFrm select[name=group_id]").val();
        var session = $("#markInputFrm select[name=session]").val();
        var subjectName = $("#markInputFrm select[name=subject_id] option:selected").text();
        $("#errorMsg").remove();
        $(".markAdded").each(function(i,elm){
            var inputElm = $(this);
            var studentId = inputElm.attr('data-id');
            var regId = inputElm.attr('data-regid');
            var markType = inputElm.attr('data-type');
            var elmIndex = inputElm.attr('data-index');
            students.push({mark:inputElm.val(),id:studentId,regid:regId,marktype:markType,markindex:elmIndex});
        });
        $.ajax({
            type:"POST",
            url : BASE+ 'activities/ajax-save-mark',
            data:  {session:session,term:term,class:classId,section:sectionId,subject:subjectId,group:groupId,subject_name:subjectName,students:students},
            success:function(e)
            {
                console.log(e,sectionId);
                CustomMessage.printMessage(200,'Information saved',$("#markInputFrm"),'before');

            }
        });

    });



});
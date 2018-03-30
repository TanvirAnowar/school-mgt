/**
 * Created by Tanvir Anowar on 8/10/14.
 */
$(function(){
    var classElm = $("select[name=class_id]");
    var sectionElm = $("select[name=section_id]");

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
        var classElm = $("select[name=class_id]");
        var obj = $(this);
        $.ajax({
           type:"POST",
           url : BASE + 'routine/get-period',
           data: {classId:classElm.val(),sectionId:obj.val()},
           beforeSend:function(){
             $(".periods").html("");
           },
           success:function(e)
           {
               if(e.get_period != undefined)
               {


               var periodDetails = e.get_period.period_details;

               var periodsInfo = e.periods;


               var day = ['Sat','Sun','Mon','Tue','Wed','Thu','Fri'];
               var data = $.parseJSON(periodDetails);

               var periodCount = data.periodCount;
               var start = data.start;
               var end = data.end;
               var htmlTag = '';

               for(d in day)
               {
                   htmlTag += '<div class="col-lg-12">';
                   htmlTag += '<div class="col-lg-2 inline-block">'+day[d]+'</div>';
                   htmlTag += '<div class="col-lg-10">';
                   for($i=1; $i<=periodCount; $i++)
                   {
                       var teacher ='';
                       var subject='';
                       var routine='';
                       if((periodsInfo != undefined))
                       {
                           var $k = day[d]+'_'+$i;
                           teacher = periodsInfo[$k].teacher;
                           subject = periodsInfo[$k].subject;
                           routine = periodsInfo[$k].routine;

                       }
                          // var teacher = $.parseJSON(e.periods.day[d]+'_'+$i.teacher);
                          // var subject = $.parseJSON(e.periods.day[d]+'_'+$i.subject);
                           htmlTag += '<div class="periodGrid">';
                           if((routine != undefined))
                           {
                               htmlTag += '<a onclick="return false;" class="deleteRoutine" href="'+routine.routine_id+'">X</a>';
                           }
                           htmlTag += '<h4 class="text-center">P:'+$i+' ('+start[$i-1]+'-'+end[$i-1]+')</h4>';
                           htmlTag += '<div id="'+$i+'" data-day="'+day[d]+'" class="cell">';
                           htmlTag += '<label class="col-xs-1" style="width:100%;">T : '+((teacher)? teacher.name_initial : '')+'</label>';
                           htmlTag += '<label class="col-xs-1" style="width:100%;">S : '+((subject)? subject.subject_name : '')+'</label>';
                           htmlTag += '</div></div>';

                   }
                   htmlTag += '</div></div>';
               }
               $("div.periods").html(htmlTag);
               }

           }
        });
    });

    $("body").on('click','div.cell',function(){
        var obj = $(this);

        var classElm = $("select[name=class_id]");

        var teacherCell = obj.children().eq(0);
        var subjectCell = obj.children().eq(1);

        $('div.cell').removeClass('selected');
        $('div.cell').children().css('background-color','transparent');
        obj.addClass('selected');
        teacherCell.css('background-color','#DBEEFF');
        subjectCell.css('background-color','#DBEEFF');
        var htmlTag = '';
        $.ajax({
           type:"POST",
           url : BASE + 'ajax/get-class-wise-subject',
           data:{class_id:classElm.val()},
           success:function(e)
           {

               var data = $.parseJSON(e);
               htmlTag += '<div id="dialogBox" class="form-horizontal col-lg-6">' +
                   '<div class="form-group col-lg-12">' +
                   '<label>Subject</label>' +
                   '<select class="form-control" id="Subject" name="subject"><option value="">--SELECT--</option>';
               for(i in data){
                    htmlTag += '<option value="'+data[i].subject_id+'">'+data[i].subject_name+'</option>';
               }
               htmlTag +='</select>'+
                   '</div>' +
                   '<div id="subjectTeacherList" class="form-group col-lg-12 hidden">' +
                   '<label>Teacher</label>'+
                   '<select class="form-control" id="Teacher" name="teacher">' +
                   '</select>'+
                   '</div>' +
                   '<div class="form-group col-lg-12">' +
                   '<input type="hidden" name="period_no" value="'+obj.attr('id')+'"/>'+
                   '<input type="hidden" name="period_day" value="'+obj.attr('data-day')+'"/>'+
                   '<input class="btn btn-primary" type="button" id="saveClassRoutineBtn" name="saveClassRoutineBtn" value="Save"/> ' +
                   '<input class="btn btn-info" type="button" id="cancelClassRoutineBtn" name="cancelClassRoutineBtn" value="Cancel"/>' +
                   '</div>'+
                   '</div>';

               $("#dialogBox").remove();

               obj.parent().append(htmlTag);

           }
        });

    });

    $("body").on('change', "#Subject", function(event){

        var selectItem = $("select[name=subject] option:selected").val();

        $.ajax({
            type:"POST",
            url : BASE+'routine/getAssignedTeacherBySubject',
            data: {'subject_id':selectItem},
            success:function(e)
            {
                var htmlTag = '<option value="">--SELECT--</option>';
                for(i in e){

                    htmlTag += '<option value="'+i+'">'+e[i].name+'</option>';
                }
                $("select[name=teacher]").html(htmlTag);
                $("#subjectTeacherList").removeClass('hidden');
            }
        });
    });


    $("body").on('click', "#saveClassRoutineBtn", function(){
        var obj = $(this);
        var Subject = $("select[name=subject] option:selected").text();
        var Teacher = $("select[name=teacher] option:selected").text();
        var teacherField = obj.parent().parent().prev().children().eq(0);
        var subjectField = obj.parent().parent().prev().children().eq(1);
        $.ajax({
            type:"POST",
            url : BASE+'routine/save-schedule',
            data: $("#classRoutineFrm").serialize(),
            success:function(e)
            {
                subjectField.html('S : '+Subject);
                teacherField.html('T : '+Teacher);
                alert(e.msg);
                $("#dialogBox").remove();
            }
        });
    });

    $("body").on('click', "#cancelClassRoutineBtn", function(){
        $("#dialogBox").remove();
    });

    $("body").on('click','a.deleteRoutine',function(){
        var obj = $(this);
        if(confirm("Are you sure to delete this Schedule ?"))
        {
            $.ajax({
                type:"POST",
                url : BASE + 'routine/delete-schedule',
                data: {routineId:obj.attr('href')},
                success:function(e)
                {
                    obj.next().next().children().eq(0).html('T : ');
                    obj.next().next().children().eq(1).html('S : ');
                    obj.remove();
                }
            })
        }

    });
});
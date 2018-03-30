/**
 * Created by Tanvir Anowar on 4/15/14.
 */
$(function(){
    var addTaskFrmClassElm = $("#addTaskFrm select[name=class_id]");
    var editTaskFrmClassElm = $("#editTaskFrm select[name=class_id]");
    var sectionElm = $("#addTaskFrm select[name=section_id]");
    var taskDateElm = $("input[name=task_date]");

    var textArea = $("textarea[maxlength]").val();
    var countMsg1;
    if(textArea)
        countMsg1 =  textArea.length;
    $("span#countMsg").text(countMsg1);

    $("textarea[maxlength]").bind('input propertychange', function() {
        var maxLength = $(this).attr('maxlength');
        var countMsg = 0;

        checkValidChars($(this));

        if ($(this).val().length > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
        }
        var newCount = countMsg + $(this).val().length;
        var smsCount = 1;

        smsCount = ' Sms Count ('+Math.ceil(newCount/160)+')';

        $("#single_smsCount").text(smsCount);
        $("span#countMsg").text(newCount);
    });

    getSection(addTaskFrmClassElm);

    addTaskFrmClassElm.change(function(){
        var obj = $(this);
        getSection(obj)
    });

    editTaskFrmClassElm.change(function(){

        var obj = $(this);
        var classObj = new Classes();
        classObj.sections(obj.val(),$("#editTaskFrm select[name=section_id]"));
    })


    taskDateElm.datepicker();

    $(".delete-task").live('click',function(){
        var obj = $(this);

        if(confirm('Are you sure to delete this task ?'))
        {
            $.ajax({
               type:"POST",
               url : BASE + 'activities/delete-task',
               data: { task_id : obj.attr('href')},
               beforeSend:function()
               {
                   obj.parent().parent().hide();
                   $(".alert").remove();
               },
               success:function(e){
                   var data = $.parseJSON(e);

                            var elm = $("section.wrapper").children().eq(0);
                            console.log(e);
                            CustomMessage.printMessage(data.status,data.msg,elm,'before');

               }
            });
        }
        return false;
    });


    function getSection(classElm)
    {
        if(classElm.val())
        {
            var classObj = new Classes();
            classObj.sections(classElm.val(),sectionElm);
        }
    }

    function checkValidChars(obj)
    {
        var pattern = /(#|&)/

        if(pattern.test(obj.val()))
        {
            obj.val(obj.val().replace(pattern, " "));
            //obj.val(obj.val().substring(0,(obj.val().length-1)));
            return 1;
        }
        return 0;
    }

});
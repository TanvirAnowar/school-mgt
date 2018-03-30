/**
 * Created by Tanvir Anowar on 6/25/14.
 */
$(function(){
    $("#presentChk,#absentChk").change(function(){
       var obj = $(this);
       var $typeValue = "";
       if(obj.attr('checked'))
       {
            $typeValue = 1;
       }else{
           $typeValue = 0;
       }
       $.ajax({
            type: "POST",
            url : BASE + 'school/update-attendance-option',
            data: {type:$typeValue,field:obj.attr('name')},
            success:function(e)
            {
                //console.log(e);
            }
       });
    });

    $("input[name=app-mode]").change(function(){
        var obj = $(this);
            var appMode = '';
        if(obj.attr('checked'))
        {
            appMode = 1;
        }else{
            appMode = 0;
        }
        $.ajax({
            type:"POST",
            url : BASE+ 'school/change-app-mode',
            data: {appmode:appMode},
            success:function(e)
            {
                // console.log(e)
            }
        });
    });

});
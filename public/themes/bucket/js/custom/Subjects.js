/**
 * Created by Tanvir Anowar on 3/10/14.
 */
var Subjects = function(){};

Subjects.prototype.optionalSubjects = function(classId,groupId,elm)
{
    $.ajax({
        type:"POST",
        url : BASE+'ajax/get-optional-subjects',
        data: {class_id:classId,group_id:groupId},
        beforeSend:function()
        {
            elm.html("");
        },
        success:function(e)
        {

            console.log(elm);
            var data = $.parseJSON(e);

            if(data.length)
            {
                var optionHtml = '';
                $.each(data,function(i,el){
                    optionHtml += '<option value="'+data[i].subject_id+'">'+data[i].subject_name+'</option>';
                });
                elm.html(optionHtml);
                elm.removeAttr('disabled');
            }
        }
    });

}
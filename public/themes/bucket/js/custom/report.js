/**
 * Created by Tanvir Anowar on 5/13/14.
 */
$(function(){

    var classElm = $("#getReportFrm select[name=class_id]");
    if(classElm.val())
    {
        var classObj = new Classes();
        classObj.sections(classElm.val(),$("#getReportFrm select[name=section_id]"));
    }

    $("#selectAll").removeAttr('checked');



    $("#loadStudent").click(function(){

        $.ajax({
           type:"POST",
           url : BASE + 'ajax/get-registered-student',
           data: $("#getReportFrm").serialize(),
           success:function(e)
           {
                var trHtml = '';
                var data = $.parseJSON(e);

               if(data.length)
               {
                   $.each(data,function(i,el){
                       trHtml +=  '<tr>';
                       trHtml +=    '<td><input type="checkbox" value="'+data[i].sid+'" class="student-report" name="student[]"/></td>';
                       trHtml +=    '<td>'+data[i].name+'</td>';
                       trHtml +=    '<td>'+data[i].reg_id+'</td>';
                       trHtml +=    '<td>'+data[i].class_roll+'</td>';
                       trHtml += '</tr>';
                   });
                    $("table.studentReportList tbody").html(trHtml);
                   $("#viewAllReport").removeClass('hidden');

               }

           }
        });
        return false;
    });
    $("#selectAll").change(function(){
        var obj = $(this);
        if(obj.attr('checked'))
        {
            $(".student-report").attr('checked','checked');
        }else{
            $(".student-report").removeAttr('checked');
        }
    });

    $("#getReportFrm").submit(function(){

       if($(".student-report:checked").length > 0)
        {
            return true;
        }else{
           alert('Please Select Student');
           return false;
        }
    });
});
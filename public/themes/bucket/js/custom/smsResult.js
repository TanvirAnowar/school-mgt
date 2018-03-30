/**
 * Created by Tanvir AnowarC51 on 12/21/14.
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

    $("#loadStudent").click(function(){
        var obj = $(this);
        var session = $("select[name=session]").val();
        var classId = $("select[name=class_id]").val();
        var sectionId = $("select[name=section_id]").val();
        var term = $("select[name=term]").val();

        // for manual system
        if(session && classId && sectionId){
            $.ajax({
                type:"POST",
                url : BASE + 'activities/get-student-result',
                data: { session:session, class_id:classId, section_id:sectionId,term:term},
                beforeSend:function()
                {

                    $("#loader").remove();
                    obj.after('<div id="loader" class="text-center"><img src="'+BASE+'public/themes/bucket/images/ajax-loader.gif"/></div>');
                },
                success:function(e)
                {
                    $("#loader").remove();
                    var data = $.parseJSON(e);

                    var results = $.parseJSON(data.results);
                    if(results.length)
                    {
                        //console.log(e);
                        var trHtml = '';
                        $.each(results,function(i,elm){

                            trHtml += '<tr>';
                            trHtml += '<td>'+(i+1)+'</td>';
                            trHtml += '<td><input type="hidden" name="reg_id[]" value="'+results[i].student.id+'"/>'+results[i].student.name+'</td>';
                            trHtml += '<td>'+results[i].student.get_class.class_name+', Section:'+results[i].student.get_section.section_name+'</td>'
                            trHtml += '<td>'+results[i].class_roll+'</td>';
                            var result = $.parseJSON(results[i].mark_info);

                            var resultTxt = '';
                            for(subject in result.subjects)
                            {
                                resultTxt += subject.substring(0,3) + ':' + result.subjects[subject].subject_total+" ";

                            }
                            resultTxt = resultTxt + "CGPA : " + result.cgpa;
                            var studentResult = results[i].student.name + ", Roll:" + results[i].class_roll + ", Results:" + resultTxt;
                            /*console.log(resultTxt);*/
                                    trHtml += '<td><input type="hidden" name="sms_result['+results[i].student.id+']" value="'+studentResult+'"/>'+resultTxt+'</td>';



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

    $("#sendAttendanceSms").click(function(){
        var students = $(".attendance_grid tbody").children();

        if(students.length){
            if(confirm('Are you sure to send result SMS?'))
            {

                $.ajax({
                    type:"POST",
                    url : BASE + 'sms/send-result-sms',
                    data: $("#addSmsResultFrm").serialize(),
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

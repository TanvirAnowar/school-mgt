/**
 * Created by Tanvir Anowar on 3/4/14.
 */
$(function(){

    $("select[name=class_id]").change(function(){
       var obj = $(this);
       var classObj = new Classes();
       classObj.sections(obj.val(),$("select[name=section_id]"));
    });

    $("#searchStudentBtn").click(function(){
        $.ajax({
            type:"POST",
            url : BASE+'ajax/search-student',
            data:{search_txt:$("#searchStudentTxt").val()},
            success:function(e)
            {
                var data = $.parseJSON(e);
                var trHtml = '';
                $.each(data,function(i,el){
                    trHtml += '<tr class="gradeX">';
                    trHtml += '<td>'+(i+1)+'</td>';
                    trHtml += '<td>'+data[i].id+'</td>';
                    trHtml += '<td>'+data[i].student_id+'</td>';
                    trHtml += '<td>'+data[i].name+'</td>';
                    trHtml += '<td>'+data[i].father_name+'</td>';
                    trHtml += '<td>'+data[i].mother_name+'</td>';
                    trHtml += '<td>'+data[i].dob+'</td>';
                    if(data[i].father_cell_phone)
                        trHtml += '<td>'+data[i].father_cell_phone+'</td>';
                    else
                        trHtml += '<td>'+data[i].mother_cell_phone+'</td>';
                    trHtml += '<td class="center hidden-phone">';
                    trHtml += '<a href="'+BASE+'student/edit/'+data[i].id+'" class="grid-action-link"><i class="fa fa-pencil" title="Edit"></i></a>';
                    trHtml +=  '<a href="'+BASE+'student/view/'+data[i].id+'" class="grid-action-link"><i class="fa fa-eye" title="View Details"></i></a>';
                    trHtml +=  '<a href="'+data[i].id+'" class="grid-action-link delete-student"><i class="fa fa-trash-o" title="Delete"></i></a>';
                    trHtml  += '</td></tr>';
                });

                $(".searchStudentTable tbody").html(trHtml);

            }

        });

    });

    $("#studentSearchForm").submit(function(){
        $.ajax({
            type:"POST",
            url : BASE+'ajax/search-student',
            data:{search_txt:$("#searchStudentTxt").val()},
            success:function(e)
            {
                var data = $.parseJSON(e);
                var trHtml = '';
                $.each(data,function(i,el){
                    trHtml += '<tr class="gradeX">';
                    trHtml += '<td>'+(i+1)+'</td>';
                    trHtml += '<td>'+data[i].id+'</td>';
                    trHtml += '<td>'+data[i].student_id+'</td>';
                    trHtml += '<td>'+data[i].name+'</td>';
                    trHtml += '<td>'+data[i].father_name+'</td>';
                    trHtml += '<td>'+data[i].mother_name+'</td>';
                    trHtml += '<td>'+data[i].dob+'</td>';
                    if(data[i].father_cell_phone)
                        trHtml += '<td>'+data[i].father_cell_phone+'</td>';
                    else
                        trHtml += '<td>'+data[i].mother_cell_phone+'</td>';
                    trHtml += '<td class="center hidden-phone">';
                    trHtml += '<a href="'+BASE+'student/edit/'+data[i].id+'" class="grid-action-link"><i class="fa fa-pencil" title="Edit"></i></a>';
                    trHtml +=  '<a href="'+BASE+'student/view/'+data[i].id+'" class="grid-action-link"><i class="fa fa-eye" title="View Details"></i></a>';
                    trHtml +=  '<a href="'+data[i].id+'" class="grid-action-link delete-student"><i class="fa fa-trash-o" title="Delete"></i></a>';
                    trHtml  += '</td></tr>';
                });

                $(".searchStudentTable tbody").html(trHtml);

            }

        });
        return false;
    });

    $("#saveAdmitFrm").submit(function(){
        var mobile_number = $("input[name=mobile_number]").val();
        var phone = $("input[name=phone]").val();
        var pattern = /^[0-9]*$/

        if(mobile_number)
        {
            if(!pattern.test(mobile_number))
            {
                alert('Please enter only number');
                return false;
            }
        }

        if(phone)
        {
            if(!pattern.test(phone))
            {
                alert('Please enter only number');
                return false;
            }
        }
    });

    $("studentAddForm").submit(function(){
        var father_cell_phone = $("input[name=father_cell_phone]").val();
        var mother_cell_phone = $("input[name=mother_cell_phone]").val();
        var pattern = /^[0-9]*$/

        if(father_cell_phone)
        {
            if(!pattern.test(father_cell_phone))
            {
                alert('Please enter only number');
                return false;
            }
        }

        if(mother_cell_phone)
        {
            if(!pattern.test(mother_cell_phone))
            {
                alert('Please enter only number');
                return false;
            }
        }
    });

    $(".delete-student").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to delete this record ?')){
            $.ajax({
                type:"POST",
                url : BASE+'student/delete',
                data: {id:obj.attr('href')},
                success:function(e)
                {
                    var data = $.parseJSON(e);
                    if(data.status == 200)
                    {
                        obj.parent().parent().remove();
                        window.location = BASE+'student/lists';
                    }
                }
            });
        }

        return false;
    });

    $(".terminate-student").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to Permanently delete this record ?')){
            $.ajax({
                type:"POST",
                url : BASE+'student/terminate',
                data: {id:obj.attr('href')},
                success:function(e)
                {
                    var data = $.parseJSON(e);
                    if(data.status == 200)
                    {
                        obj.parent().parent().remove();
                        window.location = BASE+'student/trash';
                    }
                }
            });
        }

        return false;
    });
});



var Student = function(){}

Student.prototype.getNewStudent = function(classId,studentType,elm)
{


    $.ajax({
        type:"POST",
        url : BASE + 'ajax/get-unregistered-student',
        data: {class_id:classId,student_type:studentType},
        beforeSend:function(){
            elm.html('<tr><td colspan="6" class="text-center">Please wait, information loading</td></tr>');

        },
        success:function(e)
        {

            var data = $.parseJSON(e);

            if(data.length)
            {
                $("#dynamic-table tbody").children().remove(); // remove old table tbody children

                var dataTable = elm.parent().dataTable({
                    "bRetrieve": true,                  // retrieve old initiated dataTable object
                    "aoColumns": [                      // init with null value base on number of column need to show
                        {'bSortable':false},
                        null,
                        null,
                        null,
                        null,
                        {'bSortable':false}

                    ]
                });

                var oSettings = dataTable.fnSettings(); // get current settings of dataTable
                dataTable.fnClearTable(this);           // clear current dataTable data source


                $.each(data,function(i,el){

                   var trHtmlAction = '';
                   var trHtmlCheckBox = '<input type="checkbox" class="select-check" name="student[]" value="'+data[i].id+'"/>';


                    trHtmlAction += '<td class="center hidden-phone">';
                    trHtmlAction += '<input type="text" class="form-control" name="class_roll[]" value="'+(i+1)+'"/>';
                    trHtmlAction += '</td>';


                    var result = [trHtmlCheckBox,data[i].session,data[i].name,data[i].class_name,data[i].section_name,trHtmlAction];

                    dataTable.oApi._fnAddData(oSettings,result);  // add row as array

                });

                oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();  // reinitialize settings for sort, pagination
                dataTable.fnDraw();                                     // redraw grid

            }
            else
            {
                trHtml = '<tr><td colspan="6" class="text-center">No Record Found</td></tr>';
                elm.html(trHtml);
            }
        }
    });
}

Student.prototype.getRunningStudent = function(classId,studentType,elm)
{
    $.ajax({
        type:"POST",
        url : BASE + 'ajax/get-unregistered-student',
        data: {class_id:classId,student_type:studentType},
        beforeSend:function(){
            elm.html('<tr><td colspan="6" class="text-center">Please wait, information loading</td></tr>');

            if(elm.children().length>1)
            {
                elm.parent().fnClearTable();
            }
        },
        success:function(e)
        {


            var data = $.parseJSON(e);

            if(data.length)
            {
                $("#dynamic-table tbody").children().remove(); // remove old table tbody children



                var dataTable = elm.parent().dataTable({
                    "bRetrieve": true,                  // retrieve old initiated dataTable object
                    "aoColumns": [                      // init with null value base on number of column need to show
                        {'bSortable':false},
                        null,
                        null,
                        null,
                        null,
                        {'bSortable':false}

                    ]
                });

                var oSettings = dataTable.fnSettings(); // get current settings of dataTable
                dataTable.fnClearTable(this);           // clear current dataTable data source

                $.each(data,function(i,el){

                    var trHtmlAction = '';
                    var trHtmlCheckBox = '<input type="checkbox" class="select-check" name="student[]" value="'+data[i].id+'"/>';


                    trHtmlAction += '<td class="center hidden-phone">';
                    trHtmlAction += '<input type="text" class="form-control" name="class_roll[]" value="'+(i+1)+'"/>';
                    trHtmlAction += '</td>';


                    var result = [trHtmlCheckBox,data[i].session,data[i].name,data[i].class_name,data[i].section_name,trHtmlAction];

                    dataTable.oApi._fnAddData(oSettings,result);  // add row as array
                });

                oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();  // reinitialize settings for sort, pagination
                dataTable.fnDraw();                                      // redraw grid

            }else{
                trHtml = '<tr><td colspan="6" class="text-center">No Record Found</td></tr>';
                elm.html(trHtml);
            }
        }
    });


}
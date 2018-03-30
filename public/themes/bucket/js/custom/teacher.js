/**
 * Created by Tanvir Anowar on 3/4/14.
 */
$(function(){
   $("#searchTeacherBtn").click(function(){
       $.ajax({
           type:"POST",
           url : BASE+'ajax/search-teacher',
           data:{search_txt:$("#searchTeacherTxt").val()},
           success:function(e)
           {
               var data = $.parseJSON(e);
               var trHtml = '';
                   $.each(data,function(i,el){
                       trHtml += '<tr class="gradeX">';
                       trHtml += '<td>'+(i+1)+'</td>';
                       trHtml += '<td>'+data[i].name_initial+'</td>';
                       trHtml += '<td>'+data[i].name+'</td>';
                       trHtml += '<td>'+data[i].cell_phone+'</td>';
                       trHtml += '<td>'+data[i].email+'</td>';
                       trHtml += '<td class="center hidden-phone">';
                       trHtml += '<a href="'+BASE+'teacher/edit/'+data[i].id+'" class="grid-action-link"><i class="fa fa-pencil" title="Edit"></i></a>';
                       trHtml +=  '<a href="'+BASE+'teacher/view/'+data[i].id+'" class="grid-action-link"><i class="fa fa-eye" title="View Details"></i></a>';
                       trHtml +=  '<a href="'+data[i].id+'" class="grid-action-link delete-teacher"><i class="fa fa-trash-o" title="Delete"></i></a>';
                       trHtml  += '</td></tr>';
               });

            $(".searchTeacherTable tbody").html(trHtml);

           }

       });
       return false;
   });

    $("#teacherSearchForm").submit(function(){

        $.ajax({
            type:"POST",
            url : BASE+'ajax/search-teacher',
            data:{search_txt:$("#searchTeacherTxt").val()},
            success:function(e)
            {
                var data = $.parseJSON(e);
                var trHtml = '';
                $.each(data,function(i,el){
                    trHtml += '<tr class="gradeX">';
                    trHtml += '<td>'+(i+1)+'</td>';
                    trHtml += '<td>'+data[i].name_initial+'</td>';
                    trHtml += '<td>'+data[i].name+'</td>';
                    trHtml += '<td>'+data[i].cell_phone+'</td>';
                    trHtml += '<td>'+data[i].email+'</td>';
                    trHtml += '<td class="center hidden-phone">';
                    trHtml += '<a href="'+BASE+'teacher/edit/'+data[i].id+'" class="grid-action-link"><i class="fa fa-pencil" title="Edit"></i></a>';
                    trHtml +=  '<a href="'+BASE+'teacher/view/'+data[i].id+'" class="grid-action-link"><i class="fa fa-eye" title="View Details"></i></a>';
                    trHtml +=  '<a href="'+data[i].id+'" class="grid-action-link delete-teacher"><i class="fa fa-trash-o" title="Delete"></i></a>';
                    trHtml  += '</td></tr>';
                });

                $(".searchTeacherTable tbody").html(trHtml);

            }

        });
        return false;
    });

    $("#teacherAddForm").submit(function(){
        var mobile_number = $("input[name=cell_phone]").val();
        var age = $("input[name=age]").val();
        var pattern = /^[0-9]*$/

        if(age)
        {
            if(!pattern.test(age))
            {
                alert('Please enter only number for Age');
                return false;
            }
        }

        if(mobile_number)
        {
            if(!pattern.test(mobile_number))
            {
                alert('Please enter only number for Cell phone');
                return false;
            }
        }


    });

    $(".delete-teacher").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to delete this record ?')){
            $.ajax({
                type:"POST",
                url : BASE+'teacher/delete',
                data: {id:obj.attr('href')},
                success:function(e)
                {
                    var data = $.parseJSON(e);
                    if(data.status == 200)
                    {
                        obj.parent().parent().remove();
                        window.location = BASE+'teacher/lists';
                    }
                }
            });
        }

        return false;
    });

    $(".terminate-teacher").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to Permanently delete this record ?')){
            $.ajax({
                type:"POST",
                url : BASE+'teacher/terminate',
                data: {id:obj.attr('href')},
                success:function(e)
                {
                    var data = $.parseJSON(e);
                    if(data.status == 200)
                    {
                        obj.parent().parent().remove();
                        window.location = BASE+'teacher/trash';
                    }
                }
            });
        }

        return false;
    });

    $(".restore-teacher").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to restore this record ?')){
            $.ajax({
                type:"POST",
                url : BASE+'teacher/restore',
                data: {id:obj.attr('href')},
                beforeSend:function()
                {
                    obj.parent().parent().hide();
                },
                success:function(e)
                {
                    console.log(e);
                    var data = $.parseJSON(e);
                    if(data.status == 200)
                    {
                        obj.parent().parent().remove();
                        window.location = BASE+'teacher/trash';
                    }
                }
            });
        }

        return false;
    });
});
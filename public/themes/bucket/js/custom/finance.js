/**
 * Created by Tanvir AnowarC51 on 12/30/14.
 */
$(function(){
    $("select[name='template']").children().eq(0).attr('selected','selected');
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

    $("#searchRegStudent").click(function(){
        var obj = $(this);
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
                    $("#dynamic-table tbody").html('<tr><td colspan="11" class="text-center"><img src="'+BASE+'public/themes/bucket/images/ajax-loader.gif"/></td></tr>');
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
                            /*trHtml += '<td><span  style="width:20px;">'+data[i].student_id+'</span></td>';*/
                            trHtml += '<td>'+data[i].session+'</td>';
                            trHtml += '<td>'+data[i].name+'</td>';
                            trHtml += '<td>'+phoneNo+'</td>'
                            trHtml += '<td>'+data[i].class_name+'</td>';
                            trHtml += '<td>'+data[i].section_name+'</td>';
                            trHtml += '<td>'+data[i].shift_name+'</td>';
                            trHtml += '<td>'+data[i].group_name+'</td>';
                            trHtml += '<td>'+data[i].class_roll+'</td>';
                            trHtml += '<td>';
                           /* trHtml += '<a href="'+BASE+'student/register/edit/'+data[i].id+'" title="Edit" class="register-edit"><i class="fa fa-pencil"></i></a>';
                            trHtml += '&nbsp;<a href="'+BASE+'student/view/'+data[i].sid+'" title="Profile" class="register-view"><i class="fa fa-user"></i></a>';*/
                            trHtml += '&nbsp;<a href="'+BASE+'finance/invoice/student/'+data[i].reg_id+'" title="View" class="register-view"><i class="fa fa-eye"></i></a>';
                            /*trHtml += '&nbsp;<a href="'+data[i].id+'" class="register-del" title="Delete"><i class="fa fa-trash-o"></i></a>';*/
                            trHtml += '</td></tr>';
                        });


                    }else{
                        trHtml += '<tr ><td colspan="11" class="text-center">No Record Found</td></tr>'
                    }
                    $("#dynamic-table tbody").html(trHtml);
                    $("ul.pagination").hide();
                   // $("ul.pagination").after('<input type="button" id="updateRegFrmBtn" class="btn btn-info" value="Update"/>');

                }
            });
        }
    });

    $("body").on("keydown",".amount",function(event){
       var obj = $(this);
       var itemCount = $("#transaction_list tbody").children().length;
       var nextRow = obj.parent().parent().next().length;

       if(event.keyCode == 13 && (nextRow  == 0))
       {
           itemCount = (itemCount + 1);
           var slNo = (itemCount < 10) ? '0'+itemCount : itemCount;
            var tr = '<tr>' +
                '<td>'+slNo+'</td>' +
                '<td>' +
                '   <select class="form-control" name="head[]">';
               for(i in heads){
                   tr += '<option class="'+heads[i].head_name+'">'+heads[i].head_name+'</option>';
               }
               tr += '</select>' +
                   '</td>' +
                   '<td><input class="form-control input-large" name="ref_no[]" type="text"/></td>' +
                   '<td><input class="form-control input-large" name="description[]" type="text"/></td>' +
                   '<td><input class="amount form-control input-mini text-right" name="amount[]" type="text"/></td>' +
                   '<td><button type="button" class="btn btn-danger remove_transaction_row">Remove</button></td>' +
                   '</tr>';
            $("#transaction_list tbody").append(tr);

       }



    });

    $("body").on('keyup','.amount',function(){
        var obj = $(this);
        var pattern = /[0-9]/
        var txt = obj.val().toString();

        if(txt.match(pattern) == null)
        {
           obj.attr("placeholder","Amount must be in numbers");
           obj.val('');
        }
    });

    $("body").on("click",".remove_transaction_row",function(){
       var obj = $(this);
       obj.parent().parent().remove();
    });

    $("#save_std_transaction").click(function(){
        var obj = $(this);
        $.ajax({
          type:"POST",
          url : $("#stdTransactionFrm").attr('action'),
          data: $("#stdTransactionFrm").serialize(),
          beforeSend:function()
          {
            obj.attr('disabled','disabled');
          },
          success:function(e)
          {
            window.location = e;
            obj.removeAttr('disabled');
          }
        });
    });

    $('select[name="template"]').change(function(){
        var obj = $(this);
        $.ajax({
            type:"POST",
            url : BASE+'finance/get-template',
            data:{id:obj.val(),type:$("#type").val()},
            beforeSend:function(){
                $("#transaction_list body").html('<tr><td class="text-center" cospan="6">Loading...</td></tr>');
            },
            success:function(e)
            {
                $("#transaction_list tbody").html(e);
            }
        });
    });
});
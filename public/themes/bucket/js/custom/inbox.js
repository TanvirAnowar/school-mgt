/**
 * Created by Tanvir Anowar on 7/9/14.
 */
$(function(){
    $("select[name=to]").change(function(){
        var obj = $(this);
        var selectedText = obj.find('option:selected').text();
        var liElm = '';
        liElm += '<li>';
        liElm += '<div class="item">';
        liElm += '<input type="hidden" name="users[]" value="'+obj.val()+'"/> '+selectedText+' ';
        liElm += '<a class="removeReceiver" href="#">X</a></div>';
        liElm += '</li>';
        $("#userlist ul").append(liElm);
        $("#select2-chosen-2").text('');

    });

    $("body").on('click','a.removeReceiver',function(){
        var obj = $(this);
        obj.parent().parent().remove();
    });

    $("input[name=selectAll]").change(function(){
        var obj = $(this);

        if(obj.attr('checked'))
        {
            $("input.message_id").attr('checked','checked');
        }else{
            $("input.message_id").removeAttr('checked');
        }
    });

    $("#bulkDeleteBtn").click(function(){
        var bulkAction = $("select[name=bulk_action]").val();
        if(bulkAction == 'Delete')
        {
            var recorExist = $("input.message_id:checked").length;
            if(recorExist)
            {
                if(confirm('Are you sure to delete?'))
                {

                    $.ajax({
                        type : "POST",
                        url  : BASE + 'inbox/bulk-delete-comment',
                        data : $("#bulkOpFrm").serialize(),
                        success:function(e)
                        {
                            $("input.message_id:checked").parent().parent().remove();
                        }
                    });
                }

            }else{

                alert('Please Select Messages');

            }
        }else{
            alert("Please Select Operation");
        }
        return false;
    });

    $("#bulkSentItemsDeleteBtn").click(function(){
        var bulkAction = $("select[name=bulk_action]").val();
        if(bulkAction == 'Delete')
        {
            var recorExist = $("input.message_id:checked").length;
            if(recorExist)
            {
                if(confirm('Are you sure to delete?'))
                {
                    $.ajax({
                        type : "POST",
                        url  : BASE + 'inbox/bulk-delete-message',
                        data : $("#bulkOpFrm").serialize(),
                        success:function(e)
                        {
                            $("input.message_id:checked").parent().parent().remove();
                        }
                    });
                }
            }else{

                alert('Please Select Messages');

            }
        }else{
            alert("Please Select Operation");
        }
    });
});
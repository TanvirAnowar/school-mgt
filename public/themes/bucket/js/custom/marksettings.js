/**
 * Created by Tanvir Anowar on 4/28/14.
 */
$(function(){

    $("#markFrm select[name=class_id]").change(function(){
        var obj = $(this);
        var classes = new Classes();

        classes.nonDependendSubjects(obj.val(),$("select[name=subject_id]"));
    });

    $(".edit-mark-type").click(function(){
        var $editMarkTypeFrm = $("#editMarkTypeFrm");
        var obj = $(this);
        var $prevValue = obj.parent().siblings().eq(1).text();
        console.log($prevValue);
        var markTypeId = obj.attr('data-marktype-id');
        $editMarkTypeFrm.find('input[name=mark_type]').val($prevValue);
        $editMarkTypeFrm.find('input[name=mark_type_id]').val(markTypeId);
    });

    $(".delete-mark-settings").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to delete this record ?'))
        {
            $.ajax({
                type:"POST",
                url : BASE + 'settings/delete-mark-setting',
                data:{id:obj.attr('href')},
                beforeSend:function()
                {
                    obj.parent().parent().hide();
                },
                success:function(e){
                    var data = $.parseJSON(e);
                    if(data.status == 200)
                    {
                        obj.parent().parent().remove();

                    }
                }
            });
        }
        return false;
    });

    $(".delete-trash-mark-settings").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to delete this record ?'))
        {
            $.ajax({
                type:"POST",
                url : BASE + 'settings/delete-trash-mark-setting',
                data:{id:obj.attr('href')},
                beforeSend:function()
                {
                    obj.parent().parent().hide();
                },
                success:function(e){
                    var data = $.parseJSON(e);
                    if(data.status == 200)
                    {
                        obj.parent().parent().remove();

                    }
                }
            });
        }
        return false;
    });

    $(".undo-delete-mark-settings").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to retrieve this record'))
        {

            $.ajax({
                type:"POST",
                url : BASE + 'settings/undo-delete-mark-setting',
                data:{id:obj.attr('href')},
                beforeSend:function()
                {
                    obj.parent().parent().hide();
                },
                success:function(e){
                    var data = $.parseJSON(e);
                    if(data.status == 200)
                    {
                        obj.parent().parent().remove();
                       // window.location.reload();
                    }
                }
            });

        }
        return false;
    });

    $("#clearTrashFrm").submit(function(){
        if(confirm('Are you sure to clear trash?'))
        {
            return true;
        }else{
            return false;
        }
    });
});
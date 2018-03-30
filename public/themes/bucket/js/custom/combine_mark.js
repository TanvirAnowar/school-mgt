/**
 * Created by Tanvir Anowar on 4/23/14.
 */
$(function(){
    var classElm = $("select[name=class_id]");
    if(classElm.val())
    {
        var classObj = new Classes();
        classObj.dependedSubject(classElm.val(),$("#combineMarkSettingsForm select#subject_id"));
    }

    $("#combineMarkSettingsForm select[name=class_id]").change(function(){
        var obj = $(this);
        var classObj = new Classes();
        classObj.dependedSubject(obj.val(),$("#combineMarkSettingsForm select#subject_id"));
    });

    $(".delete-combine-mark-settings").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to delete this mark Settings ?'))
        {
            $.ajax({
                type:"POST",
                url : BASE + 'settings/delete-combine-mark',
                data: { id : obj.attr('href')},
                beforeSend:function()
                {
                    obj.parent().parent().hide();
                },
                success:function(e)
                {
                    obj.parent().parent().remove();
                }

            });
        }
        return false;
    });

    $(".undo-combine-mark-settings").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to restore this mark Settings ?'))
        {
            $.ajax({
                type:"POST",
                url : BASE + 'settings/undo-delete-combine-mark',
                data: { id : obj.attr('href')},
                beforeSend:function()
                {
                    obj.parent().parent().hide();
                },
                success:function(e)
                {
                    obj.parent().parent().remove();
                }

            });
        }
        return false;
    });

    $(".remove-combine-mark-settings").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to delete this mark Settings permanently ?'))
        {
            $.ajax({
                type:"POST",
                url : BASE + 'settings/remove-combine-mark',
                data: { id : obj.attr('href')},
                beforeSend:function()
                {
                    obj.parent().parent().hide();
                },
                success:function(e)
                {
                    obj.parent().parent().remove();
                }

            });
        }
        return false;
    });
});
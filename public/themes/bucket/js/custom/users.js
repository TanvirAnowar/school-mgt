/**
 * Created by Tanvir Anowar on 5/4/14.
 */
$(function(){
    $(".delete-user").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to delete this user?'))
        {
            $.ajax({
                type: "POST",
                url : BASE+'users/delete-user',
                data: {id: obj.attr('href')},
                beforeSend:function(e)
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

    $(".delete-trash-user").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to delete this user permanently?'))
        {
            $.ajax({
                type: "POST",
                url : BASE+'users/delete-trash-user',
                data: {id: obj.attr('href')},
                beforeSend:function(e)
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

    $(".restore-trash-user").live('click',function(){
        var obj = $(this);
        if(confirm('Are you sure to restore this user?'))
        {
            $.ajax({
                type: "POST",
                url : BASE+'users/restore-user',
                data: {id: obj.attr('href')},
                beforeSend:function(e)
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
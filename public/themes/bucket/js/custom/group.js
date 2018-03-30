/**
 * Created by Tanvir Anowar on 6/19/14.
 */
$(function(){
   $('.del-group').click(function(){
      var obj = $(this);
      if(confirm('Are you sure to delete this group? member of this group also be deleted.'))
      {
          $.ajax({
            type: "POST",
            url : BASE + 'sms/del-group',
            data: {group_id: obj.attr('href')},
            success:function(e)
            {
                obj.parent().parent().remove();
            }
          });
      }
       return false;
   });

   $(".del-groupmember").click(function(){
        var obj = $(this);
        if(confirm('Are you sure to remove this member?'))
        {
            $.ajax({
                type:"POST",
                url : BASE + 'sms/delete-group-member',
                data: {member_id: obj.attr('href')},
                success:function(e)
                {
                    if(e == 1)
                        obj.parent().parent().remove();
                }
            });
        }
       return false;
   });
});
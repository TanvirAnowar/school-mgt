/**
 * Created by Tanvir Anowar on 4/17/14.
 */
$(function(){
   $("a.delete-template").live('click',function(){
      var obj = $(this);
      if(confirm('Are you sure to delete this record?'))
      {
          $.ajax({
             type: "POST",
             url : BASE + 'templates/delete-template',
             data: {id: obj.attr('href')},
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
/**
 * Created by Tanvir Anowar on 4/21/14.
 */
$(function(){
   $(".delete-subject").live('click',function(){
       var obj = $(this);
       if(confirm("Are you sure to delete this subject it May Cause Problem in Mark Calculation? ")){
           $.ajax({
               type:"POST",
               url : BASE + 'school/delete-subject',
               data: { id: obj.attr('href')},
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
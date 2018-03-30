/**
 * Created by Tanvir Anowar on 4/24/14.
 */
$(function(){

    //when class selected on load
    var classElm = $("select[name=class_id]");
    if(classElm.val())
    {
        var classObj = new Classes();
        classObj.sections(classElm.val(),$("select[name=section_id]"));
    }

    // get section by class
    $("select[name=class_id]").change(function(){
        var obj = $(this);
        var classObj = new Classes();
        classObj.sections(obj.val(),$("select[name=section_id]"));
    });



});
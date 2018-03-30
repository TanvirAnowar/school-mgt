/**
 * Created by Tanvir Anowar on 4/28/14.
 */
$(function(){
	selectedClass = $("#totalClassFrm select[name=class_id]").val();
	if(selectedClass != "")
	{
		var classes = new Classes();
		classes.sections(selectedClass,$("select[name=section_id]"));
	}

	$("#totalClassFrm select[name=class_id]").change(function(){
        var obj = $(this);
        var classes = new Classes();

        classes.sections(obj.val(),$("select[name=section_id]"));
    });

    $("a.delTotalClass").on("click",function(){
    	var obj = $(this);

    	if(confirm('Are you sure?'))
    		return true;
    	else 
    		return false;
    });

});
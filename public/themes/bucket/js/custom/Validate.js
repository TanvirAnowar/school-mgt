/**
 * Created by Tanvir Anowar on 3/31/14.
 */
var SimpleValidate = function(){};

SimpleValidate.prototype.isEmpty = function(selector,location,type){
    var errorList = Array();

    $.each(selector,function(i,elm){
        var selectElm = $(this);
        if((selectElm.attr('required')) && selectElm.val() == "")
        {
            errorList.push(selectElm.attr('title') + ' is required');
        }
    });

    if(errorList.length)
    {
        $("#errorMsg").remove();

        var htmlObj =  '<div id="errorMsg" class="alert alert-warning hidden">';
            htmlObj += '<button type="button" class="close close-sm" data-dismiss="alert">';
            htmlObj += '<i class="fa fa-times"></i>';
            htmlObj += '</button><h4>Warning !</h4>';
        for(msg in errorList)
        {
            htmlObj += '<span>'+errorList[msg]+'</span> <br/>';
        }
            htmlObj += '</div>';
        if(type == 'before'){

            location.prepend(htmlObj);

        }else if(type == 'after')
        {
            location.append(htmlObj);
        }

        $("#errorMsg").removeClass('hidden').addClass('fade in');
        return 1;
    }else{
        return 0;
    }

}

SimpleValidate.notify = function(msg,type)
{
    alert(msg);
}
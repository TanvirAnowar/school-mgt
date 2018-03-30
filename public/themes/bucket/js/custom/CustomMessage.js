/**
 * Created by Tanvir Anowar on 4/1/14.
 */
var CustomMessage = function(){};

CustomMessage.printMessage = function(status,msg,elm,type){
    var htmlObj = '';
    $("#errorMsg").remove();
    if(status == 200)
    {
        htmlObj +=  '<div id="errorMsg" class="alert alert-success hidden">';
        htmlObj += '<button type="button" class="close close-sm" data-dismiss="alert">';
        htmlObj += '<i class="fa fa-times"></i>';
        htmlObj += '</button><strong>Success !</strong>';
        htmlObj += '<span>'+msg+'</span> <br/>';
        htmlObj += '</div>';
    }
    else if(status == 400)
    {
        htmlObj +=  '<div id="errorMsg" class="alert alert-warning hidden">';
        htmlObj += '<button type="button" class="close close-sm" data-dismiss="alert">';
        htmlObj += '<i class="fa fa-times"></i>';
        htmlObj += '</button><strong>Warning !</strong>';
        htmlObj += '<span>'+msg+'</span> <br/>';
        htmlObj += '</div>'
    }else if(status == 500)
    {
        htmlObj +=  '<div id="errorMsg" class="alert alert-danger hidden">';
        htmlObj += '<button type="button" class="close close-sm" data-dismiss="alert">';
        htmlObj += '<i class="fa fa-times"></i>';
        htmlObj += '</button><strong>Oops !</strong>';
        htmlObj += '<span>'+msg+'</span> <br/>';
        htmlObj += '</div>'
    }

    if(type == 'before')
    {
        elm.prepend(htmlObj);
    }
    else if(type == 'after')
    {
        elm.append(htmlObj);
    }

    $("#errorMsg").removeClass('hidden').addClass('fade in');

};

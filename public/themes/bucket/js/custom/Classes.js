/**
 * Created by Tanvir Anowar on 3/10/14.
 */
var Classes = function(){};
var show_pass_mark = 0;
var subjects;
Classes.prototype.subjects = function(id,elm){
    $.ajax({
        type:"POST",
        url : BASE + 'ajax/get-class-wise-subject',
        data: {class_id:id},
        beforeSend:function(){
            elm.html("").attr('disabled','disabled');
        },
        success:function(e){

            var data = $.parseJSON(e);

            if(data.length)
            {
                var optionHtml = '<option value="" selected="selected">Select</option>';
                $.each(data,function(i,el){
                    optionHtml += '<option value="'+data[i].subject_id+'">'+data[i].subject_name+'</option>';
                });
                elm.html(optionHtml);


            }
            elm.removeAttr('disabled');
        }
    });
};

Classes.prototype.nonDependendSubjects = function(id,elm){
    $.ajax({
        type:"POST",
        url : BASE + 'ajax/get-class-wise-subject',
        data: {class_id:id},
        beforeSend:function(){
            elm.html("").attr('disabled','disabled');
        },
        success:function(e){

            var data = $.parseJSON(e);
            subjects = data;
            if(data.length)
            {
                var optionHtml = '<option value="" selected="selected">Select</option>';
                $.each(data,function(i,el){
                    if(data[i].subject_dependency == null)
                    {
                        optionHtml += '<option value="'+data[i].subject_id+'">'+data[i].subject_name+'</option>';
                    }
                });
                elm.html(optionHtml);


            }
            elm.removeAttr('disabled');
        }
    });
};

Classes.prototype.sections = function(id,elm){
    $.ajax({
        type:"POST",
        url : BASE + 'ajax/get-class-wise-section',
        data: {class_id:id},
        beforeSend:function(){
            elm.html("").attr('disabled','disabled');
        },
        success:function(e){

            var data = $.parseJSON(e);

            if(data.length)
            {
                var optionHtml = '<option value="" selected="selected">Select</option>';
                $.each(data,function(i,el){
                    optionHtml += '<option value="'+data[i].section_id+'">'+data[i].section_name+'-'+data[i].shift_name+'</option>';
                });
                elm.html(optionHtml);
                elm.removeAttr('disabled');
            }
        }
    });
}

Classes.prototype.dependedSubject = function(id,elm)
{
    $.ajax({
        type:"POST",
        url : BASE + 'ajax/get-depended-subject',
        data: {class_id:id},
        beforeSend:function(){
            elm.html("").attr('disabled','disabled');
        },
        success:function(e){

            var data = $.parseJSON(e);

            if(data.length)
            {
                var optionHtml = '';
                $.each(data,function(i,el){
                    optionHtml += '<option value="'+data[i].subject_id+'">'+data[i].subject_name+'</option>';
                });
                elm.html(optionHtml);


            }
            elm.removeAttr('disabled');
        }
    });
}
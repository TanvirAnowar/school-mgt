/**
 * Created by Tanvir Anowar on 4/8/14.
 */
$(function(){
    $typeSelected = $("select[name=group_type] option:selected").val();
    switch($typeSelected)
    {
        case 'student':
            $("#student").removeClass('hidden');
            var classId = $("#groupAddFrm select[name=class_id] option:selected").val();
            if(classId)
            {
                var classObj = new Classes();
                classObj.sections(classId,$("#groupAddFrm select[name=section_id]"));
            }
            break;
        case 'teacher':
            $("#teacher").removeClass('hidden');
            break;
        case 'other':
            $("#other").removeClass('hidden');
            break;
    }
    $("select[name=group_type]").change(function(){
        var obj = $(this);
        if(obj.val() == 'student')
        {
            $(".student").removeClass('hidden');
            $(".teacher").addClass('hidden');
            $(".other").addClass('hidden');
            $(".number-list").removeClass('hidden');

        }
        else if(obj.val() == 'teacher')
        {
            $(".student").addClass('hidden');
            $(".other").addClass('hidden');
            $(".teacher").removeClass('hidden');
            $(".number-list").removeClass('hidden');

        }else if(obj.val() == 'other')
        {
            $(".student").addClass('hidden');
            $(".teacher").addClass('hidden');
            $(".other").removeClass('hidden');
            $(".number-list").removeClass('hidden');

        }
    });

    $("#groupAddFrm select[name=class_id]").change(function(){
        var obj = $(this);
        var classObj = new Classes();
        classObj.sections(obj.val(),$("#groupAddFrm select[name=section_id]"));
    });

    $("#searchRegisteredStudent").click(function(){
        $.ajax({
          type:"POST",
          url: BASE + 'ajax/get-registered-student',
          data: $("#groupAddFrm").serialize(),
          success:function(e)
          {
            var trHtml = '';
            var data = $.parseJSON(e);
            if(data.length)
            {
                $.each(data,function(i,el){
                    var number = '';
                    if(studentSmsOption && noticeSmsOption)
                    {
                        number = data[i].father_cell_number;
                        if(data[i].mother_cell_number){
                            number += ','+ data[i].mother_cell_number;
                        }
                    }
                    else
                        number = (data[i].father_cell_number)? data[i].father_cell_number : data[i].mother_cell_number;
                    trHtml += '<tr>';
                    trHtml += '<td>'+data[i].class_roll+'</td>'
                    trHtml += '<td><input type="hidden" name="names[]" value="'+data[i].name+'"/> '+data[i].name+'</td>'
                    trHtml += '<td>'+data[i].class_name+'</td>'
                    trHtml += '<td>'+data[i].class_name+'</td>'
                    trHtml += '<td><input type="hidden" name="phones[]" value="'+number+'"/> '+number+'</td>'
                    trHtml += '</tr>';
                });
                $(".searchRegStudentList tbody").html(trHtml);
            }
          }
        });
    });

    $("#loadTeachersBtn").click(function(){
        $.ajax({
            type: "POST",
            url : BASE + 'ajax/get-teachers',
            success:function(e)
            {
                var trHtml = '';
                var data = $.parseJSON(e);
                if(data.length)
                {
                    $.each(data,function(i,el){
                        var number = '';
                       // console.log(data[i]);
                        if(teacherSmsOption && noticeSmsOption)
                        {
                            number = data[i].cell_phone;
                            if(data[i].cell_phone_2){
                                number += ','+ data[i].cell_phone_2;
                            }
                        }
                        else
                            number = data[i].cell_phone;
                        trHtml += '<tr>';
                        trHtml += '<td>'+data[i].id+'</td>'
                        trHtml += '<td  colspan="2"><input type="hidden" name="names[]" value="'+data[i].name+'"/> '+data[i].name+'</td>'
                        trHtml += '<td><input type="hidden" name="phones[]" value="'+number+'"/> '+number+'</td>'
                       // trHtml += '';

                        trHtml += '</tr>';
                    });
                    $(".loadTeacherList tbody").html(trHtml);
                    //$(".loadTeacherList").dataTable();
                }
            }
        });
    });

    $("table.searchRegStudentList tbody tr").live('click',function(e){
        var obj = $(this);

        if(e.ctrlKey)
        {
            if(obj.hasClass('selected')){
                obj.removeClass('selected');
            }
            else{
                obj.addClass('selected');
            }
        }
        return false;
    });

    $("table.loadTeacherList tbody tr").live('click',function(e){
        var obj = $(this);
      //  console.log(obj);
        if(e.ctrlKey)
        {
            if(obj.hasClass('selected')){
                obj.removeClass('selected');
            }
            else{
                obj.addClass('selected');
            }
        }
        return false;
    });

    $("table.includeList tbody tr").live('click',function(e){
        var obj = $(this);

        if(e.ctrlKey)
        {
            if(obj.hasClass('selected')){
                obj.removeClass('selected');
            }
            else{
                obj.addClass('selected');
            }
        }
        return false;
    });


    $(".includeBtn").click(function(){

        var group_type = $("select[name=group_type]").val();
        var obj;
        if(group_type == 'student'){

            obj = $("table.searchRegStudentList tbody tr.selected").remove();
            $.each(obj,function(i,elm){
                $(this).children().eq(2).remove();
                $(this).children().eq(2).remove();
                $(this).find('input').eq(0).attr('name','name[]');
                $(this).find('input').eq(1).attr('name','phone[]');
                $(this).children().eq(1).attr('colspan','2');
                var deleteButton = '<td> <a class="grid-action-link delete-object" href="1"><i class="fa fa-trash-o" title="Delete"></i></a></td>';
                $(this).append(deleteButton);
            });

        }else if(group_type == 'teacher')
        {

            obj = $("table.loadTeacherList tbody tr.selected").remove();
            $.each(obj,function(i,elm){
                $(this).find('input').eq(0).attr('name','name[]');
                $(this).find('input').eq(1).attr('name','phone[]');
                var deleteButton = '<td> <a class="grid-action-link delete-object" href="1"><i class="fa fa-trash-o" title="Delete"></i></a></td>';
                $(this).append(deleteButton);
            });

         //   console.log(obj);

        }
        else if(group_type == 'other')
        {
            var otherName = $("input[name=other_name]");
            var otherPhone = $("input[name=other_phone]");
            var totalItem = $("table.includeList tbody").children().length;
            var trHtml = '';
            trHtml += '<tr>';
                trHtml += '<td>'+(totalItem+1)+'</td>';
                trHtml += '<td colspan="2"><input type="hidden" name="name[]" value="'+otherName.val()+'"/> '+otherName.val()+'</td>';
                trHtml += '<td><input type="hidden" name="phone[]" value="'+otherPhone.val()+'"/> '+otherPhone.val()+'</td>';
                trHtml += '<td> <a class="grid-action-link delete-teacher" href="1"><i class="fa fa-trash-o" title="Delete"></i></a>'+'</td>';
            trHtml += '</tr>';
            obj = $(trHtml);
            otherName.val('');
            otherPhone.val('');


        }
        $("table.includeList").append(obj);
        $("table.includeList tbody tr").removeClass('selected');
    });


    $(".delete-object").live("click",function(){
        $(this).parent().parent().remove();
    });

    $(".excludeBtn").click(function(){
        $("table.includeList tbody tr.selected").remove();
    });


    $("#searchRegStudentListScroller").slimscroll({
        width:'450',
        height:'300',
        position:'right'

    });
    var div = $("div.slimScrollDiv");
    if(div)
    {
        div.css('float','left');
    }


    $("#groupAddFrm").submit(function(){
        var includeItems = $(".includeList tbody").children();
        var includeItemLen = includeItems.length;

        if(includeItemLen)
        {
            return true;
        }
        else{
            return false;
        }

    });

    /********SMS PART **********/
    var countMsg1 = '';
    if($("#singleSmsFrm").length){
    var countMsg1 = $("#singleSmsFrm textarea[maxlength]").val().length;
    }
    $("#singleSmsFrm span#countMsg").text(countMsg1);

    $("#singleSmsFrm textarea[maxlength]").bind('input propertychange', function() {
        var maxLength = $(this).attr('maxlength');
        var countMsg = 0;

        checkValidChars($(this));

        if ($(this).val().length > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
        }
        var newCount = countMsg + $(this).val().length;
        var smsCount = 1;

        smsCount = ' Sms Count ('+Math.ceil(newCount/160)+')';

        $("#single_smsCount").text(smsCount);
        $("#singleSmsFrm span#countMsg").text(newCount);
    });

    function checkValidChars(obj)
    {
        var pattern = /(#|&)/

        if(pattern.test(obj.val()))
        {
            obj.val(obj.val().replace(pattern, " "));
            //obj.val(obj.val().substring(0,(obj.val().length-1)));
            return 1;
        }
        return 0;
    }

    $("#singleSmsFrm").submit(function(){
        var obj = $(this);
        var message = $("#singleSmsFrm textarea[name=message]").val();

            var acceptedMessage = checkValidChars($("#singleSmsFrm textarea[name=message]"));
            if(acceptedMessage == 0){
                $.ajax({
                    type: "POST",
                    url : obj.attr('action'),
                    data: obj.serialize(),
                    success:function(e)
                    {
                        window.location = BASE+'dashboard';
                        /*if(e == 0){
                            window.location.reload();
                        }else if(e== -1)
                        {
                            window.location = BASE+'dashboard';
                        }*/
                    }
                });
            }else{
                alert('Remove Unexpected Character ( #, &) From Message.');
            }
        return false;
    });

    $(".selectAll").live('click',function(){

        if($(".searchRegStudentList tbody tr").length)
        {
            $(".searchRegStudentList tbody tr").addClass('selected');
        }

        if($(".loadTeacherList tbody tr").length)
        {
            $(".loadTeacherList tbody tr").addClass('selected');
        }
    });

});
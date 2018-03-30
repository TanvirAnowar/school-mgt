/**
 * Created by Tanvir Anowar on 3/2/14.
 */
$(function(){
    $('.default-date-picker').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('.student-dob').datepicker({
       format: 'yyyy-mm-dd',
       yearRange: "-10:+10"
    });

    $('.teacher-dob').datepicker({
       format: 'yyyy-mm-dd',
       yearRange: "-30:-10"
    });

    $("#selectTopAll").change(function(){
          var obj = $(this);
          if(obj.attr('checked'))
          {
              $(".select-check").attr('checked','checked');
              $("#selectBottomAll").attr('checked','checked');
          }else{
              $(".select-check").removeAttr('checked');
              $("#selectBottomAll").removeAttr('checked');
          }
    });

    $("#selectBottomAll").change(function(){
        var obj = $(this);
        if(obj.attr('checked'))
        {
            $(".select-check").attr('checked','checked');
            $("#selectTopAll").attr('checked','checked');
        }else{
            $(".select-check").removeAttr('checked');
            $("#selectTopAll").removeAttr('checked');
        }
    });

    $("#sameAsPresent").change(function(){
        var obj = $(this);
        if(obj.attr('checked'))
        {
            $("textarea[name=permanent_address]").val($("textarea[name=present_address]").val());

        }else{

            $("textarea[name=permanent_address]").val("");

        }

    });

    $("#addParam").click(function(){
        var obj = $(this);
        var htmlObj =  '<tr>';
        htmlObj += '<td><input type="text" class="form-control col-lg-2" name="key[]"/></td>';
        htmlObj += '<td><input class="paramVal form-control col-lg-2" type="text" name="value[]"/></td>';
        htmlObj += '<td><a class="delParam" href="#"><i class="fa fa-minus-circle"></i></a></td>';
        htmlObj += '</tr>';
        $("#paramTbl tbody").append(htmlObj);
//		console.log($("#paramTbl tbody").children(':last').children(':first').children().focus());
        $("#saveParam").show();
        return false;
    });

    $(".delParam").live('click',function(){
        var obj = $(this);
        obj.parent().parent().remove();
        if($("#paramTbl tbody tr").length == 0)
        {
            $("#saveParam").hide();
        }
        return false;
    });



    $("input.paramVal").live('focus',function(){
        var obj = $(this);
        var prevValue = obj.parent().prev().children().val();
        obj.attr('value',prevValue);
        var pattern = /(date|day)/;
        if(pattern.test(prevValue.toLowerCase()))
        {
            obj.datepicker();
        }

    });


});


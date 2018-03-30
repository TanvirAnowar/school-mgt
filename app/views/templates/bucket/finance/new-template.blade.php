@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Create Transaction Group
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                           <!--  {{ Form::open(array('url'=>'transaction-settings/manage/new','method'=>'get')) }}
                                <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-plus-circle"></i> Add Account</button>
                            {{ Form::close() }} -->
                         </span>

                </header>
                <div class="panel-body">
                	<form id="transactionSettingFrm" class="form-horizontal" action="{{url()}}" method="post">
                        
                        <div class="form-group">
                            <label class="control-label col-lg-3">ACC TYPE</label>
                            <div class="col-lg-3">
                                <select name="acc_type" class="form-control">
                                    <option value="STUDENT">Student</option>
                                    <option value="Misc">Misc</option>
                                    <option value="TEACHER">Teacher</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-3 col-lg-offset-3">
                                <button type="button" id="getHeads" class="btn btn-info">Get Transaction Heads</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3">Group Title</label>
                            <div class="col-lg-3">
                                <input type="text" name="template_name" class="form-control" required/>
                            </div>
                        </div>
                    <div id="placeholder">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Head</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <button id="saveTemplateBtn"  type="button" class="btn btn-primary hide">Save Template</button>
                    </div>
                    </form>
            	</div>
        	</section>
    	</div>
	</div>
</section>
<script type="text/javascript">
    $(function(){
        $("#getHeads").click(function(){
            $.ajax({
                type:"POST",
                url : BASE + 'ajax/get-heads',
                data:$("#transactionSettingFrm").serialize(),
                success:function(e)
                {
                    var data = e;
                    var trHtml = '';
                    for(i in data)
                    {
                        var child = data[i].child;
                        
                        trHtml += '<tr>';
                        trHtml += '<td><input type="checkbox" name="head_id[]" value="'+data[i].acc_head_id+'"/></td>';
                        trHtml +=  '<td>'+i+'</td>';
                        trHtml +=  '<td>'+data[i].head_type+'</td>';
                        trHtml +=  '<td><input type="text" name="amount['+data[i].acc_head_id+']" class="form-control"/></td>';
                        trHtml += '</tr>';
                        if(child.length)
                        {
                            for(c in child)
                            {
                                trHtml += '<tr>';
                                trHtml += '<td><input type="checkbox" name="head_id[]" value="'+child[c].acc_head_id+'"/></td>';
                                trHtml +=  '<td>'+i+' - '+child[c].head_name+'</td>';
                                trHtml +=  '<td>'+child[c].head_type+'</td>';
                                trHtml +=  '<td><input type="text" name="amount['+child[c].acc_head_id+']" class="form-control"/></td>';
                                trHtml += '</tr>';
                            }
                        }
                    }

                    $("#placeholder table tbody").html(trHtml);
                    $("#saveTemplateBtn").removeClass('hide');
                }
            });
        });

        $("#saveTemplateBtn").click(function(){
            if($("input[name=template_name]").val())
            {
            $.ajax({
                type:"POST",
                url : BASE + 'transaction-settings/save-template',
                data: $("#transactionSettingFrm").serialize(),
                success:function(e){
                    window.location  = BASE+'transaction-settings';
                }
            });
            }else{
                alert('Title required');
            }
        });
    });
</script>

@stop
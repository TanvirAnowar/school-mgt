@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Create Transaction Template
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
                                    <?php
                                        $acc_types = array('STUDENT'=>'Student','TEACHER'=>'Teacher','MISC'=>'Misc');
                                    ?>
                                        @foreach($acc_types as $i => $acc_type)
                                            <option @if($i==$transaction_template->acc_type) selected="selected" @endif value="{{$i}}">{{$acc_type}}</option>
                                        @endforeach


                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-3 col-lg-offset-3">
                                <button type="button" id="getHeads" class="btn btn-info">Get Transaction Heads</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3">Template Title</label>
                            <div class="col-lg-3">
                                <input type="text" name="template_name" value="{{$transaction_template->title}}" class="form-control"/>
                            </div>
                        </div>
                    <div id="placeholder">
                        <?php

                        $tTemplates = (!empty($transaction_template)) ? json_decode($transaction_template->template) : array();

                        ?>
                        <table id="updateTemplateList" class="table">
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Head</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($templates) && count($tTemplates))
                            @foreach($tTemplates as $tTemplate)
                                @foreach($templates as $i=> $template)
                                    @if($template['acc_head_id'] == $tTemplate->head_id)
                                        <tr id="{{$template['acc_head_id']}}">
                                            <td><input type="checkbox" name="head_id[]" checked value="{{$template['acc_head_id']}}"/></td>
                                            <td>{{$i}}</td>
                                            <td>{{$template['head_type']}}</td>
                                            <td><input type="text" name="amount[{{$template['acc_head_id']}}]" value="{{$tTemplate->amount or ''}}" class="form-control"/></td>
                                            <td><button class="btn btn-danger remove_row">Remove</button></td>
                                        </tr>

                                    @endif
                                        @if($template['child'])

                                            @foreach($template['child'] as $child)
                                                @if($child['acc_head_id'] == $tTemplate->head_id)
                                                <tr id="{{$child['acc_head_id']}}">
                                                    <td><input type="checkbox" name="head_id[]" checked value="{{$child['acc_head_id']}}"/></td>
                                                    <td>{{$i.' - '.$child['head_name']}}</td>
                                                    <td>{{$child['head_type']}}</td>
                                                    <td><input type="text" name="amount[{{$child['acc_head_id']}}]" value="{{$tTemplate->amount or ''}}" class="form-control"/></td>
                                                    <td><button class="btn btn-danger remove_row">Remove</button></td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @endif

                                @endforeach
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                        <button id="updateTemplateBtn"  type="button" class="btn btn-primary ">Save Template</button>
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
            var TRs = $("#updateTemplateList tbody").children();
            var TrIds = [];
            $.each(TRs,function(i,elm){
                TrIds[$(this).attr('id')] = ($(this).attr('id'));
            });
            ///console.log(TrIds);
            $.ajax({
                type: "POST",
                url : BASE + 'ajax/get-heads',
                data: $("#transactionSettingFrm").serialize(),
                success:function(e)
                {
                    var data = e;
                    var trHtml = '';
                    for(i in data)
                    {
                        var child = data[i].child;
                        console.log(TrIds[(data[i].acc_head_id)]);
                        if(TrIds[(data[i].acc_head_id)] == undefined)
                        {
                            trHtml += '<tr id="'+data[i].acc_head_id+'">';
                            trHtml += '<td><input type="checkbox" name="head_id[]" value="'+data[i].acc_head_id+'"/></td>';
                            trHtml +=  '<td>'+i+'</td>';
                            trHtml +=  '<td>'+data[i].head_type+'</td>';
                            trHtml +=  '<td><input type="text" name="amount['+data[i].acc_head_id+']" class="form-control"/></td>';
                            trHtml +=  '<td><button class="btn btn-danger remove_row">Remove</button></td>';
                            trHtml += '</tr>';
                        }
                        if(child.length)
                        {
                            for(c in child)
                            {
                                if(TrIds[(child[c].acc_head_id)] == undefined)
                                {
                                    trHtml += '<tr id="'+child[c].acc_head_id+'">';
                                    trHtml += '<td><input type="checkbox" name="head_id[]" value="'+child[c].acc_head_id+'"/></td>';
                                    trHtml +=  '<td>'+i+' - '+child[c].head_name+'</td>';
                                    trHtml +=  '<td>'+child[c].head_type+'</td>';
                                    trHtml +=  '<td><input type="text" name="amount['+child[c].acc_head_id+']" class="form-control"/></td>';
                                    trHtml +=  '<td><button class="btn btn-danger remove_row">Remove</button></td>';
                                    trHtml += '</tr>';
                                }
                            }
                        }
                    }

                    $("#placeholder table tbody").append(trHtml);
                    $("#saveTemplateBtn").removeClass('hide');
                }
            });
        });

        $("#updateTemplateBtn").click(function(){
            $.ajax({
                type:"POST",
                url : BASE + 'transaction-settings/save-template',
                data: $("#transactionSettingFrm").serialize(),
                success:function(e){
                    window.location  = BASE+'transaction-settings';
                }
            });
        });

        $("body").on("click",".remove_row",function(){
            var obj = $(this);
            obj.parent().parent().remove();
        });
    });
</script>

@stop
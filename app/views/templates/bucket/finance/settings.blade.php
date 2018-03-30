@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Transaction Groups
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            {{ Form::open(array('url'=>'transaction-settings/manage/new','method'=>'post')) }}
                                <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-plus-circle"></i> Add Transaction Group</button>
                            {{ Form::close() }}
                         </span>

                </header>
                <div class="panel-body">
                	<table class="table">
                		<thead>
                			<tr>
                				<th>Sl.</th>
                				<th>Group Name</th>
                				<th>Type</th>

                				<th>Actions</th>
            				</tr>
                		</thead>
                		<tbody>
                            @if(count($transactions))
                                @foreach($transactions as $i=> $transaction)
                                    <tr>
                                        <td>{{($i+1)}}</td>
                                        <td>{{$transaction->title}}</td>
                                        <td>{{$transaction->acc_type}}</td>

                                        <td>
                                            <a href="{{url('transaction-settings/manage/edit/'.$transaction->id)}}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
            			</tbody>
            		</table>
            	</div>
        	</section>
    	</div>
	</div>
</section>
@stop
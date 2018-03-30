@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Finance Accounts
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            {{ Form::open(array('url'=>'finance/account/new','method'=>'get')) }}
                                <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-plus-circle"></i> Add Account</button>
                            {{ Form::close() }}
                         </span>

                </header>
                <div class="panel-body">
                    <table class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Account Name</th>
                            <th>Type</th>
                            <th>Opening Balance</th>
                            <th>Opening Date</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($accounts))
                                @foreach($accounts as $index=>$account)
                                    <tr>
                                        <td>{{{($index+1)}}}</td>
                                        <td>{{{$account->acc_name}}}</td>
                                        <td>
                                            @if(preg_match('/capital/',strtolower($account->acc_type)))
                                            <span class="label label-success label-mini">{{{$account->acc_type}}}</span>
                                            @else
                                            {{{ $account->acc_type }}}
                                            @endif
                                        </td>
                                        <td>{{{$account->opening_balance}}}</td>
                                        <td>{{{Helpers::dateTimeFormat('j F, Y',$account->opening_date)}}}</td>
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
<script type="text/javascript" language="javascript" src="{{$theme}}assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{$theme}}assets/data-tables/DT_bootstrap.js"></script>
<script src="{{$theme}}js/dynamic_table/dynamic_table_init.js"></script>
@stop
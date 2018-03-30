@extends('templates.bucket.bucket')


@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Transactions
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            @if($user->user_type == 'Admin')
                            {{ Form::open(array('url'=>'finance/transaction/new','method'=>'get')) }}
                                <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-plus-circle"></i> New Transaction</button>
                            {{ Form::close() }}
                            @endif
                         </span>

                </header>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Slno.</th>
                                <th>Invoice Number</th>
                                <th>Account Type</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($transactions))
                                @foreach($transactions as $i=> $transaction)
                                    <?php
                                        $type = '';
                                        if($transaction->acc_type == AccountTransaction::$MISC) {

                                            $type = strtolower(AccountTransaction::$MISC);

                                        }elseif($transaction->acc_type == AccountTransaction::$STUDENT){

                                            $type = strtolower(AccountTransaction::$STUDENT);

                                        }elseif($transaction->acc_type == AccountTransaction::$TEACHER){

                                            $type = strtolower(AccountTransaction::$TEACHER);

                                        }


                                    ?>
                                    <tr>
                                        <td>{{($i+1)}}</td>
                                        <td><a href="{{url('finance/report/'.$type.'/'.$transaction->invoice_number)}}">{{$transaction->invoice_number}}</a></td>
                                        <td>{{$transaction->acc_type}}</td>
                                        <td>{{$transaction->transaction_type}}</td>
                                        <td>{{abs($transaction->total)}}</td>
                                        <td>{{Helpers::dateTimeFormat('j F, Y',$transaction->created_at)}}</td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">{{$transactions->links()}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>


@stop
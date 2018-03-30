@extends('templates.bucket.bucket')

@section('wrapper')


<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Invoice No.  {{date('Ymd')}}
                           <span class="tools pull-right">
                            <!--     <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>-->


                                {{ Form::open(array('url'=>'finance/report/misc/'.Request::segment(4),'class'=>'col-lg-2','method'=>'get')) }}
                                    <button class="btn panel-btn" type="submit"><i class="fa fa-print"></i> Print</button>
                                {{ Form::close() }}
                             </span>
                </header>
                <div class="panel-body">
                    <div class="print-area row form-horizontal">

                        <div class="col-lg-12">
                            <table id="transaction_list" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Head</th>
                                        <th>Month</th>
                                        <th>Ref No.</th>
                                        <th>Description</th>
                                        <th class="text-right">Amount</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; ?>
                                    @if(count($finance))
                                        @foreach($finance as $i=> $sf)
                                        <?php
                                        $transaction = AccountTransaction::where('transaction_code',$sf->transaction_code)->first();

                                        if(trim($transaction->transaction_type) == AccountTransaction::$TYPE_INCOME)
                                        {
                                            $amount = ($sf->amount);
                                            $total += ($sf->amount);
                                        }else{
                                            $amount = -($sf->amount);
                                            $total -= ($sf->amount);
                                        }
                                        ?>
                                        <tr>
                                            <td>{{($i+1)}}</td>
                                            <td>{{$sf->head}}{{$transaction->transaction_type}}</td>
                                            <td>{{$sf->month}}</td>
                                            <td>{{$sf->ref_no}}</td>
                                            <td>{{$sf->description}}</td>
                                            <td class="text-right">{{$amount}}</td>
                                        </tr>

                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-right"><strong>Total</strong></td>
                                        <td colspan="1" class="text-right"><strong>{{$total}}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>


                </div>


            </section>
        </div>
    </div>
</section>
<script src="{{$theme}}js/custom/Classes.js"></script>
<script src="{{$theme}}js/custom/finance.js"></script>
@stop
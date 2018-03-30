@extends('templates.bucket.bucket')

@section('wrapper')


<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Invoice No.  {{Request::segment(5)}}
                           <span class="tools pull-right">
                            <!--     <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>-->


                                {{ Form::open(array('url'=>'finance/report/student/'.Request::segment(5),'class'=>'col-lg-2','method'=>'get')) }}
                                    <button class="btn panel-btn" type="submit"><i class="fa fa-print"></i> Print</button>
                                {{ Form::close() }}
                             </span>
                </header>
                <div class="panel-body">


                    <div class="print-area row form-horizontal">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-lg-3 text-right">Student Name :</label>
                                <div class="col-lg-7">
                                    <span>{{$student->name}}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 text-right">Session :</label>
                                <div class="col-lg-7">
                                    <span>{{$registration->session}}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 text-right">Reg. ID :</label>
                                <div class="col-lg-7">
                                    <span>{{$registration->reg_id}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-lg-8 text-right">Date :</label>
                                <div class="col-lg-3 text-right">
                                    <span>{{date("Y-m-d")}}</span>
                                </div>
                            </div>

                        </div>
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
                                            <td>{{$sf->head}}</td>
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
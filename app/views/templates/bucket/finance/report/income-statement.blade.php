@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Income Statement
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            {{ Form::open(array('url'=>'finance/income-statement/new','method'=>'get')) }}
                            <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-plus-circle"></i> Create Income Statement</button>
                            {{ Form::close() }}
                         </span>


                </header>
                <div class="panel-body">
                    <?php $months = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'); ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>File</th>
                                <th>Month</th>
                                <th>date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($incomeStatements))
                                @foreach($incomeStatements as $income)
                                    <tr>
                                        <td><a href="{{url('finance/income-statement/report/'.$income->year.'_'.$income->month.'_income-statement.pdf')}}">{{$income->year.'_'.$months[$income->month].'_income-statement.pdf'}}</a></td>
                                        <td>{{$months[$income->month]}}</td>
                                        <td>{{Helpers::dateTimeFormat('j F, Y',$income->created_at)}}</td>
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
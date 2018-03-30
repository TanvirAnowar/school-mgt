@extends('templates.bucket.bucket')

@section('wrapper')

<script type="text/javascript">

    var heads = <?php echo $heads->toJson(); ?>;

</script>
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <?php $invoiceNumber = date('Ymd').'-'.rand(0000,9999); ?>
                    Invoice No.  {{$invoiceNumber}}
                           <span class="tools pull-right">
                            <!--     <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>-->



                             </span>
                </header>
                <div class="panel-body">
                    {{Form::Open(array('id'=>'stdTransactionFrm','url'=>'finance/save_misc_transaction','method'=>'post'))}}
                    <input type="hidden" name="invoice_number" value="{{$invoiceNumber}}"/>
                    <div class="print-area row form-horizontal">
                        <div class="col-lg-12">
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label class="col-lg-6 text-right">Month of Transaction :</label>
                                    <div class="col-lg-3 text-right">
                                        <select class="form-control" name="month">
                                            <?php $months = array('January','February','March','April','May','June','July','August','September','October','November','December'); ?>
                                            <option value="">--Select--</option>
                                            @foreach($months as $month)
                                            <option value="{{$month}}">{{$month}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-lg-8 text-right">Date :</label>
                                    <div class="col-lg-2 text-right">
                                        <span>{{date("Y-m-d")}}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-lg-3 text-right">Transaction Template :</label>
                                <div class="col-lg-2">
                                    <select class="form-control" name="template">
                                        <option value="">--SELECT--</option>
                                        @if(count($templates))
                                        @foreach($templates as $template)
                                        <option value="{{$template->id}}">{{$template->title}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <input type="hidden" name="type" id="type" value="{{AccountTransaction::$MISC}}"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <table id="transaction_list" class="table">
                                <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Head</th>
                                    <th>Ref No.</th>
                                    <th>Description</th>
                                    <th class="text-right">Amount</th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>
                                        <select class="form-control" name="head[]">
                                            @foreach($heads as $head)
                                            <option class="{{$head->head_name}}">{{$head->head_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input class="form-control input-large" name="ref_no[]" type="text" /></td>
                                    <td><input class="form-control input-large" name="description[]" type="text" /></td>
                                    <td><input class="amount form-control input-mini text-right" name="amount[]" type="text"/></td>
                                    <td>&nbsp;</td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-lg-12 ">
                            <button id="save_std_transaction" type="button" class="btn btn-primary">SUBMIT</button>
                        </div>
                    </div>

                    {{Form::Close()}}
                </div>


            </section>
        </div>
    </div>
</section>
<script src="{{$theme}}js/custom/Classes.js"></script>
<script src="{{$theme}}js/custom/finance.js"></script>
@stop
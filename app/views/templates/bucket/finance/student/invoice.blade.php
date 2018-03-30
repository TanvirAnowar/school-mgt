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
                    <?php $invoice_number = date('Ymd').'-S'.$student->id; ?>
                    Invoice No.  {{$invoice_number}}
                           <span class="tools pull-right">
                            <!--     <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>-->



                             </span>
                </header>
                <div class="panel-body">
                    {{Form::Open(array('id'=>'stdTransactionFrm','url'=>'finance/invoice/student/'.$registration->reg_id,'method'=>'post'))}}
                    <input type="hidden" name="std_id" value="{{$student->id}}"/>
                    <input type="hidden" name="reg_id" value="{{$registration->reg_id}}"/>
                    <input type="hidden" name="invoice_number" value="{{$invoice_number}}"/>
                    <div class="print-area row form-horizontal">
                         <div class="col-lg-12">
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
                                    <div class="col-lg-2 text-right">
                                        <span>{{date("Y-m-d")}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-8 text-right">Month of Payment :</label>
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
                         </div>
                        <div class="col-lg-12">
                            <label  class="col-lg-3">Transaction Template</label>
                            <div class="col-lg-3 text-right">
                                <select class="form-control" name="template">
                                    <option value="">--SELECT--</option>
                                    @if(count($templates))
                                        @foreach($templates as $template)
                                            <option value="{{$template->id}}">{{$template->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="hidden" name="type" id="type" value="{{AccountTransaction::$STUDENT}}"/>
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
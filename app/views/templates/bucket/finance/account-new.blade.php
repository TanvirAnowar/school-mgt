@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Create Finance Accounts
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            <!--{{ Form::open(array('url'=>'finance/account/new','method'=>'get')) }}
                                <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-plus-circle"></i> Add Account</button>
                            {{ Form::close() }}-->
                         </span>

                </header>
                <div class="panel-body">
                    {{Form::open(array('url'=>'finance/save-account','class'=>'cmxform form-horizontal','id'=>'addHeadFrm','method'=>'post'))}}
                        <div class="form-group">
                            <label for="account_name" class="control-label col-lg-3">Account Owner Name</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="account_owner_name"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="account_status" class="control-label col-lg-3">status</label>
                            <div class="col-lg-3">
                                <select name="account_status" class="form-control">
                                    @foreach($types as $type)
                                    <option value="{{{$type}}}">{{{$type}}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="account_opening_balance" class="control-label col-lg-3">Opening Balance</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="account_opening_balance" value="0"/> <small>(for type capital only)</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="account_opening_date" class="control-label col-lg-3">Opening Date</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control default-date-picker" name="account_opening_date"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" language="javascript" src="{{$theme}}assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{$theme}}assets/data-tables/DT_bootstrap.js"></script>
<script src="{{$theme}}js/dynamic_table/dynamic_table_init.js"></script>
<script type="text/javascript" src="{{$theme}}/js/custom/common.js"></script>
@stop
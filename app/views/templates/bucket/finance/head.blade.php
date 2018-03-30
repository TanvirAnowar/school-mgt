@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Create Finance Head
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            <!--{{ Form::open(array('url'=>'school/subject/add','method'=>'get')) }}-->
                               <!-- <button class="btn btn-primary" type="submit"><i class="fa fa-plus-circle"></i> Add New</button>-->
                            <!--{{ Form::close() }}-->
                         </span>

                </header>
                <div class="panel-body">
                    {{Form::open(array('url'=>'finance/save-head','class'=>'cmxform form-horizontal','id'=>'addHeadFrm','method'=>'post'))}}
                        <div class="form-group">
                            <label for="head_type" class="control-label col-lg-3">Head Type</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="head_type">
                                    <option value="">--SELECT--</option>
                                    @foreach($head_types as $type)
                                        <option value="{{{$type}}}">{{{$type}}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="predefined_amount" class="control-label col-lg-3">Parent Head</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="parent_head">
                                    <option value="">--SELECT--</option>
                                    @foreach($heads as $head)
                                    <option value="{{{$head->head_name}}}">{{{$head->head_name}}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="head_name" class="control-label col-lg-3">Head Name</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="head_name"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="head_name" class="control-label col-lg-3">Acc Type</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="acc_type">
                                    @foreach($acc_types as $type)
                                        <option value="{{$type}}">{{$type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </div>
                    {{Form::close()}}
                    <table class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Head Name</th>
                                <th>Head Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($heads))
                                @foreach($heads as $index => $head)
                                    <tr>
                                        <td>{{($index+1)}}</td>
                                        @if($head->parent_head)
                                            <td>{{$head->parent_head.' - '}}{{($head->head_name)}}</td>
                                        @else
                                            <td>{{($head->head_name)}}</td>
                                        @endif
                                        <td>{{($head->head_type)}}</td>
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
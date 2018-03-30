@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Finance
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

                </div>
            </section>
        </div>
    </div>
</section>
@stop
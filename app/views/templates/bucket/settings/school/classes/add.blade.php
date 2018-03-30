@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add New Class Information
                           <!-- <span class="tools pull-right">
                                <a class="fa fa-chevron-down" href="javascript:;"></a>
                                <a class="fa fa-cog" href="javascript:;"></a>
                                <a class="fa fa-times" href="javascript:;"></a>
                             </span>-->
                </header>
                <div class="panel-body">
                    <div class="form">
                        <!--<form class="cmxform form-horizontal " id="classForm" method="get" action="#">-->
                        {{Form::open(array('url'=>'school/save-class','method'=>'post','id'=>'classForm','class'=>'cmxform form-horizontal'))}}
                            <input type="hidden" name="refurl" value="{{{url('school/classes')}}}"/>
                            <div class="form-group ">
                                <label for="class_name" class="control-label col-lg-3">Class Name</label>
                                <div class="col-lg-6">
                                    <input class=" form-control" id="class_name" name="class_name" type="text" required />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="class_code" class="control-label col-lg-3">Class Code</label>
                                <div class="col-lg-6">
                                    <input class=" form-control" id="class_code" name="class_code" type="text" required />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="class_code" class="control-label col-lg-3">Class Type</label>
                                <div class="col-lg-6">
                                    @foreach($class_types as $index => $type)
                                    <span>
                                        <input name="class_type" type="radio" value="{{{$index}}}" required /> {{{$type}}}
                                    </span>

                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                    <button class="btn btn-default" type="reset">Cancel</button>
                                </div>
                            </div>
                        {{Form::close()}}
                        <!--</form>-->
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
@stop
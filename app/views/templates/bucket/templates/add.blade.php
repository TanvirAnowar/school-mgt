@extends('templates.bucket.bucket')

@section('wrapper')

<section class="wrapper">
    <!-- code here -->

    <div class="row">

        <input type="hidden" name="refurl" value="{{{url('templates/lists')}}}"/>
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   Message Templates
                     <span class="tools pull-right">
                        <!-- <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>-->

                      </span>
                </header>
                <div class="panel-body">
                    <div class="form">
                        {{Form::open(array('url'=>'templates/save-template','method'=>'post','id'=>'templateAddForm','class'=>'cmxform form-horizontal'))}}
                        <input type="hidden" name="refurl" value="{{{url('templates/lists')}}}"/>
                        <div class="form-group">
                            <label for="name" class="control-label col-lg-3">Name  <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <input class="form-control" id="name" name="name" type="text" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="control-label col-lg-3">Type  <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <select class="form-control" id="type" name="type" type="text">
                                    <option value="SMS">SMS</option>
                                    <option value="Email">Email</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="template_details" class="control-label col-lg-3">Details  <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <textarea class="form-control" id="template_details" style="resize:none;" name="template_details" type="text" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>
                                <button class="btn btn-default" type="reset">Clear</button>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
@stop
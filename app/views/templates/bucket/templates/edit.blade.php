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
                        {{Form::open(array('url'=>'templates/update-template','method'=>'post','id'=>'templateAddForm','class'=>'cmxform form-horizontal'))}}
                        <input type="hidden" name="refurl" value="{{{url('templates/lists')}}}"/>
                        <div class="form-group">
                            <label for="name" class="control-label col-lg-3">Name  <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <input class="form-control" id="name" name="name" type="text" value="{{{$template->template_name}}}" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="control-label col-lg-3">Type  <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <select class="form-control" id="type" name="type" type="text">
                                    <?php $types = array('SMS','Email'); ?>
                                    @foreach($types as $type)
                                        @if($template->template_type == $type)
                                            <option selected="selected" value="{{{$type}}}">{{{$type}}}</option>
                                        @else
                                            <option value="{{{$type}}}">{{{$type}}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="template_details" class="control-label col-lg-3">Details  <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <textarea class="form-control" id="template_details" style="resize:none;" name="template_details" type="text" required>{{{$template->details}}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <input type="hidden" name="id" value="{{{$template->template_id}}}" />
                                <button class="btn btn-primary" type="submit">Save</button>

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
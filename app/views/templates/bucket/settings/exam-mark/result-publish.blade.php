@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Result Publish
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    {{Form::open(array('url'=>'result/save-result-publish-request', 'id'=>'resultPublishFrm','class'=>'cmxform form-horizontal','method'=>'post'))}}
                        <input type="hidden" name="refurl" value="{{{url('settings/result-publish')}}}"/>
                        <div class="form-group">
                            <label for="session" class="control-label col-lg-3">Exam Year <small>(Required)</small></label>
                            <div class="col-lg-2">
                                <select name="session" class="form-control" required>
                                    @for($i=(date('Y')-2); $i<=(date('Y')+10); $i++)
                                        <option @if($i==date('Y')) selected="selected" @endif value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="class_id" class="control-label col-lg-3">Class <small>(Required)</small></label>
                            <div class="col-lg-2">
                                <select name="class_id" class="form-control" required>
                                    <option value="">Select</option>
                                    @if(count($classes))
                                        @foreach($classes as $class)
                                            <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="section_id" class="control-label col-lg-3">Section <small>(Required)</small></label>
                            <div class="col-lg-2">
                                <select name="section_id" class="form-control" required>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="term" class="control-label col-lg-3">Term <small>(Required)</small></label>
                            <div class="col-lg-2">
                                <select name="term" class="form-control" required>
                                    @if(count($terms))
                                        @foreach($terms as $term)
                                            <option value="{{{trim($term)}}}">{{{$term}}}</option>
                                        @endforeach
                                    <option value="COMBINE">COMBINE</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button>

                            </div>
                        </div>

                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>

</section>
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/result.js"></script>
@stop
@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Total Class
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            
                         </span>

                </header>
                <div class="panel-body">
                    {{ Form::open(array('url'=>'school/save-total-class','id'=>'totalClassFrm','class'=>'form-horizontal'))}}
                    <div class="form-group">
                        <label class="control-label col-lg-3">Class</label>
                        <div class="col-lg-3">
                            <select class="form-control" name="class_id">
                                @if(count($classes))
                                    @foreach($classes as $class)
                                        <option value="{{$class->class_id}}">{{$class->class_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="control-label col-lg-1">Section</label>
                        <div class="col-lg-3">
                            <select class="form-control" name="section_id" disabled="disabled">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">Term</label>
                        <div class="col-lg-3">
                            <select class="form-control" name="term">
                                <option value="">select</option>
                                @if(count($terms))
                                    @foreach($terms as $term)
                                        <option value="{{$term}}">{{$term}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="control-label col-lg-1">Session</label>
                        <div class="col-lg-3">
                            <select class="form-control" name="session">
                                <option value="">select</option>
                                @for($i=(date('Y')-1); $i<=(date("Y")+10); $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">No of Classes</label>
                        <div class="col-lg-3">
                            <input type="number" class="form-control" name="noOfClass"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-3">
                            <input type="submit" class="btn btn-primary" value="Save"/>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </section>
            <section class="panel">
                <header class="panel-heading">
                    List Total Class
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->
                            
                         </span>

                </header>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>CLass</th>
                                <th>Section</th>
                                <th>Term</th>
                                <th>Session</th>
                                <th>No of Class</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($totalClasses))
                                @foreach($totalClasses as $i => $c)
                                    <tr>
                                        <td>{{($i+1)}}</td>
                                        <td>{{$c->getClass->class_name or ''}}</td>
                                        <td>{{$c->getSection->section_name or ''}}</td>
                                        <td>{{$c->term}}</td>
                                        <td>{{$c->session}}</td>
                                        <td>{{$c->no_of_class}}</td>
                                        <td><a class="delTotalClass" href="{{url('school/delete-total-class/'.$c->id)}}"><i class="fa fa-trash-o"></i> Delete</a>
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
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/totalclass.js"></script>
@stop
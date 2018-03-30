@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Exam Rules
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    {{Form::open(array('url'=>'settings/update-exam-rules','class'=>'cmxform form-horizontal','id'=>'examRulesFrm'))}}
                        @if(count($terms))
                            @foreach($terms as $term)
                                @if(!empty($termRules->{$term}))

                                <div class="form-group">
                                    <label class="control-label col-lg-3">{{$term}}</label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" name="term_rules[{{trim($term)}}]" value="<?php echo $termRules->{trim($term)}; ?>" />
                                    </div>
                                    <span>( Percentage of number taken from each Term)</span>
                                </div>
                                @else
                                <div class="form-group">
                                    <label class="control-label col-lg-3">{{$term}}</label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" name="term_rules[{{trim($term)}}]" value="" />
                                    </div>
                                    <span>( Percentage of number taken from each Term)</span>
                                </div>
                                @endif
                            @endforeach
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                            </div>
                        @else
                            No Terms Found.
                            <a href="{{url('school/general')}}">Click Here To Create Terms</a>
                        @endif
                    {{Form::close()}}
                </div>
            </section>
        </div>
    </div>
</section>
@stop
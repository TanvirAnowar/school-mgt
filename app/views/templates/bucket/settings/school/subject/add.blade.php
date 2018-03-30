@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add New Subject Information
                           <!-- <span class="tools pull-right">
                                <a class="fa fa-chevron-down" href="javascript:;"></a>
                                <a class="fa fa-cog" href="javascript:;"></a>
                                <a class="fa fa-times" href="javascript:;"></a>
                             </span>-->
                </header>
                <div class="panel-body">
                    <div class="form">
                        <!--<form class="cmxform form-horizontal " id="signupForm" method="get" action="#">-->
                        {{Form::open(array('url'=>'school/save-subject','method'=>'post','id'=>'subjectForm','class'=>'cmxform form-horizontal'))}}

                            <input type="hidden" name="refurl" value="{{{url('school/subject')}}}"/>
                            <div class="form-group ">
                                <label for="subject_name" class="control-label col-lg-3">Subject Name <small>(Required)</small></label>
                                <div class="col-lg-6">
                                    <input list="searchSubject" class="form-control" id="subject_name" name="subject_name" type="text" required />
                                    @if(count($subjectSuggestions))
                                    <datalist id="searchSubject" style="width:150px;">
                                        @if(count($subjectSuggestions))
                                            @foreach($subjectSuggestions as $subject)
                                                <option value="{{{$subject->subject_name}}}">{{{$subject->subject_name}}}</option>
                                            @endforeach
                                        @endif
                                    </datalist>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="class_id" class="control-label col-lg-3">Class <small>(Required)</small></label>
                                <div class="col-lg-6">
                                    <select class="form-control-select2" name="class_id" style="width:150px !important;" required>
                                        <option value="">-- Select --</option>
                                        @if(count($classes))
                                            @foreach($classes as $class)
                                                <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="group_id" class="control-label col-lg-3">Group <small>(Required)</small></label>
                                <div class="col-lg-6">
                                    <select class="form-control-select2" name="group_id" style="width:150px !important;" required>
                                        <option value="">-- Select --</option>
                                        @if(count($groups))
                                            @foreach($groups as $group)
                                                <option value="{{{$group->group_id}}}">{{{$group->group_name}}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="display_order" class="control-label col-lg-3">Display Order</label>
                                <div class="col-lg-6">
                                    <select class="form-control-select2" name="display_order" style="width:150px !important;" required>
                                        <option value="">-- Select --</option>
                                        @for($i=1;$i<=20;$i++)
                                            <option value="{{{$i}}}">{{{$i}}}</option>
                                        @endfor
                                    </select>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="subject_status" class="control-label col-lg-3">Subject Status <small>(Required)</small> <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" type="button" data-original-title="1st subject is common subject for all group, 2nd subject is group specific subjects, 3rd subject is group specific selective subject, i,e. Higher math, Biology"><i class="fa fa-info-circle"></i></a></label>
                                <div class="col-lg-6">
                                    <select class="form-control-select2" name="subject_status" style="width:150px !important;" required>
                                        <option value="1">Default</option>
                                        <option value="1">1st Subject</option>
                                        <option value="2">2nd Subject</option>
                                        <option value="3">3rd Subject</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="subject_initial" class="control-label col-lg-3">Subject Initial <small>(Optional)</small></label>
                                <div class="col-lg-6">
                                    <input class=" form-control" id="subject_initial" name="subject_initial" type="text" required/>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="subject_code" class="control-label col-lg-3">Subject Code <small>(Required)</small></label>
                                <div class="col-lg-6">
                                    <input class=" form-control" id="subject_code" name="subject_code" type="text" required/>
                                </div>
                            </div>
                            <!-- Term wise subject mark assign -->
                            @if(empty($terms[0]))
                             <div class="form-group ">
                              <label for="full_mark" class="control-label col-lg-3">Subject Full Mark <small>(Required)</small></label>
                                <div class="col-lg-6">
                                   <em> No Term Defined !</em>
                                </div>
                              </div>
                            @else
                            <div class="form-group">
                                <div class="col-lg-3 col-lg-offset-3">
                                    <input type="checkbox" name="show_pass_mark" class="showPassMark"/> Show pass Mark
                                </div>
                            </div>
                            @foreach($terms as $term)

                            <div class="form-group">
                                <label for="full_mark" class="control-label col-lg-3">Subject Full for {{ $term }} <small>(Required)</small></label>
                                <div class="col-lg-1">
                                    <input class=" form-control" id="full_mark" name="full_mark[{{ $term }}]" type="text" required/> 
                                    
                                </div>
                                
                                <div class="passMark hidden">
                                    <label for="full_mark" class="control-label col-lg-3">Pass mark for {{ $term }} <small>(Required)</small></label>
                                    <div class="col-lg-1">
                                        <input class=" form-control" id="pass_mark" name="pass_mark[{{ $term }}]" type="text"/>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div class="form-group">
                                <label for="subject_dependency" class="control-label col-lg-3">Subject Dependancy</label>
                                <div class="col-lg-1">
                                    <input class="form-control" id="subject_dependency" name="subject_dependency" type="checkbox" value="1"/>
                                    <small>(optional)</small>
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
<script src="{{ $theme }}assets/flot-chart/jquery.flot.tooltip.min.js"></script>
<script type="text/javascript">

    if($(".showPassMark").attr('checked'))
    {
         $("div.passMark").removeClass('hidden');     
    }else{
         $("div.passMark").addClass('hidden');    
    }

    $(".showPassMark").change(function(){
        var obj = $(this);
        if(obj.attr('checked'))
        {
           $("div.passMark").removeClass('hidden');     
        }else{
           $("div.passMark").addClass('hidden');     
        }
    });
</script>
@stop
@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <!-- code here -->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Details of {{{$student->name}}}
                     <span class="tools pull-right">
                     <!--    <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>-->
                         <a href="{{url('student/edit/'.$student->id)}}">Edit</a>

                      </span>
                </header>
                <div class="panel-body">
                {{Form::open(array('url'=>'student/update-student','method'=>'post','enctype'=>'multipart/form-data','id'=>'studentAddForm','class'=>'cmxform form-horizontal'))}}

                        <div class="form col-lg-10">
                        <?php $page = Request::get('page'); ?>
                        <input type="hidden" name="refurl" value="{{{url('student/lists')}}}{{{ (!empty($page))? '?page='.$page : ''}}}"/>
                        <div class="form-group">
                            <label for="student_id" class="control-label col-lg-3">Student Id <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->student_id}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="class_id" class="control-label col-lg-3">Class <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->getClass->class_name}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label col-lg-3">Student Name <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->name}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nationality" class="control-label col-lg-3">Nationality <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->nationality}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dob" class="control-label col-lg-3">Date of Birth <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{Helpers::dateTimeFormat("j F,Y",$student->dob)}}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="blood_group" class="control-label col-lg-3">Blood Group <small>(Required)</small></label>
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->blood_group}}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('gender',"Gender",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->gender}}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::Label('father_name', "Father's Name", array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->father_name}}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::Label('father_profession', "Father's Profession", array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->father_profession}}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::Label('father_cell_phone', "Father's Phone", array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->father_cell_phone}}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Father's Photo</label>
                            <div class="controls col-md-2">
                                <div class="fileupload-new thumbnail">
                                    @if(!empty($student->father_photo) && file_exists($student->father_photo))
                                        <img alt="" src="{{{url('/').'/'.$student->father_photo}}}"/>
                                    @else
                                        <img alt="" src="{{$theme}}images/placeholder.gif"/>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::Label('mother_name', "Mother's Name", array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->mother_name}}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::Label('mother_profession', "Mother's Profession", array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->mother_profession}}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::Label('mother_cell_phone', "Mother's Phone", array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->mother_cell_phone}}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Mother's Photo</label>
                            <div class="controls col-md-2">
                                <div class="fileupload-new thumbnail">
                                    @if(!empty($student->mother_photo) && file_exists($student->mother_photo))
                                        <img alt="" src="{{{url('/').'/'.$student->mother_photo}}}"/>
                                    @else
                                        <img alt="" src="{{$theme}}images/placeholder.gif"/>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::Label('present_address', "Present Address", array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->present_address}}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::Label('permanent_address', "Present Address", array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->permanent_address}}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::Label('no_of_child', "No of Child", array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->no_of_child}}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::Label('child_position', "Child Position", array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->child_position}}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::Label('no_of_sibling', "No of sibling", array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                <span class="form-control">{{{$student->no_of_sibling}}}</span>
                            </div>
                        </div>

                        <hr/>
                        <h4>Additional Info</h4>
                        @if(count($options))
                        @foreach($options as $i=> $option)
                            <div class="form-group">
                                {{Form::Label($option->key, $option->key, array('class'=>'control-label col-lg-3'))}}
                                <div class="col-lg-6">
                                    <span class="form-control">{{{$option->value}}}</span>
                                </div>
                            </div>
                        @endforeach
                        @endif

                        <!--<div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">

                                <button class="btn btn-primary" type="submit">Save</button>
                                <button class="btn btn-default" type="reset">Clear</button>
                            </div>
                        </div>-->

                    </div>

                    <div class="form col-lg-2">
                        <div class="form-group">
                            <div class="fileupload-new thumbnail">

                                @if(!empty($student->photo) && file_exists($student->photo))
                                <img alt="" src="{{{url('/').'/'.$student->photo}}}"/>
                                @else
                                <img alt="" src="{{$theme}}images/placeholder.gif"/>
                                @endif
                            </div>

                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </section>
        </div>
    </div>
</section>
<script src="{{$theme}}js/custom/common.js"></script>
@stop
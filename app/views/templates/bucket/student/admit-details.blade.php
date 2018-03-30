@extends('templates.bucket.bucket')


@section('wrapper')
<section class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Admit Details
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->

                         </span>

                </header>
                <div class="panel-body">
                    <div class="form">
                        {{Form::model($admitForm,array('url'=>'student/update-admit-form','enctype'=>'multipart/form-data', 'class'=>'cmxform form-horizontal'))}}
                        <input type="hidden" name="refurl" value="{{{url('student/admit-list')}}}"/>
                        <div class="form-group">
                            {{Form::label('session','Session',array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-2">
                                {{Form::text('session',$admitForm->session,array('class'=>'form-control','required'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('name',"Student's name",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                {{Form::text('name',$admitForm->name,array('class'=>'form-control','required'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('exam_roll',"Exam Roll",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-2">
                                {{Form::text('exam_roll',$admitForm->exam_roll,array('class'=>'form-control','required'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('exam_date',"Exam Date",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-2">
                                {{Form::text('exam_date',Helpers::dateTimeFormat("j F,Y",$admitForm->exam_date),array('class'=>'form-control form-control-inline input-medium default-date-picker','required'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('exam_venue',"Exam Venue",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                {{Form::text('exam_venue',$admitForm->exam_venue,array('class'=>'form-control','required'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('previous_school',"Previous School",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                {{Form::text('previous_school',$admitForm->previous_school,array('class'=>'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('father_name',"Father's name",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                {{Form::text('father_name',$admitForm->father_name,array('class'=>'form-control','required'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('mother_name',"Mother's name",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                {{Form::text('mother_name',$admitForm->mother_name,array('class'=>'form-control','required'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('mobile_number',"Mobile no",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-3">
                                {{Form::text('mobile_number',$admitForm->mobile_number,array('class'=>'form-control','required'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('phone',"Phone No",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-3">
                                {{Form::text('phone',$admitForm->phone,array('class'=>'form-control'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('present_address',"Present Address",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                {{Form::text('present_address',$admitForm->present_address,array('class'=>'form-control','required'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('nationality',"Nationality",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-3">
                                {{Form::text('nationality',$admitForm->nationality,array('class'=>'form-control','required'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('dob',"Date of Birth",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-2">
                                {{Form::text('dob',$admitForm->dob,array('class'=>'form-control student-dob','required'))}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('religion',"Religion",array('class'=>'control-label col-lg-3'))}}

                            <div class="col-lg-6">
                                <select class="form-control-select2" name="religion" style="width:150px !important;" required>
                                    @foreach($religion as $r)
                                        @if($r == $admitForm->religion)
                                        <option selected="selected" value="{{{$r}}}">{{{$r}}}</option>
                                        @else
                                        <option value="{{{$r}}}">{{{$r}}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('gender',"Gender",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                <select class="form-control-select2" name="gender" style="width:150px !important;" required>
                                    @foreach($gender as $g)
                                        @if($g == $admitForm->gender)
                                            <option selected="selected" value="{{{$g}}}">{{{$g}}}</option>
                                        @else
                                            <option value="{{{$g}}}">{{{$g}}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('status',"Status",array('class'=>'control-label col-lg-3'))}}
                            <div class="col-lg-6">
                                <select class="form-control-select2" name="status" style="width:150px !important;" required>
                                    @foreach($statuses as $status)
                                    @if($status == $admitForm->status)
                                    <option selected="selected" value="{{{$status}}}">{{{$status}}}</option>
                                    @else
                                    <option value="{{{$status}}}">{{{$status}}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-3">Image</label>
                            <div class="controls col-md-2">
                                <div class="fileupload-new thumbnail">
                                    @if(!empty($teacher->photo))
                                    <img alt="" src="{{{url().'/'.$admit->photo}}}" />
                                    @else
                                    <img alt="" src="{{$theme}}images/placeholder.gif"/>
                                    @endif

                                </div>
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Browse file</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="file"/>
                                        </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <h4>Additional Info</h4>
                        <div class="form-group col-lg-6">
                            <a class="btn btn-primary newAddBtn" id="addParam" href="#"><i class="fa fa-plus-circle"> Add More</i></a>
                            <table width="100%" id="paramTbl">
                                <thead>
                                <tr>
                                    <th>Field Name</th>
                                    <th>Value</th>
                                    <th><i class="fa fa-trash-o"></i></th>
                                </tr>
                                </thead>
                                <tbody>


                                    @if(count($options))
                                        @foreach($options as $i=> $option)

                                            <tr>
                                                <td><input type="text" name="key[]" class="form-control col-lg-2" value="<?php echo $option->key; ?>"/></td>
                                                <td><input class="paramVal form-control col-lg-2" type="text" name="value[]" value="<?php echo $option->value; ?>"/></td>
                                                <td><a class="delParam" href="#"><i class="fa fa-minus-circle"></i></a></td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <input type="hidden" name="id" value="{{{$admitForm->admit_form_id}}}"/>
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
<script src="{{$theme}}js/custom/common.js"></script>
@stop
@extends('templates.bucket.bucket')
@section('wrapper')
<script>
   var teacherSmsOption = {{$teacher_sms_option}};
   var studentSmsOption = {{$student_sms_option}};
   var noticeSmsOption  = {{$notice_sms_option}};
</script>
<section class="wrapper">
   <!-- code here -->
   <div class="row">
      <div class="col-lg-12">
         <section class="panel">
            <header class="panel-heading">
               Add New Group
            </header>
            <div class="panel-body">
               <div class="form">
                  {{Form::open(array('url'=>'sms/save-group','method'=>'post','id'=>'groupAddFrm','class'=>'cmxform form-horizontal'))}}
                  <input type="hidden" name="refurl" value="{{{url('sms/groups')}}}"/>
                  <div class="form-group">
                     <label for="group_name" class="control-label col-lg-3">Group Name <small>(Required)</small></label>
                     <div class="col-lg-6">
                        <input class=" form-control" id="group_name" name="group_name" type="text" required/>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="group_type" class="control-label col-lg-3">Group Type <small>(Required)</small></label>
                     <div class="col-lg-6">
                        <select class=" form-control" id="group_type" name="group_type" type="text" required>
                           <option value="">Select</option>
                           @foreach($types as $type)
                           <option value="{{{$type}}}">{{{$type}}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-lg-12">
                  <div class="hidden student">
                  <div class="form-group">
                     <label for="class" class="control-label col-lg-3">Class <small>(Required)</small></label>
                     <div class="col-lg-3">
                        <select class="form-control" id="class" name="class_id" >
                           <option value="">Select</option>
                           @foreach($classes as $class)
                           <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                           @endforeach
                        </select>
                     </div>
                   </div>
                  <div class="form-group">
                     <label for="section" class="control-label col-lg-3">Section <small>(Required)</small></label>
                     <div class="col-lg-3">
                        <select class="form-control" id="section" name="section_id" type="text" disabled>
                        </select>
                     </div>
                  </div>

                           <div class="form-group">
                              <label for="session" class="control-label col-lg-3">Session</label>
                              <div class="col-lg-3">
                                 <select class="form-control" id="class" name="session">
                                 <?php $fromYear = (date('Y')-2); $toYear = (date('Y')+1);?>
                                 @for($y=$fromYear; $y<=$toYear; $y++)
                                 <option @if($y==date('Y')) selected="selected" @endif value="{{$y}}">{{$y}}</option>
                                 @endfor
                                 </select>
                              </div>
                           </div>

                           <div class="form-group">
                              <div class="col-lg-offset-3 col-lg-2">
                                 <input id="searchRegisteredStudent" class="btn btn-primary" type="button" value="Search" />
                              </div>
                           </div>
</div>
                     </div>
                     <div class="form-group col-lg-12">
                        <div id="student" style="float:left;" class="hidden student col-lg-6">
                           <div id="searchRegStudentListScroller">
                              <table class="searchRegStudentList display table table-bordered table-striped" id="dynamic-table">
                                 <thead>
                                    <tr>
                                       <th style="text-align: left;" colspan="3"><button type="button" class="selectAll btn btn-info">Select All</button></th>

                                       <th  colspan="1" style="text-align: center;">
                                          <input class="btn btn-primary includeBtn" style="width:120px;" value="Transfer >>" />
                                       </th>
                                    </tr>
                                 </thead>
                                 <thead>
                                    <tr>
                                       <th>Class Roll</th>
                                       <th>Student Name</th>
                                       <th>Class</th>
                                       <th>Section</th>
                                       <th>Mobile Number</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        
                        <input id="loadTeachersBtn" class="btn btn-primary teacher hidden" style="float: right; margin-right: 636px;" type="button" value="Load Teachers" />

                        <div style="float:left;" id="teacher" class="hidden teacher col-lg-6">
                           <div id="loadTeacherListScroller">
                              <table class="loadTeacherList display table table-bordered table-striped" id="dynamic-table">
                                 <thead>
                                    <tr>
                                       <th colspan="2"  style="text-align: center;"><button type="button" class="selectAll btn btn-info">Select All</button></th>
                                       <th  colspan="1"  style="text-align: center;">
                                          <a class="btn btn-primary excludeBtn" style="width:85px;"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>
                                       </th>
                                       <th  colspan="1" style="text-align: center;">
                                          <input class="btn btn-primary includeBtn" style="width:120px;" value="Transfer >>" />
                                       </th>
                                    </tr>
                                 </thead>
                                 <thead>
                                    <tr>
                                       <th>Sl</th>
                                       <th colspan="2">Teacher Name</th>
                                       <th>Mobile Number</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <div style="float:left;" id="other" class="hidden other col-lg-6">
                           <div id="loadTeacherListScroller" style="width:96%; float: left;">
                              <h3>Add Member</h3>
                              <p>
                                 <label>Name</label>
                                 <input type="text" name="other_name" class="form-control"/>
                              </p>
                              <p>
                                 <label>Cell Number</label>
                                 <input type="number" name="other_phone" class="form-control"/>
                              </p>
                           </div>
                           <br/>
                           <div class="form-group col-lg-1 text-center" style="float: right; margin-top: 60px;" >
                              <input class="btn btn-primary includeBtn" style="width:35px;" value=">" />
                              <br/>
                              <br/>
                              <br/>
                              <a class="btn btn-primary excludeBtn" style="width:35px;"><i class="fa fa-trash-o"></i></a>
                           </div>
                        </div>
                        <div style="float: right;" class="form-group col-lg-6 hidden number-list">
                           <table class="includeList display table table-bordered table-striped" id="dynamic-table">
                              <thead>
                                 <tr>
                                    <th colspan="3">Included List</th>
                                    <th  colspan="1"  style="text-align: center;">
                                                                              <a class="btn btn-primary excludeBtn" style="width:85px;"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>
                                                                           </th>
                                    <th collapse="1" style="text-align: center" ><button class="btn btn-success btn-md" style="height: 30px;line-height: 18px;" type="submit">Save Group</button></th>
                                 </tr>
                              </thead>
                              <thead>
                                 <tr>
                                    <th>Sl</th>
                                    <th  colspan="2">Name</th>
                                    <th>Mobile Number</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                  {{Form::close()}}
               </div>
            </div>
         </section>
      </div>
   </div>
</section>
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/sms.js"></script>
@stop


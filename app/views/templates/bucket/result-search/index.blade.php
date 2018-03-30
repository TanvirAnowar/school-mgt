@extends('templates.bucket.bucket')
@section('wrapper')
<section class="wrapper">
   {{{Helpers::showMessage()}}}
   <div class="row">
      <div class="col-lg-12">
         <section class="panel">
            <header class="panel-heading">
               REsult Search
            </header>
            <div data-ng-app="reportApp" ng-controller="ResultSearchController">
               <div class="panel-body" ng-cloak>
                  {{Form::open(array('url'=>'report','id'=>'getReportFrm','target'=>'_blank','class'=>'cmxform form-horizontal'))}}
                  <div class="form-group">
                     {{--
                     <div class="position-center ">
                        --}}
                        <label class="control-label col-md-1">Search</label>
                        <div class="col-lg-3">
                           <select name="class_id" ng-model="searchTypeModel" class="form-control" ng-change="searchType()" required>
                              <option value="position-in-class">Position In Class</option>
                              <option value="position-section">Position In Section</option>
                              {{--
                              <option value="position-session">Position In Session</option>
                              --}}
                              <option value="all-passed-student">All Passed Student</option>
                              <option value="all-failed-student">All Failed Student</option>
                             {{-- <option value="passed-in-subject">Passed In Subject</option>
                              <option value="failed-in-subject">Failed In Subject</option>
                              <option value="gpa-per-subject">Subject Wise GPA</option>
                              <option value="cgpa">Total CGPA</option>--}}
                           </select>
                        </div>
                        {{--
                     </div>
                     --}}
                  </div>
                  <div class="form-group">
                     <label class="control-label col-md-1">Session</label>
                     <div class="col-md-3">
                        <select ng-model="sessionModel" name="session" class="form-control" required>
                        <?php $from = (date('Y')-2); $to = (date('Y')+1); ?>
                        @for($i = $from; $i<=$to; $i++)
                        <option value="{{{$i}}}" @if(date('Y') == $i) selected @endif >{{{$i}}} </option>
                        @endfor
                        </select>
                     </div>
                     <label class="control-label col-md-1">Class</label>
                     <div class="col-lg-3">
                        <select class="form-control" ng-model="classModel" ng-change="searchType()" required>
                           @if(count($classes))
                           @foreach($classes as $class)
                           <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                           @endforeach
                           @endif
                        </select>
                     </div>
                     <label class="control-label col-md-1">Section</label>
                     <div class="col-md-3">
                        <select ng-model="sectionModel" class="form-control" ng-disabled="sectionDisabled" >
                           <option ng-repeat="section in sectionList" value="@{{ section.section_id }}">@{{ section.section_name }} - @{{ section.shift_name }}</option>
                           <option value="all">All Section</option>
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="control-label col-md-1">Term</label>
                     <div class="col-md-3">
                        <select ng-model="termModel" name="term" class="form-control" required>
                           @if(count($terms))
                           @foreach($terms as $term)
                           <option value="{{{$term}}}">{{{$term}}}</option>
                           @endforeach
                           @endif
                        </select>
                     </div>
                     <label class="control-label col-md-1">Subject</label>
                     <div class="col-md-3">
                        <select ng-model="subjectModel" class="form-control"  ng-disabled="subjectDisabled"  required>
                           <option ng-repeat="subject in subjectList" value="@{{ subject.subject_id }}">@{{ subject.subject_name }} - @{{ subject.subject_id }}</option>
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="position-center ">
                        <div class="text-center">
                           <input  ng-click="loadStudents()" type="button" id="loadStudent" class="btn btn-primary" value="Search"/>
                        </div>
                     </div>
                  </div>
                  <div ng-hide="hideTable">
                     {{--
                     <div>
                        --}}
                        <table class="studentReportList display table table-bordered table-striped" id="dynamic-table">
                           <!-- Table head -->
                           <thead>
                              <tr>
                                 <td style="background:#F4F6F6;" colspan="7">
                                    <pagination
                                       total-items="bigTotalItems"
                                       ng-model="bigCurrentPage"
                                       max-size="maxSize"
                                       boundary-links="true"
                                       rotate="false"
                                       num-pages="numPages"
                                       ng-change="pageChanged()">
                                    </pagination>
                                    {{--
                                    <div class="form-group">
                                       <input ng-model="customItem" data-ng-change="searchData()" class="form-control" type="text" placeholder="Search User(s) by Email">
                                    </div>
                                    --}}
                                 </td>
                              </tr>
                              <!-- Table row -->
                              <tr>
                                 <th ng-repeat="head in tableHeads">@{{ head }} </th>
                              </tr>
                              <!-- End table row -->
                           </thead>
                           <!-- End table head -->
                           <!-- Table body -->
                           <tbody>
                              <!-- Table row -->
                              <tr ng-repeat="x in content" ng-show="tableDataGroup['position-in-class'] || tableDataGroup['position-section']">
                                 <td>
                                    @{{x.position}}
                                 </td>
                                 <td>
                                    @{{x.name}}
                                 </td>
                                 <td>
                                    @{{x.class_roll}}
                                 </td>
                                 <td>
                                    @{{x.section_name}}
                                 </td>
                                 <td>
                                    @{{x.total_mark}}
                                 </td>
                                 <td>
                                    @{{x.cgpa}}
                                 </td>
                              </tr>
                              <tr ng-repeat="x in content" ng-show="tableDataGroup['all-passed-student']">
                                 <td>
                                    @{{x.name}}
                                 </td>
                                 <td>
                                    @{{x.class_roll}}
                                 </td>
                                 <td>
                                    @{{x.section_name}}
                                 </td>
                                 <td>
                                    @{{x.total_mark}}
                                 </td>
                                 <td>
                                    @{{x.cgpa}}
                                 </td>
                              </tr>
                              <tr ng-repeat="x in content" ng-show="tableDataGroup['all-failed-student']">
                                 <td>
                                    @{{x.name}}
                                 </td>
                                 <td>
                                    @{{x.class_roll}}
                                 </td>
                                 <td>
                                    @{{x.section_name}}
                                 </td>
                                 <td>
                                    @{{x.total_mark}}
                                 </td>
                              </tr>
                              <!-- End table row -->
                           </tbody>
                           <tfoot>
                              <tr>
                                 <td style="background:#F4F6F6;" colspan="7">
                                    <pagination
                                       total-items="bigTotalItems"
                                       ng-model="bigCurrentPage"
                                       max-size="maxSize"
                                       boundary-links="true"
                                       rotate="false"
                                       num-pages="numPages"
                                       ng-change="pageChanged()">
                                    </pagination>
                                 </td>
                              </tr>
                           </tfoot>
                           <!-- End table body -->
                        </table>
                        {{--
                     </div>
                     --}}
                  </div>
                  {{Form::close()}}
               </div>
            </div>
            {{--modal--}}

            <div id="myModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Confirmation</h4>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to save changes you made to document before closing?</p>
                            <p class="text-warning"><small>If you don't save, your changes will be lost.</small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
                   {{--modal--}}
         </section>
      </div>
   </div>
</section>
<script type="text/javascript" src="{{$theme}}js/lib/angular.js"></script>
<script type="text/javascript" src="{{$theme}}js/lib/angular-ui-bootstrap.min.js"></script>
<script type="text/javascript" src="{{$theme}}js/lib/bootbox.js"></script>
<script type="text/javascript" src="{{$theme}}js/lib/ngBootbox.min.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/result-search-ajs.js"></script>
@stop
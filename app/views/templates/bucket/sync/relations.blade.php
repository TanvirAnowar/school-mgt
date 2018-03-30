@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <!-- code here -->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sync Students
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    <div class="col-lg-12">
                        <form action="{{url('sync/save-import')}}" method="post" class="form-horizontal">
                        <h3>Student Columns</h3>
                        <ul>
                            <li> 
                                <div class="form-group">
                                    <div class="col-lg-3"><strong>System Column</strong></div>
                                    <div class="col-lg-3"><strong>Excel Column</strong></div>
                                    <div class="col-lg-3"><strong>Default Value</strong></div>
                                </div>
                            </li>
                            @if(count($students))
                                @foreach($students as $student)
                                    @if(!in_array($student,array("id","admit_test_mark","no_of_child","child_position","no_of_sibling","options","student_type","class_id","section_id","updated_at","created_at","deleted_at","vendor_id")))
                                        <li> 
                                            <div class="form-group">
                                                <div class="col-lg-3">{{$student}}</div>
                                                <div class="col-lg-3">
                                                    <select name="bind_student[{{$student}}]">
                                                        <option value="null">Null</option>
                                                        @foreach($sheet_columns as $i=> $column)
                                                            <option value="{{$i}}">{{$column}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="text" class="text-right" name="default_student[{{$student}}]" value="null"/>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                        <h3>Registration Columns</h3>
                        <ul >
                            <li> 
                                <div class="form-group">
                                    <div class="col-lg-3"><strong>System Column</strong></div>
                                    <div class="col-lg-3"><strong>Excel Column</strong></div>
                                    <div class="col-lg-3"><strong>Default Value</strong></div>
                                </div>
                            </li>
                            @if(count($registrations))
                                @foreach($registrations as $reg)
                                    @if(!in_array($reg,array("id","reg_id","student_id","active_reg","promotion_status","updated_at","created_at","deleted_at")))
                                        <li>
                                            <div class="form-group">
                                                <div class="col-lg-3">{{$reg}}</div>
                                                <div class="col-lg-3">
                                                    <select name="bind_reg[{{$reg}}]">
                                                        <option value="null">Null</option>
                                                        @foreach($sheet_columns as $i=> $column)
                                                            <option value="{{$i}}">{{$column}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="text" class="text-right" name="default_reg[{{$reg}}]" value="null"/>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                            <input type="submit" class="btn btn-primary" value="Import"/>
                            <input type="hidden" name="filename" value="{{$filename}}"/>
                        </form>
                        
                    </div>
                    
                </div>
            </section>
        </div>
    </div>
</section>
@stop
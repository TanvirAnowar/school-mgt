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
                {{Form::open(array('url'=>'sync/save-student','class'=>'', 'id'=>'syncFrm','method'=>'post'))}}
                    <table class="syncTbl display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th>Class:
                                <select name="class_id" class="form-control" required>
                                    @if(count($classes))
                                            <option value=""></option>
                                        @foreach($classes as $class)
                                            <option value="{{$class->class_id}}">{{$class->class_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                </th>
                                <th>Section:
                                <select name="section_id" class="form-control" required>

                                </select>
                                </th>
                                <th><input class="btn btn-primary"  type="submit" value="Save" /></th>
                            </tr>
                        </thead>
                        <thead>
                            @if($old_columns)
                            <tr>
                                @foreach($old_columns as $value)

                                <th>{{$value}}
                                    @if(count($new_columns))
                                    <select name="columns[{{$value}}]">
                                        <option value="">Select</option>
                                        @foreach($new_columns as $col)
                                        <option value="{{$col}}">{{$col}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </th>


                                @endforeach
                            </tr>
                            @endif
                        </thead>
                        <tbody>
                            @if($students)
                            @foreach($students as $value)
                            <tr data-id="{{$value->student_id}}">
                                    @foreach($old_columns as $v)
                                    <td>
                                        <?php echo  $value->{$v}; ?>

                                    </td>
                                    @endforeach


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
<script src="{{$theme}}js/custom/Classes.js"></script>
<script src="{{$theme}}js/custom/student.js"></script>
<script src="{{$theme}}js/custom/sync.js"></script>
@stop
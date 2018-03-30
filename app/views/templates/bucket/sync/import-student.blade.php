@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <!-- code here -->
    {{{Helpers::showMessage()}}}
    {{Session::get('message')}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Import Students
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    {{Form::Open(array('url'=>'sync/import-student','class'=>'cmxform form-horizontal','enctype'=>'multipart/form-data', 'method'=>'post'))}}
                        <div class="form-group">
                            <label class="control-label col-lg-3">Select File:</label>
                            <div class="col-lg-3">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Browse</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="students" required/>
                                        </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label class="control-label col-lg-3">Shift</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="shift_id" required>
                                    <option value="">Select</option>
                                    @if(count($shifts))
                                        @foreach($shifts as $shift)
                                            <option value="{{{$shift->shift_id}}}">{{{$shift->shift_name}}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <div class="col-lg-3 col-lg-offset-3">
                                <input type="submit" class="btn btn-primary" value="Upload"/>
                            </div>
                        </div>
                    {{Form::close()}}
                </div>
            </section>

            <section class="panel">
                <header class="panel-heading">
                    Imported Students List
                </header>
                <div class="panel-body">
                    <table class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Class Code</th>
                                <th>System Class </th>
                                <th>Given Section</th>
                                <th>System Section</th>
                                <th>Phone No</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($saved))
                                @foreach($saved as $s)
                                    <tr>
                                        <td>{{{$s['name']}}}</td>
                                        <td>{{{$s['class_code']}}}</td>
                                        <td>{{{$s['class']}}}</td>
                                        <td>{{{$s['given_section']}}}</td>
                                        <td>{{{$s['section']}}}</td>
                                        <td>{{{$s['phone']}}}</td>
                                        <td>

                                            @if($s['status'] == 1)
                                                <span class="label label-success label-mini">Imported</span>
                                            @elseif($s['status'] == 2)
                                                <span class="label label-warning label-mini">Already Exist</span>
                                            @elseif($s['status'] == 0)
                                                <span class="label label-danger label-mini">Info incomplete</span>
                                            @endif
                                        </td>
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
@stop
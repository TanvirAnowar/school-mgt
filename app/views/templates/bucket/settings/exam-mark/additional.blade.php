@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   Additional Mark Settings
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    <form action="{{{url('settings/save-additional')}}}" id="markTypeFrm" method="post" class="cmxform form-horizontal">
                        <input type="hidden" name="refurl" value="{{{url('settings/additional')}}}"/>
                        <div class="form-group">
                            <label for="aptitudes" class="control-label col-lg-2" >Class</label>
                            <div class="col-lg-2">

                                <select class="form-control-select2" name="aptitude" style="width:150px;">
                                    <option value="">Select</option>
                                    @if(count($classes))
                                        @foreach($classes as $class)
                                            <option value="{{{$class->class_id}}}">{{{$class->class_name}}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-lg-6">

                            <table  class="display table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Aptitude</th>
                                    <th>Weight</th>
                                    <th>Grade</th>

                                </tr>
                                </thead>
                                <tbody>

                                @if(count($aptitudes))
                                    @foreach($aptitudes as $index=>$aptitude)
                                        <tr class="gradeX">
                                            <td>{{{($index + 1)}}}</td>
                                            <td>{{{$aptitude}}}</td>
                                            <td><input type="text" class="form-control col-sm-1"/></td>
                                            <td>

                                                <select class="form-control">
                                                    <option value="">Select Grade</option>
                                                    @if(count($grades))
                                                        @foreach($grades as $key=> $grade)
                                                            <option value="{{{$grade}}}">{{{$key}}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>

                                        </tr>
                                    @endforeach


                                @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Sl</th>
                                    <th>Aptitude</th>
                                    <th>Weight</th>
                                    <th>Grade</th>

                                </tr>
                                </tfoot>
                            </table>

                        </div>


                        <div class="form-group">

                            <div class="col-lg-offset-3 col-lg-4">
                                <button class="btn btn-primary" type="submit">Save</button>

                            </div>
                        </div>
                    </form>

                </div>
            </section>
        </div>
    </div>
</section>
<!--<script type="text/javascript" language="javascript" src="{{$theme}}assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{$theme}}assets/data-tables/DT_bootstrap.js"></script>
<script src="{{$theme}}js/dynamic_table/dynamic_table_init.js"></script>-->
<script type="text/javascript" src="{{$theme}}js/custom/Classes.js"></script>
<script type="text/javascript" src="{{$theme}}js/custom/settings.js"></script>
@stop
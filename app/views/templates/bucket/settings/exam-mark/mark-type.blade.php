@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
{{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Mark Types
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    <form action="{{{url('settings/save-mark-type')}}}" id="markTypeFrm" method="post" class="cmxform form-horizontal">
                        <input type="hidden" name="refurl" value="{{{url('settings/mark-type')}}}"/>
                        <div class="form col-lg-12">
                            <div class="form-group">
                                <label for="mark_type" class="control-label col-lg-3">Mark Type <small>(Required)</small></label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" name="mark_type" required/>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="mark_type_order" class="control-label col-lg-3">Display Order <small>(Required)</small></label>
                                <div class="col-lg-1">
                                    <input type="text" class="form-control" name="mark_type_order" value="{{{count($mark_types)}}}" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3 col-lg-offset-3">
                                    <input type="submit" class="btn btn-primary" value="Add Mark Type" />
                                </div>
                            </div>
                        </div>
                    </form>
                        <div class="form col-lg-12">
                            <table  class="display table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Mark Type</th>
                                    <th>Display Order</th>
                                    <th class="hidden-phone">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($mark_types))
                                    @foreach($mark_types as $index=> $mark_type)
                                        <tr class="gradeX">
                                            <td>{{{($index+1)}}}</td>
                                            <td>{{{$mark_type->mark_type}}}</td>
                                            <td>{{{$mark_type->mark_type_order}}}</td>
                                            <td class="center hidden-phone">
                                                &nbsp;
                                                <a  data-toggle="modal" href="#myModal" data-marktype-id="{{{$mark_type->mark_type_id}}}" data-mark-type-order="{{{$mark_type->mark_type_order}}}" class="grid-action-link edit-mark-type"><i class="fa fa-pencil" title="Edit"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Sl</th>
                                    <th>Mark Type</th>
                                    <th>Display Order</th>
                                    <th class="hidden-phone">Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                </div>


            </section>
        </div>
    </div>
</div>

    <!-- edit shift modal form -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Edit Mark Type</h4>
                </div>
                <div class="modal-body">

                    {{Form::open(array('url'=>'settings/update-mark-type','id'=>'editMarkTypeFrm','method'=>'post'))}}
                    <input type="hidden" name="refurl" value="{{{url('settings/mark-type')}}}"/>
                    <div class="form-group">
                        <label for="mark_type">Mark Type</label>
                        <input type="text" class="form-control" id="mark_type" name="mark_type" value="">

                    </div>
                    <div class="form-group">
                        <label for="mark_type_order">Order</label>
                        <input type="text" class="form-control" id="mark_type_order" name="mark_type_order" value="">
                    </div>
                    <input type="hidden" name="mark_type_id" />
                    <button type="submit" class="btn btn-default">Submit</button>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="{{$theme}}js/custom/settings.js"></script>
@stop
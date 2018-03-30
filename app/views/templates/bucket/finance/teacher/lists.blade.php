@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    List of Teachers
                           <span class="tools pull-right col-lg-3">
                            <!--     <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>-->

                             </span>
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <table class="display table table-bordered table-striped" id="dynamic-table">
                            <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>Teacher Initial</th>
                                <th>Teacher Name</th>
                                <th>Cell no</th>
                                <th>E-mail</th>
                                <th class="hidden-phone">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($teachers))
                            @foreach($teachers as $index => $teacher)
                            <tr class="gradeX">
                                <td>{{($index+1)}}</td>
                                <td>{{{$teacher->name_initial}}}</td>
                                <td>{{{$teacher->name}}}</td>
                                <td>{{{$teacher->cell_phone}}}</td>
                                <td>{{{$teacher->email}}}</td>
                                <td class="center hidden-phone">
                                    <?php $page = Request::get('page'); ?>
                                    <a href="{{{url('finance/invoice/teacher/'.$teacher->id)}}}{{{ (!empty($page))? '?page='.(int)$page : ''}}}" class="grid-action-link"><i class="fa fa-money" title="View Details"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr class="gradeX">
                                <td colspan="6">No Record Found</td>
                            </tr>
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Sl.</th>
                                <th>Teacher Initial</th>
                                <th>Teacher Name</th>
                                <th>Cell no</th>
                                <th>E-mail</th>
                                <th >Action</th>
                            </tr>
                            <tr>
                                <td colspan="6">{{$teachers->links()}}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

</section>
<script src="{{$theme}}js/custom/teacher.js"></script>
@stop
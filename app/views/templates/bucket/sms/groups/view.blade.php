@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <!-- code here -->
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Details - {{{$group->group_name or ''}}}
                    <span class="tools pull-right">
                       <!--   <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>-->

                      </span>
                </header>
                <div class="panel-body">

                    <table class="display table table-bordered table-striped" id="dynamic-table">

                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($members))
                        @foreach($members as $index => $member)

                        <tr>
                            <td>{{($index+1)}}</td>
                            <td>{{$member->name}}</td>
                            <td>{{$member->number}}</td>
                            <td>
                                <a href="{{{$member->id}}}" class="grid-action-link del-groupmember"><i class="fa fa-trash-o" title="Delete"></i></a>
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
<script type="text/javascript" src="{{$theme}}js/custom/group.js"></script>
@stop
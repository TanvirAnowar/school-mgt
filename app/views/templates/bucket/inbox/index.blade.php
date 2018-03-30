@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <!-- code here -->
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Inbox
                    <span class="tools pull-right col-lg-4">
                     <!--     <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      -->

                    {{ Form::open(array('url'=>'inbox/sent-items','class'=>'col-lg-5','method'=>'get')) }}
                    <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-list"></i> Sent Items</button>
                    {{ Form::close() }}

                    {{ Form::open(array('url'=>'inbox/compose','class'=>'col-lg-2','method'=>'get')) }}
                    <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-plus-circle"></i> Compose</button>
                    {{ Form::close() }}

                    </span>
                </header>
                <div class="panel-body">
                    {{Form::Open(array('id'=>'bulkOpFrm'))}}
                    <select name="bulk_action" class="form-control-select2">
                        <option value="">Select operation</option>
                        <option value="Delete">Delete</option>
                    </select>
                    <input type="button" id="bulkDeleteBtn" class="btn btn-primary" value="Submit"/>
                    <table class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                        <tr>
                            <th><input type="checkbox" name="selectAll"/></th>
                            <th>From</th>
                            <th>Subject</th>
                            <th>Date</th>


                        </tr>
                        </thead>
                        <tbody>
                        @if(count(@messages))
                        @foreach($messages as $message)
                        <tr>
                            <td><input class="message_id" type="checkbox" name="message_id[]" value="{{{$message->comment_id}}}"/></td>
                            <td>{{$message->User->username}}</td>
                            <td><a href="{{url('inbox/details/'.$message->discussion_id.'/'.$message->comment_id)}}">{{$message->message}}</a></td>
                            <td>{{Helpers::dateTimeFormat('j F , Y',$message->created_at)}}</td>

                        </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                    {{Form::Close()}}
                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" src="{{$theme}}js/custom/inbox.js"></script>
@stop
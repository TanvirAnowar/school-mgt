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
                    <span class="tools pull-right">
                     <!--     <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      -->
                    {{ Form::open(array('url'=>'inbox/compose','method'=>'get')) }}
                    <button class="btn btn-primary panel-btn" type="submit"><i class="fa fa-plus-circle"></i> Compose</button>
                    {{ Form::close() }}
                    </span>
                </header>
                <div class="panel-body">
                    <h3>{{{$message->subject}}}</h3>
                    <p>
                        {{{$message->details}}}
                    </p>
                    @if($message->attachment != '')
                    <a target="_blank" href="{{{url('inbox/download-attachment/'.urlencode($message->attachment))}}}"><i class="fa fa-paperclip"></i> Download Attachement</a>
                    @endif
                    <hr/>
                    @if(count($message->Comments))
                    <h3>Replies ( {{{ count($message->Comments)}}} )</h3>

                    <ul id="reply-item">
                        @foreach($message->Comments as $comment)
                        <li>
                            <span class="subject">
                                <span class="from">{{{$comment->message}}}</span>
                            </span>
                            <div class="time">{{{$comment->User->username}}} - {{{Helpers::dateTimeFormat('j F, Y',$comment->created_at)}}}</div>
                            @if($comment->attachment != '')
                                <a target="_blank" href="{{{url('inbox/download-attachment/'.urlencode($comment->attachment))}}}"><i class="fa fa-paperclip"></i> {{{$comment->attachment}}}</a>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <h3>No Reply found</h3>

                    @endif
                </div>

            </section>
            <section class="panel">
                <header class="panel-heading">

                    <span class="tools pull-right">
                     <!--     <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      -->
                    </span>
                </header>

                <div class="panel-body">
                    {{Form::Open(array('url'=>'inbox/reply','enctype'=>'multipart/form-data','method'=>'post','class'=>'cmxform form-horizontal','id'=>'replyFrm'))}}
                        <div class="form-group">
                            <label class="control-label col-lg-1">Message:</label>
                            <div class="col-lg-6">
                                <textarea name="message" class="form-control col-lg-6" style="height:180px;resize:none;"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-1">Attachment (optional)</label>
                            <div class="controls col-md-2">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <span class="btn btn-white btn-file">
                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Browse file</span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                <input type="file" class="default" name="attachment"/>
                                                </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-1"></label>
                            <div class="col-lg-3">
                                <input hidden name="discussion" value="{{{$message->discussion_id}}}"/>
                                <input hidden name="receiver" value="{{{$message->sender_id}}}"/>
                                <input hidden name="sender" value="{{{$user->id}}}"/>
                                <input hidden name="url" value="{{{url('inbox/details/'.$message->discussion_id)}}}"/>
                                <input type="submit" class="btn btn-primary" value="Reply"/>
                            </div>
                        </div>
                    {{Form::Close()}}
                </div>
            </section>
        </div>
    </div>
</section>
@stop
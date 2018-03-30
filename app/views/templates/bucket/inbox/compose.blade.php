@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <!-- code here -->
    {{{Helpers::showMessage()}}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Compose Message
                    <span class="tools pull-right">
                     <!--     <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      -->

                    </span>
                </header>
                <div class="panel-body">
                    {{Form::Open(array('id'=>'composeFrm','enctype'=>'multipart/form-data','class'=>'cmxform form-horizontal','method'=>'post','url'=>'inbox/save-message'))}}
                        <div class="form-group">
                            <label class="control-label col-lg-3">To</label>
                            <div class="col-lg-6">
                                <select name="to" class="form-control-select2" style="width:450px;">
                                    <option value="" ></option>
                                    @if(count($receivers))
                                        @foreach($receivers as $receiver)
                                            <option value="{{$receiver->id}}" >{{$receiver->sname or $receiver->tname}} - {{{$receiver->user_type}}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3"></label>
                            <div class="col-lg-6">
                                <div id="userlist">
                                    <ul>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3">Subject</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="subject"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3">Message</label>
                            <div class="col-lg-6">
                                <textarea name="message" class="form-control col-lg-6" style="height:180px;resize:none;"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Attachment (optional)</label>
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
                            <label class="control-label col-lg-3"></label>
                            <div class="col-lg-3">
                                <input type="submit" class="btn btn-primary" value="Send"/>
                            </div>
                        </div>
                    {{Form::Close()}}
                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" src="{{$theme}}js/custom/inbox.js"></script>
@stop
@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    <!-- code here -->
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Send SMS Notice
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body" class="form">

                        <form id="singleSmsFrm" action="{{url('sms/send-notice')}}" method="post" class="cmxform form-horizontal">
                            <div class="form-group">
                                <label class="col-lg-3">Daily SMS LIMIT</label>
                                <label class="col-lg-3">{{$daily_sms_limit}}</label>
                                <label class="col-lg-3">Daily SMS COUNT</label>
                                <label class="col-lg-3">{{$daily_sms_count}}</label>

                            </div>
                            <div class="form-group">
                                <label for="group_name" class="control-label col-lg-3">Select Group <small>(Required)</small></label>
                                <div class="col-lg-3">
                                    <select class="form-control" id="group_name" name="group_name" required>
                                        <option value="">Select</option>
                                        @if(count($groups))
                                            @foreach($groups as $group)
                                                <option value="{{{$group->group_id}}}">{{{$group->group_name}}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="group_name" class="control-label col-lg-3">Message: <small>(Required)</small></label>
                                <div class="col-lg-3">
                                    <textarea maxlength="480" class="form-control" name="message" style="resize:none;width:350px;height:140px;" required ></textarea>
                                    <p>
                                        <label>Characters:</label>
                                        <span id="countMsg">0</span>
                                        <span style="color:tomato;" id="single_smsCount"></span>
                                    </p>
                                </div>

                                <input type="hidden" name="client_id" value="{{$clientid}}"/>
                                <input type="hidden" name="access_token" value="{{$access_token}}"/>
                                <input type="hidden" name="refresh_token" value="{{$refresh_token}}"/>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Send</button>
                                </div>
                            </div>
                        </form>

                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript" src="{{$theme}}js/custom/sms.js"></script>
@stop
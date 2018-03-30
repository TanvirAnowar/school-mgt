@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    General Information
                    <!-- <span class="tools pull-right">
                         <a class="fa fa-chevron-down" href="javascript:;"></a>
                         <a class="fa fa-cog" href="javascript:;"></a>
                         <a class="fa fa-times" href="javascript:;"></a>
                      </span>-->
                </header>
                <div class="panel-body">
                    <div class="form">
                        {{ Form::open(array('id'=>'orgfrm','class'=>'cmxform form-horizontal','enctype'=>'multipart/form-data', 'method'=>'post','url'=>url('school/update-org-info'))) }}
                        <!--<form class="cmxform form-horizontal" id="signupForm" method="get" action="#">-->
                            <div class="form-group ">
                                <label for="vendor_name" class="control-label col-lg-3">Organization Name</label>
                                <div class="col-lg-6">
                                    <input class=" form-control" id="class_name" name="vendor_name" type="text" value="{{{Option::getData('vendor_name')}}}" requierd />
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="vendor_address" class="control-label col-lg-3">Organization Address</label>
                                <div class="col-lg-6">
                                    <input class=" form-control" id="class_name" name="vendor_address" type="text"  value="{{{Option::getData('vendor_address')}}}" required/>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="cemail" class="control-label col-lg-3">Organization E-mail</label>
                                <div class="col-lg-6">
                                    <input class="form-control email" id="cemail" name="vendor_email" type="email" value="{{{Option::getData('vendor_email')}}}" required/>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="vendor_phone" class="control-label col-lg-3">Organization Phone</label>
                                <div class="col-lg-6">
                                    <input class=" form-control number" id="vendor_phone" name="vendor_phone" type="number" value="{{{Option::getData('vendor_phone')}}}" required/>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="vendor_code" class="control-label col-lg-3">Organization Code</label>
                                <div class="col-lg-6">
                                    <input class=" form-control" id="class_name" name="vendor_code" type="text" value="{{{Option::getData('vendor_code')}}}" required/>
                                    <small>If organization doesn't have any code then use this formatted value "{ORG_NAME}_{YEAR_OF_SOFTWARE_INSTALLATION}"</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">&nbsp;</label>
                                <div class="col-lg-6">

                                    <div class="fileupload-new thumbnail">
                                        <?php $vendorLogo = Option::getData('vendor_logo'); ?>
                                        @if(!empty($vendorLogo))
                                        <img alt="" src="{{{url().'/'.$vendorLogo}}}">
                                        @else
                                            <img alt="" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">
                                        @endif

                                    </div>
                                    <input type="file" name="file"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                    <button class="btn btn-default" type="button">Cancel</button>
                                </div>
                            </div>

                       <!-- </form> -->
                       {{ Form::close() }}
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript">
    $("#orgfrm").submit(function(){
         var val = ($("input[name=vendor_phone]").val());
        var pattern = /^[0-9]*$/
        console.log(pattern.test(val));

        if(pattern.test(val))
        {
            return true;
        }else{
            alert('Please enter only number');
            return false;

        }

    });

</script>
@stop
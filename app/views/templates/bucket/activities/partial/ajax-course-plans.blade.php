@if(count($coursePlans))
    @foreach($coursePlans as $plan)
<div class="alert alert-success fade in">

    <strong>{{{$plan->title}}}</strong> <span class="label label-success label-mini">{{{$plan->type}}}</span>
</div>
    @endforeach
@else
<span class="text-center">No record found</span>
@endif


 @if(count($template))
 <?php $i=1; ?>
@foreach($template as $tTemplate)
<tr>
    <td>{{($i)}}</td>
    <td>
        <select class="form-control" name="head[]">
            @foreach($heads as $head)
                @if($tTemplate->head_id == $head->acc_head_id)
                    <option selected="selected" class="{{$head->head_name}}">{{$head->head_name}}</option>
                @else
                    <option class="{{$head->head_name}}">{{$head->head_name}}</option>
                @endif
            @endforeach
        </select>
    </td>
    <td><input class="form-control input-large" name="ref_no[]" type="text" /></td>
    <td><input class="form-control input-large" name="description[]" type="text" /></td>
    <td><input class="amount form-control input-mini text-right" name="amount[]" value="{{$tTemplate->amount}}" type="text"/></td>
    <td><button type="button" class="btn btn-danger remove_transaction_row">Remove</button></td>
</tr>
 <?php $i++; ?>
@endforeach
@else
<tr>
    <td>01</td>
    <td>
        <select class="form-control" name="head[]">
            @foreach($heads as $head)
                <option class="{{$head->head_name}}">{{$head->head_name}}</option>
            @endforeach
        </select>
    </td>
    <td><input class="form-control input-large" name="ref_no[]" type="text" /></td>
    <td><input class="form-control input-large" name="description[]" type="text" /></td>
    <td><input class="amount form-control input-mini text-right" name="amount[]" type="text"/></td>
    <td>&nbsp;</td>
</tr>
@endif
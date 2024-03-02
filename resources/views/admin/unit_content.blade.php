@if(!$units->isEmpty())
@foreach($units as $key => $unit)
<tr>
    <td>{{ ++$key}} </td>

    <td>{{ $unit->name}}</td>
    <td>{{ $unit->description}}</td>
    <td>
        @if(can_access('edit_unit'))
        <a class="me-3 edit" id="{{$unit->id }}" href="javascript:void(0);">
            <img src="{{ asset('assets/img/icons/edit.svg')}}" alt="img">
        </a>
        @endif
        @if(can_access('delete_unit'))
        <a class="me-3 delete" id="{{$unit->id }}" href="javascript:void(0);">
            <img src="{{ asset('assets/img/icons/delete.svg')}}" alt="img">
        </a>
        @endif
    </td>
</tr>
@endforeach
@endif
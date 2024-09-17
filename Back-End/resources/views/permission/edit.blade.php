@extends('layouts.app')

@section('content')
    <h1>Edit Permission</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\PermissionController@update', $permission->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name', 'name')}}
            {{Form::text('name', $permission->name, ['class' => 'form-control', 'placeholder' => 'name'])}}
        </div>

        <div class="form-group">
            {{Form::label('forcompany', 'forcompany')}}
            {{Form::text('forcompany', $permission->forcompany, ['class' => 'form-control', 'placeholder' => 'forcompany'])}}
        </div>
        
    <fieldset>
      <label>Permissiones:</label><br>

    @if($array_size == 'notempty')
        @foreach($rolegroup as $rolegroups)
            @if(in_array($rolegroups->adjictive, $rolegroup_name))
                <input type="checkbox" name="rolegrouprolearray[]"  id="check" value="{{$rolegroups->id}}" checked>  {{$rolegroups->adjictive}}<br/>
            @else
                <input type="checkbox" name="rolegrouprolearray[]" id="check" value="{{$rolegroups->id}}" >  {{$rolegroups->adjictive}}<br/>
            @endif
        @endforeach
    @endif
    </fieldset>

        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection



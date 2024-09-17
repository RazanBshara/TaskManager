@extends('layouts.app')

@section('content')
    <h1>Edit RoleGroup</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\RoleGroupController@update', $rolegroup->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('adjictive', 'adjictive')}}
            {{Form::text('adjictive', $rolegroup->adjictive, ['class' => 'form-control', 'placeholder' => 'adjictive'])}}
        </div>

    <fieldset>
      <label>Permissiones:</label><br>
    @foreach($permission as $permissions)
        @if(in_array($permissions->id, $permission_name))
            <input type="checkbox" name="rolegrouppermissionarray[]" value="{{$permissions->id}}" checked>  {{$permissions->name}}<br/>
        @else
            <input type="checkbox" name="rolegrouppermissionarray[]" value="{{$permissions->id}}">  {{$permissions->name}}<br/>
        @endif
    @endforeach
    </fieldset>

        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
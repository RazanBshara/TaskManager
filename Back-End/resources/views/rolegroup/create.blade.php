@extends('layouts.app')

@section('content')
<h1>Create RoleGroup</h1>
{!! Form::open(['action' => 'App\Http\Controllers\RoleGroupController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="form-group">
    {{Form::label('adjictive', 'adjictive')}}
    {{Form::text('adjictive', '', ['class' => 'form-control', 'placeholder' => 'adjictive'])}}
</div>

<fieldset>
    <label>Permissiones:</label><br>
    @foreach($permission as $permissions)
    <input type="checkbox" name="rolegrouppermissionarray[]" value="{{$permissions->id}}"> {{$permissions->name}}<br />
    @endforeach
</fieldset>

{{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
{!! Form::close() !!}
@endsection
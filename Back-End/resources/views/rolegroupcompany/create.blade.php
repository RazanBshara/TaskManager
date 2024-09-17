@extends('layouts.app')

@section('content')
<h1>Create RoleGroupCompany</h1>
{!! Form::open(['action' => 'App\Http\Controllers\RoleGroupCompanyController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="form-group">
    {{Form::label('adjictive', 'adjictive')}}
    {{Form::text('adjictive', '', ['class' => 'form-control', 'placeholder' => 'adjictive'])}}
</div>

<fieldset>
    <label>Permissions:</label><br>
    @foreach($permission as $permissions)
    <input type="checkbox" name="rolegroupcompanypermissionarray[]" value="{{$permissions->id}}"> {{$permissions->name}}<br />
    @endforeach
</fieldset>

{{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
{!! Form::close() !!}
@endsection
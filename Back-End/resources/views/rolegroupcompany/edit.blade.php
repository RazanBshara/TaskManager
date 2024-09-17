@extends('layouts.app')

@section('content')
    <h1>Edit RoleGroupCompany</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\RoleGroupCompanyController@update', $rolegroupcompany->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('adjictive', 'adjictive')}}
            {{Form::text('adjictive', $rolegroupcompany->adjictive, ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>

    <fieldset>
      <label>Permissions:</label><br>
    @foreach($permission as $permissions)
        @if(in_array($permissions->id, $permissionname))
            <input type="checkbox" name="rolegroupcompanypermissionarray[]" value="{{$permissions->id}}" checked>  {{$permissions->name}}<br/>
        @else
            <input type="checkbox" name="rolegroupcompanypermissionarray[]" value="{{$permissions->id}}">  {{$permissions->name}}<br/>
        @endif
    @endforeach
    </fieldset>

        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
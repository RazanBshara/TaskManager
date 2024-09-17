@extends('layouts.app')

@section('content')
    <h1>Edit Workspace</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\WorkspaceController@update', $workspace->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('name', 'name')}}
            {{Form::text('name', $workspace->name, ['class' => 'form-control', 'placeholder' => 'name'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'description')}}
            {{Form::text('description', $workspace->description, ['class' => 'form-control', 'placeholder' => 'description'])}}
        </div>  
       
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
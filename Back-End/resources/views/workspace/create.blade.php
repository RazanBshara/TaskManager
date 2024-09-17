@extends('layouts.app')

@section('content')
    <h1>Create Workspace</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\WorkspaceController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name', 'name')}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'name'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'description')}}
            {{Form::text('description', '', ['class' => 'form-control', 'placeholder' => 'description'])}}
        </div>   
        
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
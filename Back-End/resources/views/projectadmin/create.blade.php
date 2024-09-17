@extends('layouts.app')

@section('content')
    <h1>Create Project </h1>
    {!! Form::open(['action' => 'App\Http\Controllers\ProjectAdminController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name', 'name')}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'name'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'description')}}
            {{Form::text('description', '', ['class' => 'form-control', 'placeholder' => 'description'])}}
        </div>  
        <div class="form-group">
            {{Form::label('createdby', 'createdby')}}
            {{Form::text('createdby', '', ['class' => 'form-control', 'placeholder' => 'createdby'])}}
        </div>
        <div class="form-group">
            {{Form::label('workspaceid', 'workspaceid')}}
            {{Form::text('workspaceid', '', ['class' => 'form-control', 'placeholder' => 'workspaceid'])}}
        </div>

        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
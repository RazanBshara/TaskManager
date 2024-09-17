@extends('layouts.app')

@section('content')
    <h1>Edit Job</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\JobController@update', $job->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('name', 'name')}}
            {{Form::text('name', $job->name, ['class' => 'form-control', 'placeholder' => 'name'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'description')}}
            {{Form::text('description', $job->description, ['class' => 'form-control', 'placeholder' => 'description'])}}
        </div>  
        
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
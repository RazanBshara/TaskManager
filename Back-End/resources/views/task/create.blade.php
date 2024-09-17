@extends('layouts.app')

@section('content') 
    <h1>Create task</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\TaskController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name', 'name')}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'name'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'description')}}
            {{Form::text('description', '', ['class' => 'form-control', 'placeholder' => 'description'])}}
        </div>  
        <div class="form-group">
            {{Form::label('startdate', 'startdate')}}
            {{Form::text('startdate', '', ['class' => 'form-control', 'placeholder' => 'startdate'])}}
        </div>
        <div class="form-group">
            {{Form::label('enddate', 'enddate')}}
            {{Form::text('enddate', '', ['class' => 'form-control', 'placeholder' => 'enddate'])}}
        </div>
        <div class="form-group">
            {{Form::label('status', 'status')}}
            {{Form::text('status', '', ['class' => 'form-control', 'placeholder' => 'status'])}}
        </div>


       
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
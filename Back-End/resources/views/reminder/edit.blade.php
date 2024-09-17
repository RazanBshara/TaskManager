@extends('layouts.app')

@section('content')
    <h1>Edit Reminder</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\ReminderController@update', $reminder->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('date', 'date')}}
            {{Form::text('date', $reminder->date, ['class' => 'form-control', 'placeholder' => 'date'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'description')}}
            {{Form::text('description', $reminder->description, ['class' => 'form-control', 'placeholder' => 'description'])}}
        </div>  
       
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
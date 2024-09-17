@extends('layouts.app')

@section('content')
    <h1>Edit reminder</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\ReminderAdminController@update', $reminder->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('Name', 'Name')}}
            {{Form::text('Name', $reminder->Name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'description')}}
            {{Form::text('description', $reminder->description, ['class' => 'form-control', 'placeholder' => 'description'])}}
        </div>  
        <div class="form-group">
            {{Form::label('userid', 'userid')}}
            {{Form::text('userid', $reminder->userid, ['class' => 'form-control', 'placeholder' => 'userid'])}}
        </div>
       
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
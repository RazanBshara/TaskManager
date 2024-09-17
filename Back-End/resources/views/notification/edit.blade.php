@extends('layouts.app')

@section('content')
    <h1>Edit Notification</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\NotificationController@update', $notification->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('type', 'type')}}
            {{Form::text('type', $notification->type, ['class' => 'form-control', 'placeholder' => 'type'])}}
        </div>
        <div class="form-group">
            {{Form::label('message', 'message')}}
            {{Form::text('message', $notification->message, ['class' => 'form-control', 'placeholder' => 'message'])}}
        </div>  
        <div class="form-group">
            {{Form::label('date', 'date')}}
            {{Form::text('date', $notification->date, ['class' => 'form-control', 'placeholder' => 'date'])}}
        </div>
       
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
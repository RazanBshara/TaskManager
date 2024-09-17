@extends('layouts.app')

@section('content')
    <h1>Create Notification</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\NotificationController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('type', 'type')}} 
            {{Form::text('type', '', ['class' => 'form-control', 'placeholder' => 'type'])}}
        </div>
        <div class="form-group">
            {{Form::label('message', 'message')}}
            {{Form::text('message', '', ['class' => 'form-control', 'placeholder' => 'message'])}}
        </div>  
        <div class="form-group">
            {{Form::label('date', 'date')}}
            {{Form::text('date', '', ['class' => 'form-control', 'placeholder' => 'date'])}}
        </div>
       
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection 
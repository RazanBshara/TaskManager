@extends('layouts.app')

@section('content')
    <h1>Create reminder</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\ReminderAdminController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('date', 'date')}}
            {{Form::text('date', '', ['class' => 'form-control', 'placeholder' => 'date'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'description')}}
            {{Form::text('description', '', ['class' => 'form-control', 'placeholder' => 'description'])}}
        </div>  
        <div class="form-group">
            {{Form::label('userid', 'userid')}}
            {{Form::text('userid', '', ['class' => 'form-control', 'placeholder' => 'userid'])}}
        </div>
      
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
@extends('layouts.app')

@section('content')
    <h1>Create Job</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\JobAdminController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name', 'name')}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'name'])}}
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
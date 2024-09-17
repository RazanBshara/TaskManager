@extends('layouts.app')

@section('content')
    <h1>Create Food</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\SectionAdminController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
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
            {{Form::label('projectid', 'projectid')}}
            {{Form::text('projectid', '', ['class' => 'form-control', 'placeholder' => 'projectid'])}}
        </div>

        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
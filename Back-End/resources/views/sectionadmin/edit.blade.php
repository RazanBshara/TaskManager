@extends('layouts.app')

@section('content')
    <h1>Edit Section</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\SectionAdminController@update', $section->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('name', 'name')}}
            {{Form::text('name', $section->name, ['class' => 'form-control', 'placeholder' => 'name'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'description')}}
            {{Form::text('description', $section->description, ['class' => 'form-control', 'placeholder' => 'description'])}}
        </div>  
        <div class="form-group">
            {{Form::label('createdby', 'createdby')}}
            {{Form::text('createdby', $section->createdby, ['class' => 'form-control', 'placeholder' => 'createdby'])}}
        </div>
        <div class="form-group">
            {{Form::label('projectid', 'projectid')}}
            {{Form::text('projectid', $section->projectid, ['class' => 'form-control', 'placeholder' => 'projectid'])}}
        </div>
        
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
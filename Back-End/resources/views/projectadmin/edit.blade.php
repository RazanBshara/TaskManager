@extends('layouts.app')

@section('content')
    <h1>Edit Project</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\ProjectAdminController@update', $project->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('name', 'name')}}
            {{Form::text('name', $project->name, ['class' => 'form-control', 'placeholder' => 'name'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'description')}}
            {{Form::text('description', $project->description, ['class' => 'form-control', 'placeholder' => 'description'])}}
        </div>  
        <div class="form-group">
            {{Form::label('createdby', 'createdby')}}
            {{Form::text('createdby', $project->Price, ['class' => 'form-control', 'placeholder' => 'createdby'])}}
        </div>
        <div class="form-group">
            {{Form::label('workspaceid', 'workspaceid')}}
            {{Form::text('workspaceid', $project->Price, ['class' => 'form-control', 'placeholder' => 'workspaceid'])}}
        </div>
      
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
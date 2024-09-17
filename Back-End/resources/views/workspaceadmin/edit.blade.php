@extends('layouts.app')

@section('content')
    <h1>Edit Workspace</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\WorkspaceAdminController@update', $workspace->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('name', 'name')}}
            {{Form::text('name', $workspace->name, ['class' => 'form-control', 'placeholder' => 'name'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'description')}}
            {{Form::text('description', $workspace->description, ['class' => 'form-control', 'placeholder' => 'description'])}}
        </div>  
        <div class="form-group">
            {{Form::label('createdby', 'createdby')}}
            {{Form::text('createdby', $workspace->createdby, ['class' => 'form-control', 'placeholder' => 'createdby'])}}
        </div>
        <div class="form-group">
            {{Form::label('companyid', 'companyid')}}
            {{Form::text('companyid', $workspace->companyid, ['class' => 'form-control', 'placeholder' => 'companyid'])}}
        </div>

    
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
@extends('layouts.app')

@section('content')
    <h1>Edit Company</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\CompanyAdminController@update', $company->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('name', 'name')}}
            {{Form::text('name', $company->name, ['class' => 'form-control', 'placeholder' => 'name'])}}
        </div>
        <div class="form-group">
            {{Form::label('type', 'type')}}
            {{Form::text('type', $company->type, ['class' => 'form-control', 'placeholder' => 'type'])}}
        </div>  
        <div class="form-group">
            {{Form::label('description', 'description')}}
            {{Form::text('description', $company->description, ['class' => 'form-control', 'placeholder' => 'description'])}}
        </div>
        <div class="form-group">
            {{Form::label('createdby', 'createdby')}}
            {{Form::text('createdby', $company->createdby, ['class' => 'form-control', 'placeholder' => 'createdby'])}}
        </div>

        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
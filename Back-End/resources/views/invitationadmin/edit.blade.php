@extends('layouts.app')

@section('content')
    <h1>Edit Food</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\InvitationAdminController@update', $invitation->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('email', 'email')}}
            {{Form::text('email', $invitation->email, ['class' => 'form-control', 'placeholder' => 'email'])}}
        </div>
        <div class="form-group">
            {{Form::label('companyname', 'companyname')}}
            {{Form::text('companyname', $invitation->companyname, ['class' => 'form-control', 'placeholder' => 'companyname'])}}
        </div>  
        <div class="form-group">
            {{Form::label('userid', 'userid')}}
            {{Form::text('userid', $invitation->userid, ['class' => 'form-control', 'placeholder' => 'userid'])}}
        </div>
      
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
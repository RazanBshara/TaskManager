@extends('layouts.app')

@section('content')
    <h1>Create Invitation</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\InvitationController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('email', 'email')}}
            {{Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'email'])}}
        </div>
        <div class="form-group">
            {{Form::label('companyname', 'companyname')}}
            {{Form::text('companyname', '', ['class' => 'form-control', 'placeholder' => 'companyname'])}}
        </div>  
      
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
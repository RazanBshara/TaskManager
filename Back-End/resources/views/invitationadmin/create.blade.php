@extends('layouts.app')

@section('content')
    <h1>Create Food</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\InvitationAdminController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('email', 'email')}}
            {{Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>email
        <div class="form-group">
            {{Form::label('companyname', 'companyname')}}
            {{Form::text('companyname', '', ['class' => 'form-control', 'placeholder' => 'companyname'])}}
        </div>  
        <div class="form-group">
            {{Form::label('userid', 'userid')}}
            {{Form::text('userid', '', ['class' => 'form-control', 'placeholder' => 'userid'])}}
        </div>


        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
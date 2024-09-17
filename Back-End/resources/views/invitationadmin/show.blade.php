@extends('layouts.app')

@section('content')
    
    <h1>{{$invitation->Name}}</h1>
   
    <br><br>
    <div>
        {!!$invitation->Name!!}
    </div>
    <hr>
    <small>Written on {{$invitation->created_at}} </small>
    <hr>
  
            <a href="/invitationadmin/{{$invitation->id}}/edit" class="btn btn-default">Edit</a>
        
            {!!Form::open(['action' => ['App\Http\Controllers\InvitationAdminController@destroy', $invitation->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}


  

@endsection
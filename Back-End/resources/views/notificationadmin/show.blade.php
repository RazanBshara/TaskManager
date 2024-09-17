@extends('layouts.app')

@section('content')
    
    <h1>{{$notification->type}}</h1>
   
    <br><br>
    <div>
        {!!$notification->type!!}
    </div>
    <hr>
    <small>Written on {{$notification->created_at}} </small>
    <hr>
  
            <a href="/notificationadmin/{{$notification->id}}/edit" class="btn btn-default">Edit</a>
       
            {!!Form::open(['action' => ['App\Http\Controllers\NotificationAdminController@destroy', $notification->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}


  
@endsection
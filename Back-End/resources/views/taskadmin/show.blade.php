@extends('layouts.app')

@section('content')
    
    <h1>{{$task->name}}</h1>
   
    <br><br>
    <div>
        {!!$task->name!!}
    </div>
    <hr>
    <small>Written on {{$task->created_at}} </small>
    <hr>
  =
            <a href="/taskadmin/{{$task->id}}/edit" class="btn btn-default">Edit</a>
        
            {!!Form::open(['action' => ['App\Http\Controllers\TaskAdminController@destroy', $task->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
  

@endsection
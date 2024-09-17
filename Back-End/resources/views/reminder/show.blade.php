@extends('layouts.app')

@section('content')
    
    <h1>{{$reminder->date}}</h1>
   
    <br><br>
    <div>
        {!!$reminder->date!!}
    </div>
    <hr>
    <small>Written on {{$reminder->created_at}} </small>
    <hr>

            <a href="/reminder/{{$reminder->id}}/edit" class="btn btn-default">Edit</a>
       
            {!!Form::open(['action' => ['App\Http\Controllers\ReminderController@destroy', $reminder->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
   

@endsection
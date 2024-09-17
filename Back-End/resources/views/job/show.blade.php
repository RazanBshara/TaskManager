@extends('layouts.app')

@section('content')
    
    <h1>{{$job->name}}</h1>
   
    <br><br>
    <div>
        {!!$job->name!!}
    </div>
    <hr>
    <small>Written on {{$job->created_at}} </small>
    <hr>
  
            <a href="/job/{{$job->id}}/edit" class="btn btn-default">Edit</a>
        
            {!!Form::open(['action' => ['App\Http\Controllers\JobController@destroy', $job->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
     
@endsection
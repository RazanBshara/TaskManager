@extends('layouts.app')

@section('content')
    
    <h1>{{$project->name}}</h1>
   
    <br><br>
    <div>
        {!!$project->name!!}
    </div>
    <hr>
    <small>Written on {{$project->created_at}} </small>
    <hr>
    
            <a href="/project/{{$project->id}}/edit" class="btn btn-default">Edit</a>
       
            {!!Form::open(['action' => ['App\Http\Controllers\ProjectController@destroy', $project->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
  
@endsection
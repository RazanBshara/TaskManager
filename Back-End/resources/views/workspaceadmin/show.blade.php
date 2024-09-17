@extends('layouts.app')

@section('content')
    
    <h1>{{$workspace->name}}</h1>
   
    <br><br>
    <div>
        {!!$workspace->name!!}
    </div>
    <hr>
    <small>Written on {{$workspace->created_at}} </small>
    <hr>

            <a href="/workspaceadmin/{{$workspace->id}}/edit" class="btn btn-default">Edit</a>
      
            {!!Form::open(['action' => ['App\Http\Controllers\WorkspaceAdminController@destroy', $workspace->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}


@endsection
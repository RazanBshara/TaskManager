@extends('layouts.app')

@section('content')
<h1>task</h1>
    <a href="/taskadmin/create" class="btn btn-default pull-right">New task</a>
<table class="table table-sm">
    <thead>
        <tr>
            <th>name</th> 
            
        </tr>
    </thead>
    <tbody>
    @foreach($task as $tasks)
          <tr>
              
              <td> {{$tasks->name}}  
              {!!Form::open(['action' => ['App\Http\Controllers\TaskAdminController@destroy', $tasks->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
              {!!Form::close()!!}

              <a href="/taskadmin/{{$tasks->id}}/edit" class="btn btn-default pull-right">Edit</a>
              <a href="/taskadmin/{{$tasks->id}}" class="btn btn-default pull-right">Show</a>

              </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection
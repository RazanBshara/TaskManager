@extends('layouts.app')

@section('content')
<h1>workspace</h1>
    <a href="/workspace/create" class="btn btn-default pull-right">New workspace</a>
<table class="table table-sm">
    <thead>
        <tr>
            <th>name</th> 
            
        </tr>
    </thead>
    <tbody>
    @foreach($workspace as $workspaces)
          <tr>
              
              <td> {{$workspaces->name}}  
              {!!Form::open(['action' => ['App\Http\Controllers\WorkspaceController@destroy', $workspaces->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
              {!!Form::close()!!}

              <a href="/workspace/{{$workspaces->id}}/edit" class="btn btn-default pull-right">Edit</a>
              <a href="/workspace/{{$workspaces->id}}" class="btn btn-default pull-right">Show</a>

              </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection
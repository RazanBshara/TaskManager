@extends('layouts.app')

@section('content')
<h1>Project</h1>
    <a href="/projectadmin/create" class="btn btn-default pull-right">New project</a>
<table class="table table-sm">
    <thead>
        <tr>
            <th>name</th> 
            
        </tr>
    </thead>
    <tbody>
    @foreach($project as $projects)
          <tr>
              
              <td> {{$projects->name}}  
              {!!Form::open(['action' => ['App\Http\Controllers\ProjectAdminController@destroy', $projects->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
              {!!Form::close()!!}

              <a href="/projectadmin/{{$projects->id}}/edit" class="btn btn-default pull-right">Edit</a>
              <a href="/projectadmin/{{$projects->id}}" class="btn btn-default pull-right">Show</a>

              </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection
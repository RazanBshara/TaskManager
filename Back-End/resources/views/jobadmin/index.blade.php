@extends('layouts.app')

@section('content')
<h1>job</h1>
    <a href="/jobadmin/create" class="btn btn-default pull-right">New job</a>
<table class="table table-sm">
    <thead>
        <tr>
            <th>name</th> 
            
        </tr>
    </thead>
    <tbody>
    @foreach($job as $jobs)
          <tr>
              
              <td> {{$jobs->name}}  
              {!!Form::open(['action' => ['App\Http\Controllers\JobAdminController@destroy', $jobs->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
              {!!Form::close()!!}

              <a href="/jobadmin/{{$jobs->id}}/edit" class="btn btn-default pull-right">Edit</a>
              <a href="/jobadmin/{{$jobs->id}}" class="btn btn-default pull-right">Show</a>

              </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection
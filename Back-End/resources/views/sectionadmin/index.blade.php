@extends('layouts.app')

@section('content')
<h1>sections</h1>
    <a href="/sectionadmin/create" class="btn btn-default pull-right">New section</a>
<table class="table table-sm">
    <thead>
        <tr>
            <th>name</th> 
            
        </tr>
    </thead>
    <tbody>
    @foreach($section as $sections)
          <tr>
              
              <td> {{$sections->name}}  
              {!!Form::open(['action' => ['App\Http\Controllers\SectionAdminController@destroy', $sections->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
              {!!Form::close()!!}

              <a href="/sectionadmin/{{$sections->id}}/edit" class="btn btn-default pull-right">Edit</a>
              <a href="/sectionadmin/{{$sections->id}}" class="btn btn-default pull-right">Show</a>

              </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection
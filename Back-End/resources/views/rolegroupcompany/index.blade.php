@extends('layouts.app')

@section('content')
    <h1>RoleGroupCompany</h1>
    <a href="/rolegroupcompany/create" class="btn btn-default pull-right">New RoleGroupCompany</a>
<table class="table table-sm">
    <thead>
        <tr>
            <th>Adjective</th> 
            
        </tr>
    </thead>
    <tbody>
    @foreach($rolegroupcompany as $rolegroupcompanys)
          <tr>
              
              <td> {{$rolegroupcompanys->adjictive}}  
              {!!Form::open(['action' => ['App\Http\Controllers\RoleGroupCompanyController@destroy', $rolegroupcompanys->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
              {!!Form::close()!!}

              <a href="/rolegroupcompany/{{$rolegroupcompanys->id}}/edit" class="btn btn-default pull-right">Edit</a>
              <a href="/rolegroupcompany/{{$rolegroupcompanys->id}}" class="btn btn-default pull-right">Show</a>

              </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection
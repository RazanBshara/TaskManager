@extends('layouts.app')

@section('content')
    
    <h1>{{$company->name}}</h1>
   
    <br><br>
    <div>
        {!!$company->name!!}
    </div>
    <hr>
    <small>Written on {{$company->created_at}} </small>
    <hr>

            <a href="/companyadmin/{{$company->id}}/edit" class="btn btn-default">Edit</a>
       
            {!!Form::open(['action' => ['App\Http\Controllers\CompanyAdminController@destroy', $company->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}


   
@endsection
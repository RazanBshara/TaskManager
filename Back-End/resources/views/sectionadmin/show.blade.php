@extends('layouts.app')

@section('content')
    
    <h1>{{$section->name}}</h1>
   
    <br><br>
    <div>
        {!!$section->name!!}
    </div>
    <hr>
    <small>Written on {{$section->created_at}} </small>
    <hr>
    
            <a href="/sectionadmin/{{$section->id}}/edit" class="btn btn-default">Edit</a>
     
            {!!Form::open(['action' => ['App\Http\Controllers\SectionAdminController@destroy', $section->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}


@endsection
@extends('layouts.app')

@section('content')
<h1>invitation</h1>
    <a href="/invitation/create" class="btn btn-default pull-right">New invitation</a>
<table class="table table-sm">
    <thead>
        <tr>
            <th>email</th> 
            
        </tr>
    </thead>
    <tbody>
    @foreach($invitation as $invitations)
          <tr>
              
              <td> {{$invitations->email}}  
              {!!Form::open(['action' => ['App\Http\Controllers\InvitationController@destroy', $invitations->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
              {!!Form::close()!!}

              <a href="/invitation/{{$invitations->id}}/edit" class="btn btn-default pull-right">Edit</a>
              <a href="/invitation/{{$invitations->id}}" class="btn btn-default pull-right">Show</a>

              </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection
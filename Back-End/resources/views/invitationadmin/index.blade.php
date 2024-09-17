@extends('layouts.app')

@section('content')
<h1>invitation</h1>
    <a href="/invitationadmin/create" class="btn btn-default pull-right">New invitation</a>
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
              {!!Form::open(['action' => ['App\Http\Controllers\InvitationAdminController@destroy', $invitations->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
              {!!Form::close()!!}

              <a href="/invitationadmin/{{$invitations->id}}/edit" class="btn btn-default pull-right">Edit</a>
              <a href="/invitationadmin/{{$invitations->id}}" class="btn btn-default pull-right">Show</a>

              </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection
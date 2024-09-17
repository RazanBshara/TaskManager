@extends('layouts.app')

@section('content')
<h1>notification</h1>
    <a href="/notificationadmin/create" class="btn btn-default pull-right">New notification</a>
<table class="table table-sm">
    <thead>
        <tr>
            <th>type</th> 
            
        </tr>
    </thead>
    <tbody>
    @foreach($notification as $notifications)
          <tr>
              
              <td> {{$notifications->type}}  
              {!!Form::open(['action' => ['App\Http\Controllers\NotificationAdminController@destroy', $notifications->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
              {!!Form::close()!!}

              <a href="/notificationadmin/{{$notifications->id}}/edit" class="btn btn-default pull-right">Edit</a>
              <a href="/notificationadmin/{{$notifications->id}}" class="btn btn-default pull-right">Show</a>

              </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection
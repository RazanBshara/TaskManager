@extends('layouts.app')

@section('content')
<h1>notification</h1>
    <a href="/notification/create" class="btn btn-default pull-right">New notification</a>
<table class="table table-sm">
    <thead>
        <tr>
            <th>message</th> 
            
        </tr>
    </thead>
    <tbody>
    @foreach($notification as $notifications)
          <tr>
              
              <td> {{$notifications->message}}  
              {!!Form::open(['action' => ['App\Http\Controllers\NotificationController@destroy', $notifications->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
              {!!Form::close()!!}

              <a href="/notification/{{$notifications->id}}/edit" class="btn btn-default pull-right">Edit</a>
              <a href="/notification/{{$notifications->id}}" class="btn btn-default pull-right">Show</a>

              </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection
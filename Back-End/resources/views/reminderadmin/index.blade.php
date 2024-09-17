@extends('layouts.app')

@section('content')
<h1>reminder</h1>
    <a href="/reminderadmin/create" class="btn btn-default pull-right">New reminder</a>
<table class="table table-sm">
    <thead>
        <tr>
            <th>date</th> 
            
        </tr>
    </thead>
    <tbody>
    @foreach($reminder as $reminders)
          <tr>
              
              <td> {{$reminders->date}}  
              {!!Form::open(['action' => ['App\Http\Controllers\ReminderAdminController@destroy', $reminders->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
              {!!Form::close()!!}

              <a href="/reminderadmin/{{$reminders->id}}/edit" class="btn btn-default pull-right">Edit</a>
              <a href="/reminderadmin/{{$reminders->id}}" class="btn btn-default pull-right">Show</a>

              </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection
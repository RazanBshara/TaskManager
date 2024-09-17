@extends('layouts.app')

@section('content')
<h1>Reminder</h1>
    <a href="/reminder/create" class="btn btn-default pull-right">New reminder</a>
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
              {!!Form::open(['action' => ['App\Http\Controllers\ReminderController@destroy', $reminders->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
              {!!Form::close()!!}

              <a href="/reminder/{{$reminders->id}}/edit" class="btn btn-default pull-right">Edit</a>
              <a href="/reminder/{{$reminders->id}}" class="btn btn-default pull-right">Show</a>

              </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection
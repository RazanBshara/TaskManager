@extends('layouts.app')

@section('content')
    <a href="/rolegroupcompany" class="btn btn-default">Go Back</a>
    <h1>{{$rolegroupcompany->adjictive}}</h1>
   
    <br><br>
    <div>
        {!!$rolegroupcompany->adjictive!!}
    </div>
    <hr>
    <small>Written on {{$rolegroupcompany->created_at}} </small>
    <hr>
    @if(!Auth::guest())
        @if(Gate::check('checkpermission','edit') )
            <a href="/rolegroupcompany/{{$rolegroupcompany->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\RoleGroupCompanyController@destroy', $rolegroupcompany->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif           
 
    @endif

    <table class="table table-sm">
    <thead>
        <tr>
            <th>Permissions:</th>            
        </tr>
    </thead>
    <tbody>
    @foreach($permissionname as $permissionnames)
          <tr>
              
              <td> {{$permissionnames}}  </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection
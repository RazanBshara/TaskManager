@extends('layouts.app')

@section('content')
    <h1>New Permission</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\PermissionController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name', 'name')}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'name'])}}
        </div> 

        <div class="form-group">
            {{Form::label('forcompany', 'forcompany')}}
            {{Form::text('forcompany', '', ['class' => 'form-control', 'placeholder' => 'forcompany'])}}
        </div> 
        

<fieldset>
  <legend>Assign tp Role Groups:</legend>

  <div>
        @foreach($rolegroup as $rolegroups)
            <input type="checkbox" name="rolegrouprolearray[]" id="check" value="{{$rolegroups->id}}" >  {{$rolegroups->adjictive}}<br/>
        @endforeach
  </div>
</fieldset>

        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection



@extends('admin.index')
@section('title') Reset Password @endsection

@section('content')


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Reset Password </h3>
  </div>
  @include('flash::message')
  <div class="card-body">

    {!! Form::model($user, ['action' => ['ResetPaswwordController@update',$user->id], 'method' => 'PUT']) !!} 
    
    @include('admin.partials.validate_errors')

    <label for="password">Password  </label>
    {!! Form::password('password', [
      'class'       => 'form-control'
    ])!!}

  <label for="password_confirmation">Password Confirmation  </label>
  {!! Form::password('password_confirmation', [
    'class'       => 'form-control'
  ])!!}


  </div>

  <div class="card-footer">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>

    {!! Form::close() !!}
</div>

@endsection
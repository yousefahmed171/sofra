
@extends('admin.index')
@section('title') Edit User @endsection



@section('content')

<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Edit User</h3>
  </div>
  <div class="card-body">

    {!! Form::model($model, ['action' => ['UserController@update',$model->id], 'method' => 'PUT']) !!} 
    
    @include('admin.partials.validate_errors')

    <label for="name">Name  </label>
    {!! Form::text('name', null,[
      'class'       => 'form-control',
    ])!!}

    <label for="email">Email </label>
    {!! Form::text('email', null,[
      'class'       => 'form-control',
    ])!!}


    <label for="Password">Password </label>
    {!! Form::Password('password',[
      'class'       => 'form-control',
    ])!!}

    <label for="password_confirmation">Password  confirmation  </label>
    {!! Form::Password('password_confirmation', [
      'class'       => 'form-control',

    ])!!}

    <label for="user_type">Role Admin  </label>
    {!! Form::select('user_type[]', $role, null,[
      'class'       => 'form-control select2',
      'multiple'    =>  'multiple',

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
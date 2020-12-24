
@extends('admin.index')
@section('title') Create New Admin @endsection
@inject('model', 'App\User')
@section('content')


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Create New Admin</h3>
    
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  

  {!! Form::model($model,[
    'action' => 'UserController@store',
    'method' => 'POST'
  ]) !!} 
  
  <div class="card-body">
    
    @include('admin.partials.validate_errors')

    <label for="name">Name  </label>
    {!! Form::text('name', null,[
      'class'       => 'form-control',
      'placeholder' =>  'Name'
    ])!!}

    <label for="email">Email </label>
    {!! Form::text('email', null,[
      'class'       => 'form-control',
      'placeholder' =>  'Email'
    ])!!}
    <div class="form-group">
      <label for="password">Password </label><br>
      {!! Form::password('password', [
        'class'       => 'form-control',
        'placeholder' =>  'Password'
      ])!!}
    </div>

    <div class="form-group">
      <label for="password_confirmation">Password  confirmation  </label><br>
      {!! Form::password('password_confirmation', [
        'class'       => 'form-control',
        'placeholder' =>  'Confirm password'
      ])!!}
    </div>


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
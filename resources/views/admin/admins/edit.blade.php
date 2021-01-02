@extends('admin.index')
@section('title') Edit Admin @endsection



@section('content')

<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Edit Admin</h3>
  </div>
  <div class="card-body">

    {!! Form::model($model, ['action' => ['Admin\AdminController@update',$model->id], 'method' => 'PUT']) !!} 
    
    @include('admin.partials.validate_errors')

    <label for="name">Name  </label>
    {!! Form::text('name', null,[
      'class'       => 'form-control',
    ])!!}

    <label for="email">Email </label>
    {!! Form::text('email', null,[
      'class'       => 'form-control',
    ])!!}


    <label for="phone">Phone </label>
    {!! Form::number('phone', null,[
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
    {!! Form::select('admin_type[]', $record, null,[
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
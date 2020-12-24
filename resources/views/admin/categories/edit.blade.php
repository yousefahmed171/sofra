
@extends('admin.index')
@section('title') Edit Categories @endsection

@section('content')


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Edit Categories</h3>
  </div>
  <div class="card-body">

    {!! Form::model($model, ['action' => ['CategoryController@update',$model->id], 'method' => 'PUT']) !!} 
    
    @include('admin.partials.validate_errors')

    <label for="exampleInputCategory">Edit Categories</label>
    {!! Form::text('name', null,[
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

@extends('admin.index')
@section('title') Create Categories @endsection
@inject('model', 'App\Models\Category')
@section('content')


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Create Categories</h3>
    
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  

  {!! Form::model($model,[
    'action' => 'CategoryController@store'
  ]) !!} 
  
  <div class="card-body">
    
    @include('admin.partials.validate_errors')

  <label for="exampleInputCategory">Name Categories</label>
  {!! Form::text('name', null,[
    'class'       => 'form-control',
    'placeholder' =>  'Enter Name Category'
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

@extends('admin.index')
@section('title') Create Post @endsection
@inject('model', 'App\Models\Post')

@section('content')


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Create Post</h3>
    
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  

  {!! Form::model($model,[
    'action'  => 'PostController@store',
    'enctype' => 'multipart/form-data',
    'method' => 'POST'
  ]) !!} 
  
  <div class="card-body">
    
    @include('admin.partials.validate_errors')

    <div class="form-group">
      <label>Add Title Post</label>
      {!! Form::text('title', null,[
        'class'       => 'form-control',
        'placeholder' =>  'Enter Title Post'
      ])!!}
    </div>
    <div class="form-group">
      <label >Add Img Post</label><br>

      {!! Form::file('img',[
        'class'       => 'form-control',
        'placeholder' =>  'Enter Img Post',
      ])!!}
    </div>
    <div class="form-group">
      <label >Add Content Post</label>
      {!! Form::text('content', null,[

        'class'       => 'form-control',
        'placeholder' =>  'Enter Content Post'
      ])!!}
    </div>
    <div class="form-group">
      <label >Select Category Post</label>
      {!! Form::select('category_id', $category,[
        'class'       => 'form-control'
      ])!!}
    </div>
  </div>

  <div class="card-footer">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>

  {!! Form::close() !!}
</div>

@endsection
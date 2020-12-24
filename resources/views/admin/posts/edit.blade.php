
@extends('admin.index')
@section('title') Edit Post @endsection

@section('content')


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Edit Post</h3>
  </div>

    {!! Form::model($model, ['action' => [
            'PostController@update',$model->id], 
            'method' => 'PUT',
            'enctype' => 'multipart/form-data'
    ]) !!} 
    
    <div class="card-body">
    
      @include('admin.partials.validate_errors')
  
      <div class="form-group">
        <label>Add Title Post</label>
        {!! Form::text('title', null,[
          'class'       => 'form-control'
        ])!!}
      </div>
      <div class="form-group">
        <label >Add Img Post</label><br>
  
        {!! Form::file('img',[
          'class'       => 'form-control'
        ])!!}
        <div>
          <img src="{{asset('images/posts/'.$model->img)}}" alt="{{$model->title}}" 
          class="img-fluid rounded" style="margin-right: -3%; width: 80px; height: 80px;">
          
        </div>
      </div>
      <div class="form-group">
        <label >Add Content Post</label>
        {!! Form::text('content', null,[
          'class'       => 'form-control'
        ])!!}
      </div>
      <div class="form-group">
        <label >Select Category Post</label>
        {!! Form::select('category_id', $categoriesArray, null,[
          'class'       => 'form-control',
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
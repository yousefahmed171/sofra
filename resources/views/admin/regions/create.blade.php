
@extends('admin.index')
@section('title') Create Region @endsection
@inject('model', 'App\Models\Region')
@section('content')


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Create Region</h3>
    
  </div>
  

  {!! Form::model($model,[
    'action' => 'Admin\RegionController@store'
  ]) !!} 
  
  <div class="card-body">
    
    @include('admin.partials.validate_errors')
    <div  class="form-group">
      <label for="exampleInputRegion">Name Region</label>
      {!! Form::text('name', null,[
        'class'       => 'form-control',
        'placeholder' =>  'Enter Name Region'
      ])!!}
    </div>

    <div  class="form-group">
      <label >Select City Region</label>
      {!! Form::select('city_id', $record,[
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
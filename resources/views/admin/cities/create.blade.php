
@extends('admin.index')
@section('title') Create City @endsection
@inject('model', 'App\Models\City')
@section('content')


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Create City</h3>
    
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  

  {!! Form::model($model,[
    'action' => 'CityController@store'
  ]) !!} 
  
  <div class="card-body">
    
    @include('admin.partials.validate_errors')
    <div  class="form-group">
      <label for="exampleInputCity">Name City</label>
      {!! Form::text('name', null,[
        'class'       => 'form-control',
        'placeholder' =>  'Enter Name City'
      ])!!}
    </div>

    <div  class="form-group">
      <label >Select Governorate City</label>
      {!! Form::select('governorate_id', $records,[
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
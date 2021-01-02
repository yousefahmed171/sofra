
@extends('admin.index')
@section('title') Create City @endsection
@inject('model', 'App\Models\City')
@section('content')


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Create Governorate</h3>
    
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  

  {!! Form::model($model,[
    'action' => 'Admin\CityController@store'
  ]) !!} 
  
  <div class="card-body">
    
    @include('admin.partials.validate_errors')

  <label for="exampleInputCity">Name City</label>
  {!! Form::text('name', null,[
    'class'       => 'form-control',
    'placeholder' =>  'ادخل اسم المدينة '
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
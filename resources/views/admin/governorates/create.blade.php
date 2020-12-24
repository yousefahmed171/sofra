
@extends('admin.index')
@section('title') Create Governorate @endsection
@inject('model', 'App\Models\Governorate')
@section('content')


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Create Governorate</h3>
    
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  

  {!! Form::model($model,[
    'action' => 'GovernorateController@store'
  ]) !!} 
  
  <div class="card-body">
    
    @include('admin.partials.validate_errors')

  <label for="exampleInputGovernorate">Name Governorate</label>
  {!! Form::text('name', null,[
    'class'       => 'form-control',
    'placeholder' =>  'Enter Name Governorate'
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
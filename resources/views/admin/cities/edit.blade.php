
@extends('admin.index')
@section('title') Edit City @endsection

@section('content')


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Edit City</h3>
  </div>
  <div class="card-body">

    {!! Form::model($record, ['action' => ['Admin\CityController@update',$record->id], 'method' => 'PUT']) !!} 
    
    @include('admin.partials.validate_errors')

    <label for="exampleInputGovernorate">Edit Governorate</label>
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
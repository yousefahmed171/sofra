
@extends('admin.index')
@section('title') Edit City @endsection

@section('content')


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Edit City</h3>
  </div>
  <div class="card-body">

    {!! Form::model($record, ['action' => ['Admin\RegionController@update',$record->id], 'method' => 'PUT']) !!} 
    
    @include('admin.partials.validate_errors')
    <div class="form-group">
      <label for="exampleInputCity">Edit City</label>
      {!! Form::text('name', null,[
        'class'       => 'form-control'
      ])!!}
    </div>

  <div class="form-group">
    <label >Select  City regions</label>
    {!! Form::select('city_id', $categoriesArray, null,[
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
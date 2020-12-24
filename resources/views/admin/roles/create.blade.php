
@extends('admin.index')
@section('title') Create New Admin @endsection
@inject('model', 'App\Models\Role')
@inject('perm', 'App\Models\Permission')
@section('content')


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Create New Admin</h3>
    
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  

  {!! Form::model($model,[
    'action' => 'RoleController@store',
    'method' => 'POST'
  ]) !!} 
  
  <div class="card-body">
    
    @include('admin.partials.validate_errors')

    <label for="name">Name  </label>
    {!! Form::text('name', null,[
      'class'       => 'form-control',
      'placeholder' =>  'Name'
    ])!!}

    <label for="display_name">display name </label>
    {!! Form::text('display_name', null,[
      'class'       => 'form-control',
      'placeholder' =>  'display_name'
    ])!!}

    <label for="description">description </label>
    {!! Form::textarea('description', null,[
      'class'       => 'form-control',
      'placeholder' =>  'description'
    ])!!}

    <div class="form-group">
      <label for="permission">permission </label><br>
      <input id="selectAll" type="checkbox"><label for='selectAll'> Select All</label></li>
      <div class="row">
        @foreach ($perm->all() as $permission)
            <div class="col-sm-3">
              <div class="checkbox">
                <label for="">
                  <input type="checkbox" name="permissions_list[]" value="{{$permission->id}}"> {{$permission->display_name}}
                </label>
              </div>
            </div>
        @endforeach
      </div>

    </div>

  </div>

  <div class="card-footer">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>

  {!! Form::close() !!}
</div>

@push('scripts')
  <script>
    $("#selectAll").click(function() {
      $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
      });
      
      $("input[type=checkbox]").click(function() {
      if (!$(this).prop("checked")) {
      $("#selectAll").prop("checked", false);
      }
    });
  </script>
@endpush

@endsection


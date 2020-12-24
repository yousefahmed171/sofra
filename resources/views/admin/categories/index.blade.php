
@extends('admin.index')
@section('title') Categories @endsection
    
@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Categories Table </h3> <br>
              <a href="{{route('category.create')}}" class="btn btn-info"> <i class=" fas fa-plus"></i> Create Categories</a>
             
            </div>
            @include('flash::message')
            <!-- /.card-header -->
            @if(count($records))
                
            <div class="card-body">
              <table id="example" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id </th>
                  <th>Name Categories</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$record->name}}</td>
                    <td>
                        <a href="{{route('category.edit', $record->id)}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                    <td>
                        {!! Form::model($record, ['action' => ['CategoryController@destroy',$record->id], 'method' => 'DELETE']) !!} 

                        <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i> Delete</button>
                        {!! Form::close() !!}
                    </td>
                  </tr>
                @endforeach
                

                </tbody>
                <tfoot>
                <tr>
                  <th>Id </th>
                  <th>Name Categories</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
            @else 
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>No </strong> Data.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->

@endsection
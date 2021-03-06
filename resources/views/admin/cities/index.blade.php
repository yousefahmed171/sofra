
@extends('admin.index')
@section('title') City @endsection
    
@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">City Table </h3> <br>
              <a href="{{route('cities.create')}}" class="btn btn-info"> <i class=" fas fa-plus"></i> Create City</a>
             
            </div>
            @include('flash::message')
            <!-- /.card-header -->
            @if(count($record))
                
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id </th>
                  <th>Name City</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($record as $city)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$city->name}}</td>
                    <td>
                        <a href="{{route('cities.edit', $city->id)}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                    <td>
                        {!! Form::model($city, ['action' => ['Admin\CityController@destroy',$city->id], 'method' => 'DELETE']) !!} 

                        <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i> Delete</button>
                        {!! Form::close() !!}
                    </td>
                  </tr>
                @endforeach
                

                </tbody>
                <tfoot>
                  <tr>
                    <th>Id </th>
                    <th>Name City</th>
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
@extends('admin.index')
@section('title') Print Order  @endsection
    
@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">orders  Table </h3> <br>
             
            </div>
            @include('flash::message')
            <!-- /.card-header -->
            @if($record)
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID </th>
                  <th>name</th>
                  <th>quantity</th>
                  <th>quantity </th>
                  <th>note </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($record->products as $product)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->pivot->quantity}}</td>
                    <td>{{$product->pivot->quantity}}</td>
                    <td>{{$product->pivot->note}}</td> 
                </tr>
                @endforeach

                </tbody>
                <tfoot>
                  <tr>
                    <th>ID </th>
                    <th>name</th>
                    <th>quantity</th>
                    <th>quantity </th>
                    <th>note </th>
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
@extends('admin.index')
@section('title') offers  @endsection
    
@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">offers  Table </h3> <br>
             
            </div>
            @include('flash::message')
            <!-- /.card-header -->
            @if(count($record))
                
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID </th>
                  <th>Name </th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Start Date </th>
                  <th>End Date </th>
                  <th>restaurant Name </th>
                  <th>Image </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($record as $offer)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$offer->name}}</td>
                    <td>{{$offer->description}}</td>
                    <td>{{$offer->price}}</td>
                    <td>{{$offer->start_date}}</td>
                    <td>{{$offer->end_date}}</td> 
                    <td>{{$offer->restaurant->name}}</td>
                    <td> <img src="{{asset('images/restaurants/offers/' .$offer->image)}}" alt="offer - {{$offer->name}}"> </td>

                </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                  <th>ID </th>
                  <th>Name </th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Start Date </th>
                  <th>End Date </th>
                  <th>restaurant Name </th>
                  <th>Image </th>
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
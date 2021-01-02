@extends('admin.index')
@section('title') Orsers  @endsection
    
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
            @if(count($record))
                
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  
                <tr>
                  <th>ID </th>
                  <th>address</th>
                  <th>notes</th>
                  <th>payment_method </th>
                  <th>status </th>
                  <th>cost </th>
                  <th>net </th>
                  <th>delivery_cost </th>
                  <th>total_cost </th>
                  <th>commission </th>
                  <th>client_id </th>
                  <th>restaurant_id </th>
                  <th>view Order</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($record as $order)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$order->address}}</td>
                    <td>{{$order->notes}}</td>
                    <td>{{$order->payment_method}}</td>
                    <td>{{$order->status}}</td> 
                    <td>{{$order->cost}}</td> 
                    <td>{{$order->net}}</td> 
                    <td>{{$order->delivery_cost}}</td> 
                    <td>{{$order->total_cost}}</td> {{-- class="badge badge-success" --}}
                    <td>{{$order->commission}}</td> 
                    <td>{{$order->client->name}}</td> 
                    <td>{{$order->restaurant->name}}</td> 
                    <td>
                      <a href="{{url('admin/orders/'.$order->id)}}" class="btn btn-success btn-block">View Order</a>
                  </td>
                </tr>
                @endforeach

                </tbody>
                <tfoot>
                  <tr>
                    <th>ID </th>
                    <th>address</th>
                    <th>notes</th>
                    <th>payment_method </th>
                    <th>status </th>
                    <th>cost </th>
                    <th>net </th>
                    <th>delivery_cost </th>
                    <th>total_cost </th>
                    <th>commission </th>
                    <th>client_id </th>
                    <th>restaurant_id</th>
                    <th>view Order</th>
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
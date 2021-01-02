@extends('admin.index')
@section('title') Restaurants  @endsection
    
@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"> Restaurants  Table </h3> <br>
             
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
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Whatsapp</th>
                  <th>City </th>
                  <th>Status</th>
                  <th>Minimum Order</th>
                  <th>Delivery Cost</th>
                  <th>Active de-Active </th>
                  <th>Image</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($record as $restaurant)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$restaurant->name}}</td>
                    <td>{{$restaurant->email}}</td>
                    <td>{{$restaurant->phone}}</td>
                    <td>{{$restaurant->whatsapp}}</td>
                    <td>{{$restaurant->region->name}}</td>
                    <td>{{$restaurant->status}}</td>
                    <td>{{$restaurant->minimum_order}}</td>
                    <td>{{$restaurant->delivery_cost}}</td>
                    @if ($restaurant->activated == 0)
                       <td>
                          {!! Form::model($restaurant, ['action' => ['Admin\RestaurantController@active',$restaurant->id], 'method' => 'PUT']) !!} 

                          <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-times"></i>  De Active </button>
                          {!! Form::close() !!}
                       </td>
                    @else
                        <td>
                          {!! Form::model($restaurant, ['action' => ['Admin\RestaurantController@deActive',$restaurant->id], 'method' => 'PUT']) !!} 

                          <button type="submit" class="btn btn-success btn-xs"><i class="fas fa-check"></i>    Active </button>
                          {!! Form::close() !!}
                        </td>
                    @endif
                    <td> <img src="{{asset('images/restaurants/profile/' .$restaurant->image)}}" alt="restaurant - {{$restaurant->name}}"> </td>

                  </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                  <th>ID </th>
                  <th>Name </th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>whatsapp</th>
                  <th>City </th>
                  <th>Status</th>
                  <th>Minimum Order</th>
                  <th>Delivery Cost</th>
                  <th>Active de-Active </th>
                  <th>Image</th>

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

@extends('admin.index')
@section('title') Donation Request @endsection
    
@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Donation Request Table </h3> <br>
             
            </div>
            @include('flash::message')
            <!-- /.card-header -->
            @if(count($records))
                
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id </th>
                  <th>Name </th>
                  <th>Age</th>
                  <th>Bags</th>
                  <th>Hospital Address</th>
                  <th>Phone</th>
                  <th>Details</th>
                  <th>Blood Type</th>
                  <th>City </th>
                  <th>Client</th>
                  <th>Map</th>
                  <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$record->name}}</td>
                    <td>{{$record->age}}</td>
                    <td>{{$record->bags}}</td>
                    <td>{{$record->hospital_address}}</td>
                    <td>{{$record->phone}}</td>
                    <td>{{$record->details}}</td>
                    <td>
                      <span class="badge badge-success">{{$record->bloodType->name}} </span>
                    </td>
                    <td>{{$record->city->name}}</td>
                    <td>{{$record->client->name}}</td>
                    <td>{{$record->latitude}}, {{$record->longitude}}</td> 
                    <td>
                      {!! Form::model($record, ['action' => ['DonationRequestController@destroy',$record->id], 'method' => 'DELETE']) !!} 

                      <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"> </i>  Delete </button>
                      {!! Form::close() !!}
                    </td>

                  </tr>
                @endforeach
                

                </tbody>
                <tfoot>
                <tr>
                  <th>Id </th>
                  <th>Name </th>
                  <th>Age</th>
                  <th>Bags</th>
                  <th>Hospital Address</th>
                  <th>Phone</th>
                  <th>Details</th>
                  <th>Blood Type</th>
                  <th>City </th>
                  <th>Client</th>
                  <th>Map</th>
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
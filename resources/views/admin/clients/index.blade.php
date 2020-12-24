@extends('admin.index')
@section('title') Clients  @endsection
    
@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Clients  Table </h3> <br>
             
            </div>
            @include('flash::message')
            <!-- /.card-header -->
            @if(count($records))
                
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID </th>
                  <th>Name </th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Brith Date</th>
                  <th>Last Donation Date </th>
                  <th>Blood Type</th>
                  <th>City </th>
                  <th>Active de-Active </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$record->name}}</td>
                    <td>{{$record->email}}</td>
                    <td>{{$record->phone}}</td>
                    <td>{{$record->brith_date}}</td>
                    <td>{{$record->last_donation_date}}</td>
                    <td>
                      @foreach ($record->bloodTypes as $blood)
                      <span class="badge badge-success">{{$blood->name}} </span>
                      @endforeach
                    </td>
                    <td>{{$record->city->name}}</td>
                    @if ($record->active == 0)
                       <td> 
                          {!! Form::model($record, ['action' => ['ClientController@active',$record->id], 'method' => 'PUT']) !!} 

                          <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-times"></i>  De Active </button>
                          {!! Form::close() !!}
                       </td>
                    @else
                        <td>
                          {!! Form::model($record, ['action' => ['ClientController@deActive',$record->id], 'method' => 'PUT']) !!} 

                          <button type="submit" class="btn btn-success btn-xs"><i class="fas fa-check"></i>    Active </button>
                          {!! Form::close() !!}
                        </td>
                    @endif
                    
                  </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th>ID </th>
                    <th>Name </th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Brith Date</th>
                    <th>Last Donation Date </th>
                    <th>Blood Type</th>
                    <th>City </th>
                    <th>Active de-Active </th>
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
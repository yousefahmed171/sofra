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
            @if(count($record))
                
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID </th>
                  <th>Name </th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>City </th>
                  {{-- <th>Active de-Active </th> --}}
                </tr>
                </thead>
                <tbody>
                @foreach ($record as $client)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$client->name}}</td>
                    <td>{{$client->email}}</td>
                    <td>{{$client->phone}}</td>
                    <td>{{$client->region->name}}</td>
                    {{-- @if ($client->active == 0)
                       <td>
                          {!! Form::model($client, ['action' => ['Admin\ClientController@active',$client->id], 'method' => 'PUT']) !!} 

                          <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-times"></i>  De Active </button>
                          {!! Form::close() !!}
                       </td>
                    @else
                        <td>
                          {!! Form::model($client, ['action' => ['Admin\ClientController@deActive',$client->id], 'method' => 'PUT']) !!} 

                          <button type="submit" class="btn btn-success btn-xs"><i class="fas fa-check"></i>    Active </button>
                          {!! Form::close() !!}
                        </td>
                    @endif
                     --}}
                  </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th>ID </th>
                    <th>Name </th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City </th>
                    {{-- <th>Active de-Active </th> --}}
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
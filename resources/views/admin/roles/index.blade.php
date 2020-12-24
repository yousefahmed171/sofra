
@extends('admin.index')
@section('title') Roles @endsection
    
@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Roles Table </h3> <br>
              <a href="{{route('role.create')}}" class="btn btn-info"> <i class=" fas fa-plus"></i> Create Roles</a>
             
            </div>
            @include('flash::message')
            <!-- /.card-header -->
            @if(count($roles))
                
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id </th>
                  <th>Name</th>
                  <th>Display Name</th>
                  <th>Description</th>
                  <th>Parmissions</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$role->name}}</td>
                    <td>{{$role->display_name }}</td>
                    <td>
                      @empty($role->description)
                        <span>No Data</span>
                      @endempty
                      {{$role->description }}
                    </td>
                    <td>
                      @foreach ($role->permissions as $pram)
                      <span class="badge badge-success">{{$pram->display_name}} </span>
                      @endforeach
                      
                    </td>
                    <td>
                        <a href="{{route('role.edit', $role->id)}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                    <td>
                        {!! Form::model($role, ['action' => ['RoleController@destroy',$role->id], 'method' => 'DELETE']) !!} 

                        <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i> Delete</button>
                        {!! Form::close() !!}
                    </td>
                  </tr>
                @endforeach
                

                </tbody>
                <tfoot>
                <tr>
                  <th>Id </th>
                  <th>Name</th>
                  <th>Display Name</th>
                  <th>Description</th>
                  <th>Parmissions</th>
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
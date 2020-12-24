
@extends('admin.index')
@section('title') Admin @endsection
    
@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Admin Table </h3> <br>
              <a href="{{route('user.create')}}" class="btn btn-info"> <i class=" fas fa-plus"></i> Create Admin</a>
             
            </div>
            @include('flash::message')
            <!-- /.card-header -->
            @if(count($users))
                
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id </th>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Email</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$user->name}}</td>
                    <td>
                      @foreach ($user->roles as $role)
                          <span class="badge badge-success">{{$role->display_name}} </span>
                      @endforeach
                    </td>
                    <td>{{$user->email}}</td>
                    <td>
                        <a href="{{route('user.edit', $user->id)}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                    <td>
                        {!! Form::model($user, ['action' => ['UserController@destroy',$user->id], 'method' => 'DELETE']) !!} 

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
                  <th>Role</th>
                  <th>Email</th>
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
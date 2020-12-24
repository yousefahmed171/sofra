
@extends('admin.index')
@section('title') Posts @endsection
    
@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Posts Table </h3> <br>
              <a href="{{route('post.create')}}" class="btn btn-info"> <i class=" fas fa-plus"></i> Create Posts</a>
             
            </div>
            @include('flash::message')
            <!-- /.card-header -->
            @if(count($posts))
                
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id </th>
                  <th>Title </th>
                  <th>Img </th>
                  <th>Content </th>
                  <th>Category </th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($posts as $post)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$post->title}}</td>
                    <td>
                      <img src="{{asset('images/posts/'.$post->img)}}" alt="{{$post->title}}" 
                      class="img-fluid rounded" style="margin-right: -3%; width: 80px; height: 80px;">
                    </td>
                    <td>{{$post->content}}</td>
                    <td>{{$post->category->name}}</td>
                    <td>
                        <a href="{{route('post.edit', $post->id)}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                    <td>
                        {!! Form::model($post, ['action' => ['PostController@destroy',$post->id], 'method' => 'DELETE']) !!} 

                        <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i> Delete</button>
                        {!! Form::close() !!}
                    </td>
                  </tr>
                @endforeach
                

                </tbody>
                <tfoot>
                <tr>
                  <th>Id </th>
                  <th>Title </th>
                  <th>Img </th>
                  <th>Content </th>
                  <th>Category </th>
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
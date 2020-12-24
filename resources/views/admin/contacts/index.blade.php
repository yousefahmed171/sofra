@extends('admin.index')
@section('title') Contact  @endsection

@section('content')
<div class="hold-transition sidebar-mini">
    <div class="wrapper">
        <div class="card card-solid">
            <div class="card-body pb-0">
                <div class="row d-flex align-items-stretch">

                    @if (count($contacts) < 1)
                    <div class="alert alert-warning col-12" role="alert">
                        No Massage In Contact now
                    </div>
                    @endif 

                    @foreach ($contacts as $contact)

                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">


                            <div class="card bg-light">
                                <div class="text-right" style="margin-right: 5px">
                                    {!! Form::model($contact, ['action' => ['ContactController@destroy',$contact->id], 'method' => 'DELETE']) !!} 
                                    <button type="submit" class="btn btn-danger btn-sm" ><i class="fas fa-trash-alt"> </i>   </button>
                                    {!! Form::close() !!}
                                </div>

                                <div class="card-header text-muted border-bottom-0">
                                    <span class="badge badge-warning">New Massage</span>
                                     
                                </div>

                                <div class="card-body pt-0">
                                <div class="row">

                                    <div class="col-7">
                                        <h2 class="lead"><b>{{$contact->client->name}}</b></h2>
                                        <p class="text-muted text-sm"><b>Subject: </b> {{$contact->subject}}</p>
                                        <p class="text-muted text-sm"><b>Massage: </b>
                                                {{$contact->massage}}
                                        </p>


                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone : +2  {{$contact->client->phone}}</li>
                                        </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="{{asset('admin/img/user8-128x128.jpg')}}" alt="" class="img-circle img-fluid">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <nav aria-label="Contacts Page Navigation">
                    <ul class="pagination justify-content-center m-0">
                        {{ null !== $contacts ? $contacts->links("pagination::bootstrap-4") : ''  }}
                    </ul>
                </nav>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
</div>

@endsection


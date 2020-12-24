
@extends('admin.index')
@section('title') Edit Settings @endsection

@section('content')


<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Edit Settings</h3>
  </div>
  <div class="card-body">

    {!! Form::model($settings, ['action' => ['SettingController@update',$settings->id], 'method' => 'PUT']) !!} 
    
    @include('admin.partials.validate_errors')

    <label for="about_app">About App </label>
    {!! Form::text('about_app', null,[
      'class'       => 'form-control'
    ])!!}
    <label for="about">About  </label>
    {!! Form::text('about', null,[
      'class'       => 'form-control'
    ])!!}
    <label for="notification_setting_post">Notification Setting Post </label>
    {!! Form::textarea('notification_setting_post', null,[
        'class'       => 'form-control'
    ])!!}
    <label for="phone">Phone </label>
    {!! Form::text('phone', null,[
        'class'       => 'form-control'
    ])!!}
    <label for="email">Email </label>
    {!! Form::text('email', null,[
        'class'       => 'form-control'
    ])!!}
    <label for="facebook_link">Facebook Link </label>
    {!! Form::text('facebook_link', null,[
        'class'       => 'form-control'
    ])!!}
    <label for="twitter_link">Twitter Link </label>
    {!! Form::text('twitter_link', null,[
        'class'       => 'form-control'
    ])!!}
    <label for="youtube_link">Youtupe Link </label>
    {!! Form::text('youtube_link', null,[
        'class'       => 'form-control'
    ])!!}
    <label for="instagram_link">Instagram Link </label>
    {!! Form::text('instagram_link', null,[
        'class'       => 'form-control'
    ])!!}
    <label for="whatsapp_link">Whatsapp Link </label>
    {!! Form::text('whatsapp_link', null,[
        'class'       => 'form-control'
    ])!!}
    <label for="android_link">Android Link </label>
    {!! Form::text('android_link', null,[
        'class'       => 'form-control'
    ])!!}
    <label for="ios_link">Ios Link </label>
    {!! Form::text('ios_link', null,[
        'class'       => 'form-control'
    ])!!}
  </div>

  <div class="card-footer">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>

    {!! Form::close() !!}
</div>

@endsection

@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row">
      @include('users.left_list_nav')
      <div class="col-md-9 user-basic-info-edit">
        <div class="preview">
          <img src="{{ $user->avatar_url }}" class="img-thumbnail img-responsive"/>
        </div>
        <div>
          <form method="post" action="{{ route('users.update_avatar') }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="file" name="avatar"/><br/><br/>
            <button class="btn btn-primary" type="submit">上传头像</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

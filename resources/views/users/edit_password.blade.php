
@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row">
      @include('users.left_list_nav')
      <div class="col-md-9 user-basic-info-edit">
        <form method="POST" action="{{ route('users.update_password') }}">
            @csrf
            @method('PUT')
            <input type="hidden" method="PUT"/>
            <div class="form-group row">
                <label for="old_password" class="col-sm-2 col-form-label">原密码</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="old_password" id="old_password">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">新密码</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" id="password">
                </div>
            </div>
            <div class="form-group">
                <div class="offset-sm-2 col-sm-6">
                    <button type="submit" class="btn btn-primary">提交</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection

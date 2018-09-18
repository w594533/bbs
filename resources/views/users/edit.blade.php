@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('users.left_list_nav')
            <div class="col-md-9 user-basic-info-edit">
                <form method="POST" action="{{ route('users.update', ['user' => Auth::id()]) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" method="PUT"/>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">邮箱</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="inputEmail3" value="{{ old('email', $user->email) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">真实姓名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name', $user->name) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="introduce" class="col-sm-2 col-form-label">个人介绍</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="introduce" id="introduce" rows="3">{{ old('introduce', $user->introduce) }}</textarea>
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

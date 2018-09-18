@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="box">
                <div class="padding-sm user-basic-info">
                    <div class="media center-block">
                        <img src="{{ $user->avatar_url }}" alt="..." class="img-thumbnail img-responsive center-block">
                    </div>
                    <hr/>
                    <div class="info">
                        <p>{{ $user->email }}</p>
                        <p>注册于 <span class="timeago">{{ $user->created_at->diffForHumans()  }}</span></p>
                        <p>活跃于 <span class="timeago">{{ $user->last_actived_at->diffForHumans()  }}</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-col col-md-9 left-col">

        </div>
    </div>
</div>
@endsection

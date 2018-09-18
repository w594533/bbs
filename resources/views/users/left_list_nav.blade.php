<div class="col-md-3">
    <div class="list-group">
        <a href="{{ route('users.edit', ['user' => Auth::id()]) }}" class="list-group-item {{ active_class(if_route('users.edit')) }}">
            个人信息
        </a>
        <a href="{{ route('users.edit_avatar') }}" class="list-group-item {{ active_class(if_route('users.edit_avatar')) }}">修改头像</a>
        <a href="#" class="list-group-item">消息通知</a>
        <a href="{{ route('users.edit_password') }}" class="list-group-item {{ active_class(if_route('users.edit_password')) }}">修改密码</a>
    </div>
</div>

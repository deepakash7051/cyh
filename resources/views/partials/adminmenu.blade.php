<ul>
    <li>
        <a href="{{ route('admin.home') }}"><i class="fas fa-tachometer-alt"></i> {{ trans('global.dashboard') }}</a>
    </li>

    @can('user_access')
    <li class="{{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
        <a href="{{ route('admin.users.index') }}"><i class="fas fa-user"></i> {{ trans('global.user.title') }}</a>
    </li>
    @endcan
    
    <li>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
            <i class="fas fas fa-sign-out-alt"></i> {{ trans('global.logout') }}
        </a>
    </li>
</ul>
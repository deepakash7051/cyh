<ul>
    <li>
        <a href="{{ route('admin.home') }}"><i class="fas fa-tachometer-alt"></i> {{ trans('global.dashboard') }}</a>
    </li>

    @can('permission_access')
    <li class="{{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
        <a href="{{ route('admin.permissions.index') }}"><i class="fas fa-unlock-alt"></i> {{ trans('global.permission.title') }}</a>
    </li>
    @endcan

    @can('role_access')
    <li class="{{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
        <a href="{{ route('admin.roles.index') }}"><i class="fas fa-briefcase"></i> {{ trans('global.role.title') }}</a>
    </li>
    @endcan

    @can('user_access')
    <li class="{{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
        <a href="{{ route('admin.users.index') }}"><i class="fas fa-user"></i> {{ trans('global.user.title') }}</a>
    </li>
    @endcan

    @can('category_access')
    <li class="{{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active' : '' }}">
        <a href="{{ route('admin.categories.index') }}"><i class="fas fa-tag"></i> {{ trans('global.category.title') }}</a>
    </li>
    @endcan

    @can('course_access')
    <li class="{{ request()->is('admin/courses') || request()->is('admin/courses/*') ? 'active' : '' }}">
        <a href="{{ route('admin.courses.index') }}"><i class="fas fa-certificate"></i> {{ trans('global.course.title') }}</a>
    </li>
    @endcan
    <!-- <li class="{{ request()->is('admin/videos') || request()->is('admin/videos/*') ? 'active' : '' }}">
        <a href="{{ route('admin.videos.index') }}"><i class="fas fa-video"></i> {{ trans('global.video.title') }}</a>
    </li>
    <li class="{{ request()->is('admin/slides') || request()->is('admin/slides/*') ? 'active' : '' }}">
        <a href="{{ route('admin.slides.index') }}"><i class="fab fa-slideshare"></i> {{ trans('global.slide.title') }}</a>
    </li>
    <li class="{{ request()->is('admin/quizzes') || request()->is('admin/quizzes/*') ? 'active' : '' }}">
        <a href="{{ route('admin.quizzes.index') }}"><i class="fab fa-quinscape"></i> {{ trans('global.quiz.title') }}</a>
    </li> -->
    <li>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
            <i class="fas fas fa-sign-out-alt"></i> {{ trans('global.logout') }}
        </a>
    </li>
</ul>
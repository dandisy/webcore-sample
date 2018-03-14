<li class="header">DASHBOARD</li>

<li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
    <a href="{!! url('dashboard') !!}"><i class="fa fa-area-chart"></i><span>Stats</span></a>
</li>

<li class="header">MANAGEMENT</li>

<li class="{{ Request::is('assets*') ? 'active' : '' }}">
    <a href="{!! url('assets') !!}"><i class="fa fa-folder-open"></i><span>Assets</span></a>
</li>

@role(['superadministrator','administrator'])
<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}"><i class="fa fa-users"></i><span>Users</span></a>
</li>

<li class="{{ Request::is('profiles*') ? 'active' : '' }}">
    <a href="{!! route('profiles.index') !!}"><i class="fa fa-edit"></i><span>Profiles</span></a>
</li>

<li class="{{ Request::is('roles*') ? 'active' : '' }}">
    <a href="{!! route('roles.index') !!}"><i class="fa fa-road"></i><span>Roles</span></a>
</li>

<li class="{{ Request::is('permissions*') ? 'active' : '' }}">
    <a href="{!! route('permissions.index') !!}"><i class="fa fa-ticket"></i><span>Permissions</span></a>
</li>

<li class="header">CONFIGURATION</li>

<li class="{{ Request::is('settings*') ? 'active' : '' }}">
    <a href="{!! route('settings.index') !!}"><i class="fa fa-cog"></i><span>Settings</span></a>
</li>
@endrole

<li class="header">CONTENTS</li>

{{--<li class="{{ Request::is('menu-manager*') ? 'active' : '' }}">
    <a href="{!! url('menu-manager') !!}"><i class="fa fa-bars"></i><span>Menus</span></a>
</li>--}}

<li class="{{ Request::is('pages*') ? 'active' : '' }}">
    <a href="{!! route('admin.pages.index') !!}"><i class="fa fa-edit"></i><span>Pages</span></a>
</li>

<li class="{{ Request::is('posts*') ? 'active' : '' }}">
    <a href="{!! route('admin.posts.index') !!}"><i class="fa fa-edit"></i><span>Posts</span></a>
</li>

<li class="{{ Request::is('presentations*') ? 'active' : '' }}">
    <a href="{!! route('admin.presentations.index') !!}"><i class="fa fa-edit"></i><span>Presentations</span></a>
</li>

<li class="{{ Request::is('components*') ? 'active' : '' }}">
    <a href="{!! route('admin.components.index') !!}"><i class="fa fa-edit"></i><span>Components</span></a>
</li>

<li class="{{ Request::is('dataSources*') ? 'active' : '' }}">
    <a href="{!! route('admin.dataSources.index') !!}"><i class="fa fa-edit"></i><span>Data Sources</span></a>
</li>

<li class="{{ Request::is('dataQueries*') ? 'active' : '' }}">
    <a href="{!! route('admin.dataQueries.index') !!}"><i class="fa fa-edit"></i><span>Data Queries</span></a>
</li>

<li class="{{ Request::is('dataColumns*') ? 'active' : '' }}">
    <a href="{!! route('admin.dataColumns.index') !!}"><i class="fa fa-edit"></i><span>Data Columns</span></a>
</li>


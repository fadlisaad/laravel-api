<li class="side-menus {{ Request::is('dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="/">
        <i class=" fas fa-home"></i><span>Dashboard</span>
    </a>
</li>
<li class="side-menus {{ Request::is('agencies*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('agencies.index') }}"><i class="fas fa-building"></i><span>Agencies</span></a>
</li>

<li class="side-menus {{ Request::is('services*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('services.index') }}"><i class="fas fa-building"></i><span>Services</span></a>
</li>

<li class="side-menus {{ Request::is('settings*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('settings') }}"><i class="fas fa-cog"></i><span>Settings</span></a>
</li>

<aside class="navbar navbar-vertical navbar-expand-lg shadow-sm" data-bs-theme="{{ $sidebar->sidebar }}">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand d-none d-lg-inline-flex ">
            <a href="{{ route('home.index') }}" class="nav-link mt-3">
                <img src="{{ asset('uploads/aplikasi/' . $logo->logo) }}" height="80" alt="Laravel" class="rounded">
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="fs-1">
                        <i class="bi bi-person"></i>
                    </span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::guard()->user()->name }}</div>
                        <div class="mt-1 small text-secondary">{{ Auth::guard()->user()->email }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                        Ubah Password
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode"
                        data-bs-toggle="tooltip" data-bs-placement="bottom">
                        <i class="bi bi-moon-fill shining-icon"></i>
                    </a>
                    <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode"
                        data-bs-toggle="tooltip" data-bs-placement="bottom">
                        <i class="bi bi-sun-fill shining-icon"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item {{ Session::get('active') == '/' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('home.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="bi bi-house"></i>
                        </span>
                        <span class="nav-link-title fw-bold">
                            Dashboard
                        </span>
                    </a>
                </li>
                @foreach (NavHelper::list_menu(optional(Auth::user()->user_group)->first()->group_id ?? null) as $item)
                    @if ($item['section_id'] != null)
                        <li
                            class="nav-item dropdown {{ in_array(Session::get('active'), $item['aktif']) ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="false" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="bi bi-{{ $item['icons'] }}"></i>
                                </span>
                                <span class="nav-link-title fw-bold">
                                    {{ $item['section'] }}
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        @foreach ($item['menu'] as $key)
                                            <a class="dropdown-item {{ Session::get('active') == $key['url'] ? 'active' : '' }}"
                                                href="{{ $key['url'] }}">
                                                {{ $key['menu'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </li>
                    @else
                        <li class="sidebar-item {{ Session::get('active') == '/' ? 'active' : '' }}">
                            <a href="{{ url('/') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>{{ $item['section'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</aside>

                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">{{ __('Core') }}</div>
                            <a class="nav-link" href="{{ config('fortify.home') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                {{ __('Dashboard') }}
                            </a>
                            @canany(['users_list', 'roles_list', 'permissions_list'])
                            <div class="sb-sidenav-menu-heading">{{ __('Packages') }}</div>
                            <a class="nav-link collapsed {{ request()->is('simple-permission/*') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-shield"></i></div>
                                {{ __('Permissions') }}
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse {{ request()->is('simple-permission/*') ? 'show' : '' }}" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    @can('users_list')
                                    <a class="nav-link {{ request()->is('simple-permission/users*') ? 'active' : '' }}" href="{{ route('simple-permission.users.index') }}">{{ __('Users') }}</a>
                                    @endcan
                                    @can('roles_list')
                                    <a class="nav-link {{ request()->is('simple-permission/roles*') ? 'active' : '' }}" href="{{ route('simple-permission.roles.index') }}">{{ __('Roles') }}</a>
                                    @endcan
                                    @can('permissions_list')
                                    <a class="nav-link {{ request()->is('simple-permission/permissions*') ? 'active' : '' }}" href="{{ route('simple-permission.permissions.index') }}">{{ __('Permissions') }}</a>
                                    @endcan
                                </nav>
                            </div>
                            @endcanany
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">{{ __('Logged in as:') }}</div>
                        {{ Auth::user()->name }}
                    </div>
                </nav>


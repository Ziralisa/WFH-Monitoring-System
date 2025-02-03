<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap"
            href="{{ route(auth()->user()->hasRole('admin') ? 'dashboard' : (auth()->user()->hasRole('staff') ? 'take-attendance' : 'new-user-homepage')) }}">
            <i class="fa-solid fa-house-laptop fa-2x"></i>
            <span class="ms-3 font-weight-bold">{{ config('app.name') }}</span>
        </a>
    </div>

    <!----------------VIEW DASHBOARD (ADMIN) ---------------->
    <hr class="horizontal dark mt-0">
    <ul class="navbar-nav">
        @can('view admin dashboard')
            <li class="nav-item pb-2">
                <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fa-solid fa-house text-center
                                    {{ in_array(request()->route()->getName(), ['dashboard']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard Admin</span>
                </a>
            </li>
        @endcan

        <!--------ATTENDANCE OPTION ----------->
        <hr class="horizontal dark mt-3">
        <li class="nav-item mt-2">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Attendance</h6>
        </li>

        <!------------VIEW TAKE ATTENDANCE/DASHBOARD STAFF ---------------->
        @can('view take attendance')
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'take-attendance' ? 'active' : '' }}"
                    href="{{ route('take-attendance') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-2xs fa-file-pen ps-2 pe-2 text-center
                                    {{ in_array(request()->route()->getName(), ['take-attendance']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Take Attendance</span>
                </a>
            </li>
        @endcan


        <!--------VIEW ATTENDANCE REPORT STAFF (STAFF) ----------->
        @can('view attendance report')
            <li class="nav-item pb-2">
                <a class="nav-link {{ Route::currentRouteName() == 'report' ? 'active' : '' }}"
                    href="{{ route('report') }}">
                    <div
                    class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i style="font-size: 1rem;"
                        class="fa-solid fa-clipboard-user text-center
                                                    {{ in_array(request()->route()->getName(), ['report']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Attendance Log</span>
                </a>
            </li>
        @endcan


        <!--------VIEW ATTENDANCE REPORT STAFF (ADMIN) ----------->
        @can('view attendance report staff')
        <li class="nav-item pb-2">
            <a class="nav-link {{ Route::currentRouteName() == 'attendance-report' ? 'active' : '' }}"
                href="{{ route('attendance-report') }}">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i style="font-size: 1rem;"
                        class="fa-solid fa-clipboard-user text-center
                                    {{ in_array(request()->route()->getName(), ['attendance-report']) ? 'text-white' : 'text-dark' }}"></i>
                </div>
                <span class="nav-link-text ms-1">Attendance Report</span>
            </a>
        </li>
        @endcan

        <!-------------VIEW ATTENDANCE STATUS (ADMIN) ----------->
        @can('view attendance report staff')
        <li class="nav-item pb-2">
            <a class="nav-link {{ Route::currentRouteName() == 'attendanceStatus' ? 'active' : '' }}"
                href="{{ route('attendanceStatus') }}">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i style="font-size: 1rem;"
                        class="fas fa-xs fa-chart-line ps-2 pe-2 text-center
                                    {{ in_array(request()->route()->getName(), ['attendanceStatus']) ? 'text-white' : 'text-dark' }}"></i>
                </div>
                <span class="nav-link-text ms-1">Attendance Status</span>
            </a>
        </li>
        @endcan

        <!--------------- PROJECT OPTION ---------------->
        <hr class="horizontal dark mt-3">
        <li class="nav-item mt-2">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Project</h6>
        </li>

        <li class="nav-item pb-2">
                <a class="nav-link {{ Route::currentRouteName() == 'projects.index' ? 'active' : '' }}"
                    href="{{ route('projects.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fa-solid fa-bars-progress text-center
                                            {{ in_array(request()->route()->getName(), ['projects.index']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Project</span>
                </a>
            </li>
        <!----------------- VIEW BACKLOG ---------------->
        @can('view backlog')
            <li class="nav-item pb-2">
                <a class="nav-link {{ Route::currentRouteName() == 'backlog.show' ? 'active' : '' }}"
                    href="{{ route('backlog.show') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fa-solid fa-calendar text-center
                                            {{ in_array(request()->route()->getName(), ['backlog.show']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sprint</span>
                </a>
            </li>
        @endcan

        <!--------------DAILY TASK LOG------------------>
        @can('view backlog')
        <li class="nav-item pb-2">
            <a class="nav-link {{ Route::currentRouteName() == 'daily.show' ? 'active' : '' }}"
                href="{{ route('daily.show') }}">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i style="font-size: 1rem;"
                        class="fa-solid fa-list-check text-center
                                    {{ in_array(request()->route()->getName(), ['daily.show']) ? 'text-white' : 'text-dark' }}"></i>
                </div>
                <span class="nav-link-text ms-1">Daily Task</span>
            </a>
        </li>
        @endcan


        <!------------- SETTING OPTION ---------------->
        <hr class="horizontal dark mt-3">
        <li class="nav-item mt-2">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Settings</h6>
        </li>

        <!------------- VIEW USER SETTING -------------->
        @can('view user settings')
            <li class="nav-item pb-2">
                <a class="nav-link {{ Route::currentRouteName() == 'admin.user-settings' ? 'active' : '' }}"
                    href="{{ route('admin.user-settings') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i
                            class="fas fa-xs fa-users-gear ps-2 pe-2 text-center
                                                    {{ in_array(request()->route()->getName(), ['admin.user-settings']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Users</span>
                </a>
            </li>
        @endcan

        <!------------- VIEW ROLE SETTING -------------->
        @can('view role settings')
            <li class="nav-item pb-2">
                <a class="nav-link {{ Route::currentRouteName() == 'admin.role' ? 'active' : '' }}"
                    href="{{ route('admin.role') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i
                            class="fas fa-2xl fa-user-shield ps-2 pe-2 text-center
                                                        {{ in_array(request()->route()->getName(), ['admin.role']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Roles</span>
                </a>
            </li>
        @endcan

        <hr class="horizontal dark mt-3">

    </ul>
</aside>

<<<<<<< HEAD
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
=======
<!-- Sidebar -->
<style>
    /* SIDEBAR STYLES */
    #sidenav-main {
        width: 250px;
        transition: transform 0.3s ease;
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        z-index: 1000;
        
    }

    /* When sidebar is collapsed */
    #sidenav-main.collapsed {
        transform: translateX(-100%);
    }

    /* MAIN CONTENT WRAPPER */
    #main-content-wrapper {
        margin-left: 250px;
        transition: margin-left 0.3s ease;
    }

    /* When sidebar is collapsed, shift content to full width */
    .sidebar-collapsed #main-content-wrapper {
        margin-left: 0;
    }

    /* MAIN CONTENT INNER SECTION (optional) */
    #main-content {
        transition: padding-left 0.3s ease;
    }

    /* Show Sidebar Button */
    #showSidebar {
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 9999;
        display: none;
        background-color: #fff;
        border: none;
        padding: 8px 10px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

</style>

<!-- Reopen Sidebar Button -->
<button id="showSidebar">
    <i class="fas fa-bars"></i>
</button>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
    id="sidenav-main">
    <div class="sidenav-header">
        <!-- Sidebar Close Icon -->
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-10 position-absolute end-0 top-0"
            aria-hidden="true" id="iconSidenav"></i>

>>>>>>> a2f031c (initial commit)
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap"
            href="{{ route(auth()->user()->hasRole('admin') ? 'dashboard' : (auth()->user()->hasRole('staff') ? 'take-attendance' : 'new-user-homepage')) }}">
            <i class="fa-solid fa-house-laptop fa-2x"></i>
            <span class="ms-3 font-weight-bold">{{ config('app.name') }}</span>
        </a>
    </div>

<<<<<<< HEAD
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
=======
    <hr class="horizontal dark mt-0">
    <ul class="navbar-nav">
        <!-- All your existing sidebar items stay unchanged -->
        @can('view admin dashboard')
        <li class="nav-item pb-2">
            <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}"
                href="{{ route('dashboard') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center" style="background-color: #0070ff">
                    <i style="font-size: 1rem;"
                        class="fa-solid fa-house text-center {{ in_array(request()->route()->getName(), ['dashboard']) ? 'text-white' : 'text-white' }}"></i>
                </div>
                <span class="nav-link-text ms-1">Dashboard Admin</span>
            </a>
        </li>
        @endcan

>>>>>>> a2f031c (initial commit)
        <hr class="horizontal dark mt-3">
        <li class="nav-item mt-2">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Attendance</h6>
        </li>

<<<<<<< HEAD
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
=======
        @can('view take attendance')
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'take-attendance' ? 'active' : '' }}"
                href="{{ route('take-attendance') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center" style="background-color: #0070ff">
                    <i style="font-size: 1rem;" class="fas fa-2xs fa-file-pen ps-2 pe-2 text-center {{ in_array(request()->route()->getName(), ['take-attendance']) ? 'text-white' : 'text-white' }}"></i>
                </div>
                <span class="nav-link-text ms-1">Take Attendance</span>
            </a>
        </li>
        @endcan

        @can('view attendance report')
        <li class="nav-item pb-2">
            <a class="nav-link {{ Route::currentRouteName() == 'report' ? 'active' : '' }}"
                href="{{ route('report') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center" style="background-color: #0070ff">
                    <i style="font-size: 1rem;" class="fa-solid fa-clipboard-user text-center {{ in_array(request()->route()->getName(), ['report']) ? 'text-white' : 'text-white' }}"></i>
                </div>
                <span class="nav-link-text ms-1">Attendance Log</span>
>>>>>>> a2f031c (initial commit)
            </a>
        </li>
        @endcan

<<<<<<< HEAD
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
=======
        @can('view attendance report staff')
        <li class="nav-item pb-2">
            <a class="nav-link {{ Route::currentRouteName() == 'attendance-report' ? 'active' : '' }}"
                href="{{ route('attendance-report') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center" style="background-color: #0070ff">
                    <i style="font-size: 1rem;" class="fas fa-xs fa-chart-line ps-2 pe-2 text-center {{ in_array(request()->route()->getName(), ['attendance-report']) ? 'text-white' : 'text-white' }}"></i>
                </div>
                <span class="nav-link-text ms-1">Attendance Report</span>
            </a>
        </li>

        <li class="nav-item pb-2">
            <a class="nav-link {{ Route::currentRouteName() == 'attendanceStatus' ? 'active' : '' }}"
                href="{{ route('attendanceStatus') }}">
<<<<<<< HEAD
                <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i style="font-size: 1rem;" class="fas fa-xs fa-chart-line ps-2 pe-2 text-center {{ in_array(request()->route()->getName(), ['attendanceStatus']) ? 'text-white' : 'text-dark' }}"></i>
>>>>>>> a2f031c (initial commit)
=======
                <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center" style="background-color: #0070ff">
                    <img width="18" height="18" src="https://img.icons8.com/fluency-systems-regular/48/clock-checked.png" alt="clock-checked" class="{{ in_array(request()->route()->getName(), ['attendanceStatus']) ? 'text-white' : 'text-white' }}"/>
>>>>>>> a8a9b99 (attendance log fix)
                </div>
                <span class="nav-link-text ms-1">Attendance Status</span>
            </a>
        </li>
        @endcan

<<<<<<< HEAD
        <!--------------- PROJECT OPTION ---------------->
=======
>>>>>>> a2f031c (initial commit)
        <hr class="horizontal dark mt-3">
        <li class="nav-item mt-2">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Project</h6>
        </li>

        <li class="nav-item pb-2">
<<<<<<< HEAD
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
=======
            <a class="nav-link {{ Route::currentRouteName() == 'projects.index' ? 'active' : '' }}"
                href="{{ route('projects.index') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center" style="background-color: #0070ff">
                    <i style="font-size: 1rem;" class="fa-solid fa-bars-progress text-center {{ in_array(request()->route()->getName(), ['projects.index']) ? 'text-white' : 'text-white' }}"></i>
                </div>
                <span class="nav-link-text ms-1">Project</span>
            </a>
        </li>

        @can('view backlog')
        <li class="nav-item pb-2">
            <a class="nav-link {{ Route::currentRouteName() == 'backlog.show' ? 'active' : '' }}"
                href="{{ route('backlog.show') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center" style="background-color: #0070ff">
                    <i style="font-size: 1rem;" class="fa-solid fa-calendar text-center {{ in_array(request()->route()->getName(), ['backlog.show']) ? 'text-white' : 'text-white' }}"></i>
                </div>
                <span class="nav-link-text ms-1">Sprint</span>
            </a>
        </li>

        <li class="nav-item pb-2">
            <a class="nav-link {{ Route::currentRouteName() == 'daily.show' ? 'active' : '' }}"
                href="{{ route('daily.show') }}">
<<<<<<< HEAD
                <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i style="font-size: 1rem;" class="fa-solid fa-list-check text-center {{ in_array(request()->route()->getName(), ['daily.show']) ? 'text-white' : 'text-dark' }}"></i>
>>>>>>> a2f031c (initial commit)
=======
                <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center" style="background-color: #0070ff">
                    <i style="font-size: 1rem;" class="fa-solid fa-list-check text-center {{ in_array(request()->route()->getName(), ['daily.show']) ? 'text-white' : 'text-white' }}"></i>
>>>>>>> a8a9b99 (attendance log fix)
                </div>
                <span class="nav-link-text ms-1">Daily Task</span>
            </a>
        </li>
        @endcan

<<<<<<< HEAD

        <!------------- SETTING OPTION ---------------->
=======
>>>>>>> a2f031c (initial commit)
        <hr class="horizontal dark mt-3">
        <li class="nav-item mt-2">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Settings</h6>
        </li>

<<<<<<< HEAD
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
=======
        @can('view user settings')
        <li class="nav-item pb-2">
            <a class="nav-link {{ Route::currentRouteName() == 'admin.user-settings' ? 'active' : '' }}"
                href="{{ route('admin.user-settings') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center" style="background-color: #0070ff">
                    <i class="fas fa-xs fa-users-gear ps-2 pe-2 text-center {{ in_array(request()->route()->getName(), ['admin.user-settings']) ? 'text-white' : 'text-white' }}"></i>
                </div>
                <span class="nav-link-text ms-1">Users</span>
            </a>
        </li>
        @endcan

        @can('view role settings')
        <li class="nav-item pb-2">
            <a class="nav-link {{ Route::currentRouteName() == 'admin.role' ? 'active' : '' }}"
                href="{{ route('admin.role') }}">
                <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center" style="background-color: #0070ff">
                    <i class="fas fa-2xl fa-user-shield ps-2 pe-2 text-center {{ in_array(request()->route()->getName(), ['admin.role']) ? 'text-white' : 'text-white' }}"></i>
                </div>
                <span class="nav-link-text ms-1">Roles</span>
            </a>
        </li>
        @endcan

        <hr class="horizontal dark mt-3">
    </ul>
</aside>

<!-- Sidebar Toggle Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById("sidenav-main");
        const toggleBtn = document.getElementById("iconSidenav");
        const showSidebarBtn = document.getElementById("showSidebar");
        const mainContent = document.getElementById("main-content-wrapper");
        const mainContentArea = document.getElementById("main-content");  // Main content area

        toggleBtn.addEventListener("click", function () {
            sidebar.classList.toggle("collapsed");

            const isCollapsed = sidebar.classList.contains("collapsed");
            showSidebarBtn.style.display = isCollapsed ? "block" : "none";

            /*if (mainContent) {
                if (isCollapsed) {
                    // Sidebar is collapsed
                    mainContent.style.marginLeft = "0";  // Main content takes full width
                    mainContentArea.style.paddingLeft = "0"; // No padding left when sidebar is hidden
                } else {
                    // Sidebar is expanded
                   mainContent.style.marginLeft = "250px";  // Sidebar width
                   mainContentArea.style.paddingLeft = "250px";  // Main content adjusts padding
                }
            }*/
        });

        showSidebarBtn.addEventListener("click", function () {
            sidebar.classList.remove("collapsed");
            showSidebarBtn.style.display = "none";

            /*if (mainContent) {
                //mainContent.style.marginRight = "100px";  // Reset margin to sidebar width
                mainContentArea.style.padding = "100px"; // Reset padding when sidebar is expanded
            }*/
        });
    });

</script>
>>>>>>> a2f031c (initial commit)

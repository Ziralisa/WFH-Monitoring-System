
<x-layouts.base>
    @include('layouts.navbars.auth.sidebar') <!-- Sidebar component inclusion -->
    <main class="main-content mt-1 border-radius-lg"> <!-- Main Content -->
        @include('layouts.navbars.auth.nav')  <!-- Navbar -->
        
        <div class="container mt-5">
            <h1 class="my-4">Attendance Report</h1>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">Attendance Records</h5>
                                </div>
                            </div>
                        </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.base>
<x-layouts.base>
    @section('title', 'WFHMS | 404 - Not Found')

    <div class="container mt-5 text-center">
        <h1 class="display-4 text-danger">404 - Not Found</h1>
        <p class="lead m-3">Sorry, this page does not exist</p>

        @php
            $redirectRoute = route('login');
            if (auth()->check()) {
                if (auth()->user()->hasRole('admin')) {
                    $redirectRoute = route('dashboard');
                } elseif (auth()->user()->hasRole('staff')) {
                    $redirectRoute = route('take-attendance');
                } else {
                    $redirectRoute = route('new-user-homepage');
                }
            }
        @endphp

        <a href="{{ $redirectRoute }}" class="btn btn-primary">Back to Dashboard</a>
    </div>
</x-layouts.base>

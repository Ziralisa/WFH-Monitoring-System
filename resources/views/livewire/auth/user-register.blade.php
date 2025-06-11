<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="row w-100" style="max-width: 1000px; min-height: 600px; overflow: hidden; border-radius: 1rem; box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);">
        
        <!-- Left Section -->
        <div class="col-md-6 p-5 text-white d-flex flex-column justify-content-center"
             style="background: linear-gradient(135deg, #3a7bd5, #3a6073); background-size: cover;">
            
            <div class="mb-4">
                <h1 class="fw-bold display-6">WFH Monitoring System</h1>
                <p class="fs-5 mt-3">Seamlessly onboard and empower remote employees for success — from day one.</p>
            </div>

            <div class="text-center mt-auto">
                <img src="{{ asset('assets/img/illustrations/rocket-white.png') }}" 
                alt="WFH Illustration" class="img-fluid" style="max-height: 250px;">
            </div>
        </div>

        <!-- Right Section (User Registration Form) -->
        <div class="col-md-6 bg-white p-5">
            <h2 class="fw-bold text-center mb-4">Create Your Account</h2>
            <p class="text-center text-muted mb-4 fs-6">Sign up to join your team and manage tasks remotely.</p>

            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form wire:submit.prevent="userregister" method="POST" role="form" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold fs-6">Full Name</label>
                    <input wire:model.defer="name" id="name" type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Full name" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold fs-6">Work Email</label>
                    <input wire:model.defer="email" id="email" type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email address" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold fs-6">Password</label>
                    <input wire:model.defer="password" id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Create password" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-semibold fs-6">Confirm Password</label>
                    <input wire:model.defer="password_confirmation" id="password_confirmation" type="password"
                           class="form-control" placeholder="Confirm password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-semibold py-2 mt-2 mb-3 fs-6">
                    Sign Up
                </button>

                <a href="{{ route('google.register') }}"
                   class="btn btn-outline-danger w-100 py-2 mb-3 d-flex justify-content-center align-items-center gap-2 fs-6">
                    <i class="fab fa-google"></i> Continue with Google
                </a>

                <p class="text-center text-muted fs-6">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Sign in</a>
                </p>
            </form>
        </div>
    </div>
</div>

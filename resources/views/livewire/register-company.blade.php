<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="row w-100" style="max-width: 1000px; min-height: 600px; overflow: hidden; border-radius: 1rem; box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);">
        
        <!-- Left Section -->
        <div class="col-md-6 p-5 text-white d-flex flex-column justify-content-center"
             style="background: linear-gradient(135deg, #3a7bd5, #3a6073); background-size: cover;">
            
            <div class="mb-4">
                <h1 class="fw-bold display-6">WFH Monitoring System</h1>
                <p class="fs-5 mt-3">Track productivity, simplify attendance, and empower remote teams — all in one platform.</p>
            </div>

            <div class="text-center mt-auto">
                <img src="{{ asset('assets/img/illustrations/rocket-white.png') }}" 
                     alt="WFHMS Logo" class="img-fluid" style="max-height: 250px;">
            </div>
        </div>

        <!-- Right Section (Form) -->
        <div class="col-md-6 bg-white p-5">
            <h2 class="fw-bold text-center mb-4">Register Your Company</h2>
            <p class="text-center text-muted mb-4 fs-6">Create your company account to get started.</p>

            <form wire:submit.prevent="createcompany" role="form" novalidate>
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="company_name" class="form-label fw-semibold fs-6">Company Name</label>
                        <input wire:model.defer="company_name" id="company_name" type="text"
                               class="form-control @error('company_name') is-invalid @enderror"
                               placeholder="Company Name" required>
                        @error('company_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="registration_no" class="form-label fw-semibold fs-6">Registration Number</label>
                        <input wire:model.defer="registration_no" id="registration_no" type="text"
                               class="form-control @error('registration_no') is-invalid @enderror"
                               placeholder="Registration Number" required>
                        @error('registration_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="address" class="form-label fw-semibold fs-6">Company Address</label>
                        <input wire:model.defer="address" id="address" type="text"
                               class="form-control @error('address') is-invalid @enderror"
                               placeholder="Company Address" required>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="contact_email" class="form-label fw-semibold fs-6">Contact Email</label>
                        <input wire:model.defer="contact_email" id="contact_email" type="email"
                               class="form-control @error('contact_email') is-invalid @enderror"
                               placeholder="Contact Email" required>
                        @error('contact_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="contact_phone" class="form-label fw-semibold fs-6">Contact Phone</label>
                        <input wire:model.defer="contact_phone" id="contact_phone" type="tel"
                               class="form-control @error('contact_phone') is-invalid @enderror"
                               placeholder="Contact Phone" required>
                        @error('contact_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-semibold py-2 mt-4 mb-3 fs-6">
                    Register Company
                </button>

                <a href="{{ route('google.register') }}"
                   class="btn btn-outline-danger w-100 py-2 mb-3 d-flex justify-content-center align-items-center gap-2 fs-6">
                    <i class="fab fa-google"></i> Sign up with Google
                </a>

            </form>
        </div>
    </div>
</div>

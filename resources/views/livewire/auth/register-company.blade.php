<section class="h-100-vh mb-8">
    <div class="page-header align-items-start section-height-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../assets/img/curved-images/curved14.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">{{ __('Register Company') }}</h1>
                    <p class="text-lead text-white">
                        {{ __('Create your company account to access our platform.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="">
            <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                <div class="card z-index-0">
                    <div class="card-body">
                        <form wire:submit.prevent="createcompany" method="POST" role="form text-left">
                            @csrf

                            <!-- Company Name -->
                            <div class="mb-3">
                                <input wire:model.live="company_name" type="text" class="form-control" placeholder="Company Name" required>
                                @error('company_name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!-- Registration Number -->
                            <div class="mb-3">
                                <input wire:model.live="registration_no" type="text" class="form-control" placeholder="Registration Number" required>
                                @error('registration_no') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!-- Company Address -->
                            <div class="mb-3">
                                <input wire:model.live="address" type="text" class="form-control" placeholder="Company Address" required>
                                @error('address') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!-- Contact Email -->
                            <div class="mb-3">
                                <input wire:model.live="contact_email" type="email" class="form-control" placeholder="Contact Email" required>
                                @error('contact_email') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!-- Contact Phone -->
                            <div class="mb-3">
                                <input wire:model.live="contact_phone" type="text" class="form-control" placeholder="Contact Phone" required>
                                @error('contact_phone') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <hr class="my-4" />

                            <!-- User Name -->
                            <div class="mb-3">
                                <input wire:model.live="name" type="text" class="form-control" placeholder="Your Name" required>
                                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!-- User Email -->
                            <div class="mb-3">
                                <input wire:model.live="email" type="email" class="form-control" placeholder="Your Email" required>
                                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <input wire:model.live="password" type="password" class="form-control" placeholder="Password" required>
                                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div class="mb-3">
                                <input wire:model.live="password_confirmation" type="password" class="form-control" placeholder="Confirm Password" required>
                                @error('password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100 mt-4 mb-0">Register Company</button>

                                                            
                            <p class="text-sm mt-3 mb-0">{{ __('Already Register ? ') }}<a
                                      href="{{ route('login') }}"
                                      class="text-dark font-weight-bolder">{{ __('Sign in') }}</a>
                              </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

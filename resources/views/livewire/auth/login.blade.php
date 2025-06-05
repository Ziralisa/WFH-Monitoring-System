<section>
<div class="page-header min-vh-100 d-flex align-items-center" style="background: linear-gradient(to right, #e0f7fa, #e0f2f1); overflow: hidden;">
        <div class="container">
            <div class="row">
                <!-- Left Side: Login Form -->
                <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                    <div class="card card-plain mt-8 p-4 shadow-lg" style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.85); border-radius: 20px;">
                        <!-- Company Logo + Welcome -->
                        <div class="card-header pb-0 text-center bg-transparent">
                            <img src="{{ asset('assets/img/kodewave_logo.png') }}" alt="Company Logo" class="mb-3" style="height: 80px;">
                            <h4 class="font-weight-bolder text-info text-gradient">{{ __('Welcome back') }}</h4>
                            <!--<p class="mb-0">{{ __('Create a new account')}}<br></p>
                            <p class="mb-0">{{__('OR Sign in with these credentials:') }}</p>
                            <p class="mb-0">{{ __('Email: ') }}<b>{{ __('admin@kodewave.my') }}</b></p>
                            <p class="mb-0">{{ __('Password: ') }}<b>{{ __('secret') }}</b></p>-->
                        </div>

                        <!-- Login Form -->
                        <div class="card-body">
                            <form wire:submit="login" action="#" method="POST" role="form text-left">
                                <div class="mb-3">
                                    <label for="email">{{ __('Email') }}</label>
                                    <div class="@error('email') border border-danger rounded-3 @enderror">
                                        <input wire:model.live="email" id="email" type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                                    </div>
                                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password">{{ __('Password') }}</label>
                                    <div class="@error('password') border border-danger rounded-3 @enderror position-relative">
                                        <input wire:model.live="password" id="password" type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                                        <!-- Optional: Password eye toggle (for enhancement) -->
                                    </div>
                                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-check form-switch">
                                    <input wire:model.live="remember_me" class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">{{ __('Remember me') }}</label>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0" style="transition: all 0.3s ease;">
                                        {{ __('Sign in to your account') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Footer Links -->
                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                            <small class="text-muted">
                                {{ __('Forgot your password? Reset your password') }}
                                <a href="{{ route('forgot-password') }}" class="text-info text-gradient font-weight-bold">{{ __('Here') }}</a>
                            </small>
                            <p class="mb-4 text-sm mx-auto">
                                {{ __('Don\'t have an account?') }}
                            <a href="{{ route('company-registration') }}" class="text-info text-gradient font-weight-bold">{{ __('Register') }}</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Image -->
                <div class="col-md-6 d-none d-md-block">
                    <div class="oblique position-absolute top-0 h-100 me-n6">
                        <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n7"
                            style="background-image:url('{{ asset('assets/img/curved-images/curved14.jpg') }}'); background-size: cover; background-position: center;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

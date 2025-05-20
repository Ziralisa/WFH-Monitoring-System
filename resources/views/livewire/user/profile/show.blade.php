<div>
    <div class="container-fluid">
        <div class="page-header min-height-300 border-radius-xl mt-4"
            style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6">
            <div class="row gx-4">
                <!--Profile Photo Upload-->
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        {{-- Show preview if uploading, else show saved photo or fallback --}}
                        @if ($photo)
                            <img  src="{{ $photo->temporaryUrl() }}" alt="Preview" class="w-100 border-radius-lg shadow-sm">
                        @elseif ($user->profile_photo_path)
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo" class="w-100 border-radius-lg shadow-sm">
                        @endif

                        {{-- Upload button (only for own profile) --}}
                        @if (!$selectedUserId)
                            <label for="photo" class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2" style="cursor: pointer;">
                                <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Image"></i>
                                <input type="file" id="photo" wire:model="photo" class="d-none" accept="image/*">
                            </label>
                        @endif
                    </div>

                    @error('photo') <span class="text-danger text-sm">{{ $message }}</span> @enderror

                    @if (session()->has('success'))
                        <div class="mt-2 text-success text-sm">{{ session('success') }}</div>
                    @endif
                </div>

                <div class="col-auto my-auto">
                    <div class="h-100 row gx-4 d-flex align-items-center">
                        <div class="col-auto">
                            @if (!empty($user->firstname) && !empty($user->lastname))
                                <p class="h5">{{ $user->first_name . ' ' . $user->last_name }}</p>
                            @else
                                <p class="h5">{{ $user->name }}</p>
                            @endif
                        </div>
                        <!--<div class="col-auto">
                            <span class="badge bg-secondary text-xxs font-weight-bolder align-self-center opacity-7">
                                <span
                                    class="badge badge-md badge-circle badge-floating badge-danger border-white bg-success">
                                </span>
                                <span>Last online:
                                    {{ \Carbon\Carbon::parse($user['last_online'])->diffForHumans() }}</span>
                            </span>
                        </div>-->
                    </div>
                    <div class="col-auto my-n2">
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ $user->position ?? 'Employee' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Personal Information') }}</h6>
            </div>
            <div class="card-body pt-4 pb-0 p-3">

                @if ($showDemoNotification)
                    <div wire:model.live="showDemoNotification"
                        class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                        <span class="alert-text text-white">
                            {{ __('You are in a demo version, you can\'t update the profile.') }}</span>
                        <button wire:click="$set('showDemoNotification', false)" type="button" class="btn-close"
                            data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                @endif

                @if (session()->has('success'))
                    <div 
                        x-data="{ show: true }" 
                        x-init="setTimeout(() => show = false, 3000)" 
                        x-show="show"
                        x-transition 
                        class="alert alert-success text-white font-weight-bold">
                        
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-3 alert alert-danger alert-dismissible fade show" role="alert">
                        <span class="alert-icon text-white"><i class="ni ni-fat-remove"></i></span>
                        <span class="alert-text text-white">
                            {{ __('There were some issues with your submission:') }}
                        </span>
                        <ul class="text-white">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif

                <form wire:submit.prevent="save" action="#" method="POST" role="form text-left">
                    @include('livewire.user.profile.personal')
                    @include('livewire.user.profile.job')
                    @include('livewire.user.profile.emergency')
                    @if (!$selectedUserId)
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-dark btn-md m-4">
                                {{ 'Save Changes' }}
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

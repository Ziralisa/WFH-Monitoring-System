<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="user-first_name" class="form-control-label">{{ __('First Name') }}</label>
            <div class="@error('user.first_name')border border-danger rounded-3 @enderror">
                <input wire:model="user.first_name" class="form-control" type="text" placeholder="First Name"
                    id="user-first_name">
            </div>
            @error('user.first_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="user-last_name" class="form-control-label">{{ __('Last Name') }}</label>
            <div class="@error('user.last_name')border border-danger rounded-3 @enderror">
                <input wire:model="user.last_name" class="form-control" type="text" placeholder="Last Name"
                    id="user-last_name">
            </div>
            @error('user.last_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="user-birthdate" class="form-control-label">{{ __('Date of Birth') }}</label>
            <div class="@error('user.birthdate')border border-danger rounded-3 @enderror">
                <input wire:model="user.birthdate" class="form-control" type="date" id="user-birthdate">
            </div>
            @error('user.birthdate')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="user.gender" class="form-control-label">{{ __('Gender') }}</label>
            <div class="@error('user.gender')border border-danger rounded-3 @enderror">
                <select wire:model="user.gender" class="form-control" id="user-gender">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            @error('user.gender')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="user-email" class="form-control-label">{{ __('Email Address') }}</label>
            <div class="@error('user.email')border border-danger rounded-3 @enderror">
                <input wire:model="user.email" class="form-control" type="email" placeholder="youremail@example.com"
                    id="user-email">
            </div>
            @error('user.email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="user.phone" class="form-control-label">{{ __('Phone Number') }}</label>
            <div class="@error('user.phone')border border-danger rounded-3 @enderror">
                <input wire:model="user.phone" class="form-control" type="tel" placeholder="e.g. 012-456-7890"
                    id="phone">
            </div>
            @error('user.phone')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label for="user-location1" class="form-control-label">{{ __('Home Address') }}</label>
        <div class="@error('user.location1') border border-danger rounded-3 @enderror">
            <input wire:model="user.location1" class="form-control" type="text"
                placeholder="10A Jalan Cakera Purnama" id="user-location1">
        </div>
        <div class="py-2 @error('user.location2') border border-danger rounded-3 @enderror">
            <input wire:model="user.location2" class="form-control" type="text"
                placeholder="Persiaran Puncak Perdana" id="user-location2">
        </div>
        @error('user.location1')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="user-suburb" class="form-control-label">{{ __('Suburb') }}</label>
            <div class="@error('user.suburb')border border-danger rounded-3 @enderror">
                <input wire:model="user.suburb" class="form-control" type="text" placeholder="Suburb"
                    id="user-suburb">
            </div>
            @error('user.suburb')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="user-state" class="form-control-label">{{ __('State') }}</label>
            <div class="@error('user.state')border border-danger rounded-3 @enderror">
                <input wire:model="user.state" class="form-control" type="text" placeholder="Selangor"
                    id="user-state">
            </div>
            @error('user.state')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class ="row">
    <div class="col-6">
        <div class="form-group">
            <label for="first_name" class="form-control-label">First Name</label>
            <input type="text" id="first_name" wire:model="user.first_name" class="form-control"
                {{ $selectedUserId ? 'disabled' : '' }} />
            @error('user.first_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="last_name" class="form-control-label">Last Name</label>
            <input type="text" id="last_name" wire:model="user.last_name" class="form-control"
                {{ $selectedUserId ? 'disabled' : '' }} />
            @error('user.last_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="birthdate" class="form-control-label">Birthdate</label>
            <input type="date" id="birthdate" wire:model="user.birthdate" class="form-control"
                {{ $selectedUserId ? 'disabled' : '' }} />
            @error('user.birthdate')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="gender" class="form-control-label">Gender</label>
            <select id="gender" wire:model="user.gender" class="form-control"
                {{ $selectedUserId ? 'disabled' : '' }}>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            @error('user.gender')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="email" class="form-control-label">Email</label>
            <input type="email" id="email" wire:model="user.email" class="form-control"
                {{ $selectedUserId ? 'disabled' : '' }} />
            @error('user.email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="phone" class="form-control-label">Phone</label>
            <input type="text" id="phone" wire:model="user.phone" class="form-control"
                {{ $selectedUserId ? 'disabled' : '' }} />
            @error('user.phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="location1" class="form-control-label">Primary Location</label>
    <input type="text" id="location1" wire:model="user.location1" class="form-control"
        {{ $selectedUserId ? 'disabled' : '' }} />
    @error('user.location1')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="location2" class="form-control-label">Secondary Location (Optional)</label>
    <input type="text" id="location2" wire:model="user.location2" class="form-control"
        {{ $selectedUserId ? 'disabled' : '' }} />
    @error('user.location2')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="suburb" class="form-control-label">Suburb</label>
            <input type="text" id="suburb" wire:model="user.suburb" class="form-control"
                {{ $selectedUserId ? 'disabled' : '' }} />
            @error('user.suburb')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="state" class="form-control-label">State</label>
            <input type="text" id="state" wire:model="user.state" class="form-control"
                {{ $selectedUserId ? 'disabled' : '' }} />
            @error('user.state')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>

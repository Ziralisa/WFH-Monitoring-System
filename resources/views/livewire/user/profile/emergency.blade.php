<div class="card-header pb-0 px-3">
    <h6 class="mb-0">{{ __('Emergency Contact') }}</h6>
</div>
<div class="card-body pt-4 pb-0 p-3">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="user-emergency_firstname" class="form-control-label">{{ __('First Name') }}</label>
                <div class="@error('user.emergency_firstname')border border-danger rounded-3 @enderror">
                    <input wire:model="user.emergency_firstname" class="form-control" type="text"
                        placeholder="Name" id="user-emergency_firstname">
                </div>
                @error('user.emergency_firstname')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="user-emergency_lastname" class="form-control-label">{{ __('Last Name') }}</label>
                <div class="@error('user.emergency_lastname')border border-danger rounded-3 @enderror">
                    <input wire:model="user.emergency_lastname" class="form-control" type="text"
                        placeholder="Name" id="user-emergency_lastname">
                </div>
                @error('user.emergency_lastname')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="user-emergency_relation" class="form-control-label">{{ __('Relation') }}</label>
                <div class="@error('user.emergency_relation')border border-danger rounded-3 @enderror">
                    <input wire:model="user.emergency_relation" class="form-control" type="text"
                        placeholder="e.g: Parent, Sibling" id="user-emergency_relation">
                </div>
                @error('user.emergency_relation')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="user-emergency_phone" class="form-control-label">{{ __('Mobile Phone') }}</label>
                <div class="@error('user.emergency_phone')border border-danger rounded-3 @enderror">
                    <input wire:model="user.emergency_phone" class="form-control" type="tel"
                        placeholder="e.g: 012-345-6789" id="user-emergency_phone">
                </div>
                @error('user.emergency_phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

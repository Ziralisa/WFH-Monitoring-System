<div class="card-header pb-0 px-3">
    <h6 class="mb-0">{{ __('Job Information') }}</h6>
</div>
<div class="card-body pt-4 p-3">
    <div class="row">
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="user-id" class="form-control-label">{{ __('Employee ID') }}</label>
                <input value="{{ $user->id }}" class="form-control" type="text" placeholder="10" id="user-id" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="user-job-status" class="form-control-label">{{ __('Employment Status') }}</label>
                <div class="@error('user.job_status')border border-danger rounded-3 @enderror">
                    <select wire:model="user.job_status" class="form-control" id="user-job-status">
                        <option value="">Select Employment Status</option>
                        <option value="0">Employed</option>
                        <option value="1">Resigned</option>
                    </select>
                </div>
                @error('user.job_status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="user-position" class="form-control-label">{{ __('Position') }}</label>
                <div class="@error('user.position')border border-danger rounded-3 @enderror">
                    <input wire:model="user.position" class="form-control" type="text" placeholder="Programmer" id="user-position">
                </div>
                @error('user.position')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="user-started_work" class="form-control-label">{{ __('Started Work') }}</label>
                <div class="@error('user.started_work')border border-danger rounded-3 @enderror">
                    <input wire:model="user.started_work" class="form-control" type="date" id="user-started_work">
                </div>
                @error('user.started_work')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="user-work_email" class="form-control-label">{{ __('Work Email Address') }}</label>
                <div class="@error('user.work_email')border border-danger rounded-3 @enderror">
                    <input wire:model="user.work_email" class="form-control" type="email" placeholder="youremail@example.com" id="user-work_email">
                </div>
                @error('user.work_email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="user.work_phone" class="form-control-label">{{ __('Work Phone Number') }}</label>
                <div class="@error('user.work_phone')border border-danger rounded-3 @enderror">
                    <input wire:model="user.work_phone" class="form-control" type="tel" placeholder="e.g: 012-345-6789" id="user-work_phone">
                </div>
                @error('user.work_phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

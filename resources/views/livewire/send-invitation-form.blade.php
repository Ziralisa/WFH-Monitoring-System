<style>
    .btnmain {
        background-color: #0070ff;
        color: white;
        width: 935px;
    }

    .btnmain:hover {
        background-color: #0070ff;
        color: white;
    }
</style>

<div>
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="sendInvitation" class="mb-3 w-80 center mx-auto">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input 
                type="email"
                wire:model="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Enter user email"
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit" class="btn btnmain">
                Send Invitation
            </button>
        </div>
    </form>
</div>

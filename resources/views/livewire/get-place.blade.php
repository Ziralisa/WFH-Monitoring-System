<div>
    <form wire:submit.prevent="getPlace">
        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" wire:model="latitude" class="form-control" id="latitude" placeholder="Enter latitude">
        </div>
        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" wire:model="longitude" class="form-control" id="longitude" placeholder="Enter longitude">
        </div>
        <button type="submit" class="btn btn-primary">Get Place</button>
    </form>

    @if(session()->has('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif

    @if($town || $country)
        <div class="mt-3">
            <h5>Results:</h5>
            <p><strong>Town:</strong> {{ $town }}</p>
            <p><strong>Country:</strong> {{ $country }}</p>
        </div>
    @endif
</div>

{{-- Top Performances Row --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-3">
                <h5 style="display: block; text-align: center;" class="font-weight-bolder">Top Performances</h5>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    @forelse ($goodUsers as $user )
    <div class="col-4">
        <div style="background-color: #71DB8C;" class="card h-100">
            <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                <a href="javascript:;" class="d-block">
                    {{-- Random profile picture --}}
                    <img src="../assets/img/team-{{ rand(1, 6) }}.jpg" class="img-fluid border-radius-lg">
                </a>
            </div>
            <div class="card-body pt-2">
                <span style="display: block; text-align: center;"
                    class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-3">{{ $user['weekly_points'] }}
                    POINTS</span>
                <a href="javascript:;" class="card-title h5 d-block text-darker">
                    {{ $user['user']->name }}
                </a>
                <p class="card-description mb-4">
                    Software Developer
                </p>
            </div>
        </div>
    </div>
    @empty
    <div class="container py-4 text-center">
        <p style="font-size: 24px; font-weight: bold;"><strong>No good performing staff found!</strong></p>
    </div>
    @endforelse
</div>


{{-- Bottom Performances Row --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-3">
                <h5 style="display: block; text-align: center;" class="font-weight-bolder">Bottom Performances
                </h5>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    @foreach ($badUsers as $user)
        {{-- <p>{{ $user['user']->name }} - Weekly Points: {{ $user['weekly_points'] }} - Status: {{ $user['weekly_status'] }}</p> --}}
        <div class="col-4">
            <div class="card h-100">
                <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                    <a href="javascript:;" class="d-block">
                        {{-- Random profile picture --}}
                        <img src="../assets/img/team-{{ rand(1, 6) }}.jpg" class="img-fluid border-radius-lg">
                    </a>
                </div>

                <div class="card-body pt-2">
                    <span style="display: block; text-align: center;"
                        class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-3">{{ $user['weekly_points'] }}
                        POINTS</span>
                    <a href="javascript:;" class="card-title h5 d-block text-darker">
                        {{ $user['user']->name }}
                    </a>
                    <p class="card-description mb-4">
                        Software Developer
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>

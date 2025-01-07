<!-- Modal -->
<div wire:ignore.self class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="logModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logModalLabel">Attendance Location Log History</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="mt-3 row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                User ID</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Name</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Location</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Latitude</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Longitude</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($locations as $location)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $location['date'] }}</p>
                                                        <p class="text-xs text-secondary mb-0">{{ $location['time'] }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $location['user_id'] }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-center text-xs font-weight-bold mb-0">{{ $location['name'] }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-center text-xs font-weight-bold mb-0">{{ $location['location'] }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-center text-xs font-weight-bold mb-0">{{ $location['latitude'] }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-center text-xs font-weight-bold mb-0">{{ $location['longitude'] }}</p>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No attendance logs available for this user.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

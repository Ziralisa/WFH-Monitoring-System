@push('child-scripts')
    @script
        <script>
            let currentUsers = [];

            var channel = window.Echo.join(`presence-onthispage`)
                .here((users) => {
                    currentUsers = users;

                    console.log('All users: ', users.map(user => user.name));
                    $wire.set('usersOnPage', currentUsers);
                    $wire.call('updateUserData', currentUsers);

                })
                .joining((user) => {
                    currentUsers.push(user);
                    console.log(user.name + ' joined!');
                    $wire.set('usersOnPage', currentUsers);
                    $wire.call('updateUserData', currentUsers);


                })
                .leaving((user) => {
                    currentUsers = currentUsers.filter(u => u.id !== user.id); // Remove user from list
                    console.log(user.name + ' left!');
                    $wire.set('usersOnPage', currentUsers);
                    $wire.call('updateUserData', currentUsers);

                })
                .listen('.user-location-updated', (data) => {
                    $wire.call('updateUserData', currentUsers);
                })
                .error((error) => {
                    console.error(error);
                });
        </script>
    @endscript
@endpush
{{-- <div>
    <h4>Users on this page:</h4>
    <ul>
        @if ($usersOnPage && count($usersOnPage) > 0)
            @foreach ($usersOnPage as $user)
                <li>{{ $user['name'] }}</li>
            @endforeach
        @else
            <li>No user found</li>
        @endif
    </ul>
</div> --}}

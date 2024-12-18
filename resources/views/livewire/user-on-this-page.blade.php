@push('child-scripts')
    @script
        <script>
            let currentUsers = [];

            var channel = window.Echo.join(`presence-onthispage`)
                .here((users) => {
                    currentUsers = users;
                    // Display all data for each user
                    // console.log('All users with full data:');
                    // users.forEach(user => {
                    //     console.log(user);
                    $wire.set('usersOnPage', currentUsers);
                    $wire.call('syncUserData', currentUsers);
                })
                .joining((user) => {
                    currentUsers.push(user);
                    console.log(user.name + ' joined!');
                    $wire.set('usersOnPage', currentUsers);
                    $wire.call('syncUserData', currentUsers);
                    if (window.location.pathname === '/dashboard') {
                        $wire.call('userNotification', 'online', user.name);
                    }
                })
                .leaving((user) => {
                    currentUsers = currentUsers.filter(u => u.id !== user.id);
                    console.log(user.name + ' left!');
                    $wire.set('usersOnPage', currentUsers);
                    $wire.call('syncUserData', currentUsers);
                    if (window.location.pathname === '/dashboard') {
                        $wire.call('userNotification', 'offline', user.name);
                    }
                })
                .listen('.user-location-updated', (e) => {
                    //Display all online user data
                    //console.log('User Location Updated:', e);

                    $wire.call('syncUserData', currentUsers);

                    if (window.location.pathname === '/dashboard') {
                        if (e.in_range) {
                            console.log(`${e.user.name} is within range.`);
                            $wire.call('userNotification', 'in range', e.user.name);
                        } else {
                            console.log(`${e.user.name} is out of range.`);
                            $wire.call('userNotification', 'out of range', e.user.name);
                        }
                    }
                })
                .error((error) => {
                    console.error(error);
                });
        </script>
    @endscript
@endpush

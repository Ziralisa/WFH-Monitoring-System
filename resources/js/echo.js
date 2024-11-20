console.log("Echo.js loaded");
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

// var channel = window.Echo.channel('myapp-channel');
// channel.listen('.my-event', function(data) {
//     console.log("Listened my-event!");
//     alert(JSON.stringify(data));
// });


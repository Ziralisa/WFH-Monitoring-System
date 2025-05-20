import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '67fedc6f958a40ad0918',
    cluster: 'ap1',
    forceTLS: true
});

// var channel = window.Echo.channel('myapp-channel');
// channel.listen('.my-event', function(data) {
//     console.log("Listened my-event!");
//     alert(JSON.stringify(data));
// });


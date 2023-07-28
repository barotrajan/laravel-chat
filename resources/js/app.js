// require('./bootstrap');

import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

// Configure Echo with your Pusher credentials
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'ad3cc5f19812648227fa',
    cluster: 'ap2',
    encrypted: true, // Set to true if you are using encrypted connections (recommended)
});

// Start listening for events and push the code to the 'scripts' stack
// window.Echo.private('chat.' + USER_ID) // Replace USER_ID with the current user's ID
// .listen('NewMessage', (e) => {
//     console.log('New message received:', e.message);
//     // Update the UI to display the new message
// });

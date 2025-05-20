import { createApp } from 'vue';
import PerfectScrollbar from 'perfect-scrollbar';
import LocationStatus from './components/LocationStatus.vue';
import App from './App.vue';

window.PerfectScrollbar = PerfectScrollbar;

import './bootstrap';
import './custom';

// Create the Vue application instance and mount it
createApp(App)
    .component('LocationStatus', LocationStatus)
    .mount('#app');

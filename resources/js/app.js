import { createApp } from 'vue';
import App from './App.vue'; // Importing App.vue
import router from './router'; // Import the router configuration

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

const app = createApp(App);
app.use(router);  // Registering the router with the app
app.mount('#app'); // Mounting the app on the HTML element with id 'app'


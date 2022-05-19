require('./bootstrap');

import CalendarComponent from './components/CalendarComponent.vue';
import { createApp } from 'vue';

const app = createApp({});

app.component('calendar', CalendarComponent);
app.mount('#app');
require("./bootstrap");

import CalendarComponent from "./Components/CalendarComponent.vue";
import Navbar from "./Components/Navbar.vue";

import { createApp } from "vue";

const app = createApp({});

app.component("Navbar", Navbar).component("Calendar", CalendarComponent);

app.mount("#app");

import "./index.css"; // Tailwind CSS
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store/index"; // Import the Vuex store
import { OhVueIcon, addIcons } from "oh-vue-icons";
import * as MdIcons from "oh-vue-icons/icons/md";
import axios from "axios";

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

const Md = Object.values({ ...MdIcons });
addIcons(...Md);

const app = createApp(App);
app.use(Toast);
app.use(router);
app.use(store);
app.component("v-icon", OhVueIcon); // Use the Vuex store
app.mount("#app");

export default axios;

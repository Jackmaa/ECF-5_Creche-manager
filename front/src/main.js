import "./assets/main.css";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import { createLucideIcon } from "lucide-vue-next";

import {
  Home,
  Users,
  DollarSign,
  Megaphone,
  UserCircle,
  MessageCircle,
  Eye,
  EyeOff,
} from "lucide-vue-next";

const app = createApp(App);

app.component("LucideHome", Home);
app.component("LucideUsers", Users);
app.component("LucideDollarSign", DollarSign);
app.component("LucideMegaphone", Megaphone);
app.component("LucideUserCircle", UserCircle);
app.component("LucideMessageCircle", MessageCircle);
app.component("LucideEye", Eye);
app.component("LucideEyeOff", EyeOff);

app.use(router);
app.mount("#app");

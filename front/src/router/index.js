// src/router/index.js
import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";
import Dashboard from "../views/Dashboard.vue";
import ChildrenList from "../views/ChildrenList.vue";
import ChildDetails from "../views/ChildDetails.vue";
import AddEditChild from "../views/AddEditChild.vue";
import GuardiansList from "../views/GuardiansList.vue";
import GuardianDetails from "../views/GuardianDetails.vue";
import AddEditGuardian from "../views/AddEditGuardian.vue";
import Attendance from "../views/Attendance.vue";
import Stats from "../views/Stats.vue";
import Settings from "../views/Settings.vue";
import StaffList from "../views/StaffList.vue";
import StaffDetails from "../views/StaffDetails.vue";
import AddEditStaff from "../views/AddEditStaff.vue";
import Announcements from "../views/Announcements.vue";
import Billing from "../views/Billing.vue";
import Messages from "../views/Messages.vue";

const routes = [
  { path: "/", redirect: "/login" },
  { path: "/login", component: Login },
  { path: "/dashboard", component: Dashboard },

  { path: "/children", name: "Children", component: ChildrenList },
  { path: "/children/:id", name: "ChildDetails", component: ChildDetails },
  {
    path: "/children/:id/edit",
    name: "EditChild",
    component: AddEditChild,
  },
  { path: "/children/add", name: "AddChild", component: AddEditChild },
  { path: "/guardians", name: "Guardians", component: GuardiansList },
  {
    path: "/guardians/:id",
    name: "GuardianDetails",
    component: GuardianDetails,
  },
  {
    path: "/guardians/:id/edit",
    name: "EditGuardian",
    component: AddEditGuardian,
  },
  { path: "/attendance", name: "Attendance", component: Attendance },
  { path: "/stats", name: "Stats", component: Stats },
  { path: "/settings", name: "Settings", component: Settings },

  { path: "/staff", name: "StaffList", component: StaffList },
  { path: "/staff/:id", name: "StaffDetails", component: StaffDetails },
  { path: "/staff/:id/edit", name: "EditStaff", component: AddEditStaff },

  { path: "/announcements", name: "Announcements", component: Announcements },
  { path: "/billing", name: "Billing", component: Billing },
  { path: "/messages", name: "Messages", component: Messages },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;

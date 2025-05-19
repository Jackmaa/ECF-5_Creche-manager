// src/services/api.js
import axios from "axios";

export const api = axios.create({
  baseURL: "/api", // avec vite.config.js qui proxy vers symfony
});

<template>
  <div>
    <p v-if="message">{{ message }}</p>
    <p v-else="">Loading...</p>
  </div>
</template>

<script setup>
import { api } from "@/services/api.js";
import { ref, onMounted } from "vue";

const message = ref("");

onMounted(async () => {
  try {
    const { data } = await api.get("/test");
    message.value = data.message;
  } catch (err) {
    message.value = err.response?.data?.message || "Accès non autorisé.";
  }
});
</script>

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
  const { data } = await api.get("/test");
  message.value = data.message;
});
</script>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const stats = ref({
  totalChildren: 0,
  totalGuardians: 0,
  totalStaff: 0,
  attendanceToday: 0,
});

const isLoading = ref(true);
const error = ref(null);

onMounted(async () => {
  try {
    const response = await axios.get("/api/stats");
    stats.value = response.data;
  } catch (err) {
    error.value = "Impossible de charger les statistiques.";
    console.error(err);
  } finally {
    isLoading.value = false;
  }
});
</script>

<template>
  <div class="p-6">
    <h1 class="text-3xl font-bold mb-6">📊 Tableau de bord</h1>

    <div v-if="isLoading" class="text-center py-10">
      <span class="loading loading-spinner loading-lg text-primary"></span>
    </div>

    <div v-else-if="error" class="text-red-500 text-center">
      {{ error }}
    </div>

    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="stat bg-base-200 p-4 rounded shadow">
        <div class="stat-title">Enfants inscrits</div>
        <div class="stat-value text-primary">{{ stats.totalChildren }}</div>
      </div>
      <div class="stat bg-base-200 p-4 rounded shadow">
        <div class="stat-title">Responsables</div>
        <div class="stat-value text-secondary">{{ stats.totalGuardians }}</div>
      </div>
      <div class="stat bg-base-200 p-4 rounded shadow">
        <div class="stat-title">Personnel</div>
        <div class="stat-value text-accent">{{ stats.totalStaff }}</div>
      </div>
      <div class="stat bg-base-200 p-4 rounded shadow">
        <div class="stat-title">Présents aujourd’hui</div>
        <div class="stat-value text-success">{{ stats.attendanceToday }}</div>
      </div>
    </div>
  </div>
</template>

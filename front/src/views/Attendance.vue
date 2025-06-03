<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
// import dayjs from "dayjs";

const children = ref([]);
const attendanceMap = ref({}); // id_enfant => bool
const isLoading = ref(true);
const error = ref(null);
const selectedDate = ref(dayjs().format("YYYY-MM-DD"));

// Récupérer les enfants à pointer
onMounted(fetchChildren);

async function fetchChildren() {
  try {
    const res = await axios.get("/api/children");
    children.value = res.data;
    // Initialiser toutes les présences à false
    attendanceMap.value = Object.fromEntries(
      children.value.map((c) => [c.id, false])
    );
  } catch (err) {
    error.value = "Erreur lors du chargement des enfants.";
    console.error(err);
  } finally {
    isLoading.value = false;
  }
}

async function submitAttendance() {
  try {
    const payload = Object.entries(attendanceMap.value).map(
      ([id, present]) => ({
        enfant_id: parseInt(id),
        date: selectedDate.value,
        present,
      })
    );
    await axios.post("/api/attendance", payload);
    alert("Présences enregistrées !");
  } catch (err) {
    error.value = "Erreur lors de l’enregistrement.";
    console.error(err);
  }
}
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">🕓 Présences – {{ selectedDate }}</h1>

    <div class="form-control mb-6 max-w-xs">
      <label class="label">Date</label>
      <input type="date" class="input input-bordered" v-model="selectedDate" />
    </div>

    <div v-if="isLoading" class="text-center py-10">
      <span class="loading loading-spinner text-primary loading-lg"></span>
    </div>

    <div v-else-if="error" class="text-red-500 text-center">
      {{ error }}
    </div>

    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <div
        v-for="child in children"
        :key="child.id"
        class="card bg-base-100 shadow-md"
      >
        <div class="card-body">
          <h2 class="card-title">{{ child.prenom }} {{ child.nom }}</h2>
          <label class="cursor-pointer label">
            <span class="label-text">Présent</span>
            <input
              type="checkbox"
              class="toggle toggle-success"
              v-model="attendanceMap[child.id]"
            />
          </label>
        </div>
      </div>
    </div>

    <div class="mt-6">
      <button @click="submitAttendance" class="btn btn-primary">
        ✅ Enregistrer les présences
      </button>
    </div>
  </div>
</template>

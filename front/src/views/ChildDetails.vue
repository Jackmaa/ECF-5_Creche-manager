<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";

const route = useRoute();
const router = useRouter();
const child = ref(null);
const isLoading = ref(true);
const error = ref(null);

onMounted(async () => {
  try {
    const response = await axios.get(`/api/children/${route.params.id}`);
    child.value = response.data;
  } catch (err) {
    error.value = "Impossible de charger les informations de l’enfant.";
    console.error(err);
  } finally {
    isLoading.value = false;
  }
});

function goToEdit() {
  router.push({ name: "EditChild", params: { id: route.params.id } });
}
</script>

<template>
  <div class="max-w-xl mx-auto p-6">
    <div v-if="isLoading" class="text-center py-10">
      <span class="loading loading-spinner loading-lg text-primary"></span>
    </div>

    <div v-else-if="error" class="text-red-500 text-center">
      {{ error }}
    </div>

    <div v-else>
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">
          👧 {{ child.prenom }} {{ child.nom }}
        </h1>
        <button @click="goToEdit" class="btn btn-outline btn-primary">
          ✏️ Modifier
        </button>
      </div>

      <div class="space-y-2 text-lg">
        <p><strong>Âge :</strong> {{ child.age }} ans</p>
        <p><strong>Classe :</strong> {{ child.classe || "Non assignée" }}</p>
        <p><strong>ID :</strong> {{ child.id }}</p>
        <!-- Tu peux ajouter d'autres champs ici : responsable, remarques, etc. -->
      </div>
    </div>
  </div>

  <div v-if="attendance.length" class="mt-8">
    <h2 class="text-xl font-semibold mb-2">📅 Historique des présences</h2>
    <table class="table w-full">
      <thead>
        <tr>
          <th>Date</th>
          <th>Présence</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="entry in attendance" :key="entry.date">
          <td>{{ entry.date }}</td>
          <td>
            <span
              class="badge"
              :class="entry.present ? 'badge-success' : 'badge-error'"
            >
              {{ entry.present ? "Présent" : "Absent" }}
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

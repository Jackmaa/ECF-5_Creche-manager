<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-3xl font-bold">👶 Enfants</h1>
      <router-link to="/children/add" class="btn btn-primary"
        >➕ Ajouter</router-link
      >
    </div>

    <div v-if="isLoading" class="text-center py-10">
      <span class="loading loading-spinner text-primary loading-lg"></span>
    </div>

    <div v-else-if="children.length === 0" class="text-center text-gray-500">
      Aucun enfant pour le moment.
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div
        v-for="child in children"
        :key="child.id"
        class="card bg-base-100 shadow-md hover:shadow-lg cursor-pointer"
        @click="goToDetails(child.id)"
      >
        <div class="card-body">
          <h2 class="card-title">{{ child.prenom }} {{ child.nom }}</h2>
          <p>Âge : {{ child.age }} ans</p>
          <p>Classe : {{ child.classe ?? "Non assignée" }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const children = ref([]);
const isLoading = ref(true);
const router = useRouter();

async function fetchChildren() {
  try {
    const response = await axios.get("/api/children"); // Ton endpoint Symfony
    children.value = response.data;
  } catch (error) {
    console.error("Erreur lors de la récupération des enfants", error);
  } finally {
    isLoading.value = false;
  }
}

onMounted(fetchChildren);

function goToDetails(id) {
  router.push({ name: "ChildDetails", params: { id } });
}
</script>

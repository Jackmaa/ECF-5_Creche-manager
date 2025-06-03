<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";

const route = useRoute();
const router = useRouter();
const guardian = ref(null);
const isLoading = ref(true);
const error = ref(null);

onMounted(async () => {
  try {
    const response = await axios.get(`/api/guardians/${route.params.id}`);
    guardian.value = response.data;
  } catch (err) {
    error.value = "Erreur lors du chargement du responsable.";
    console.error(err);
  } finally {
    isLoading.value = false;
  }
});

function goToChild(id) {
  router.push({ name: "ChildDetails", params: { id } });
}
</script>

<template>
  <div class="max-w-2xl mx-auto p-6">
    <div v-if="isLoading" class="text-center py-10">
      <span class="loading loading-spinner text-primary loading-lg"></span>
    </div>

    <div v-else-if="error" class="text-red-500 text-center">
      {{ error }}
    </div>

    <div v-else>
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">
          👤 {{ guardian.prenom }} {{ guardian.nom }}
        </h1>
        <router-link
          :to="`/guardians/${guardian.id}/edit`"
          class="btn btn-outline btn-primary"
        >
          ✏️ Modifier
        </router-link>
      </div>

      <div class="space-y-2 text-lg">
        <p><strong>Email :</strong> {{ guardian.email }}</p>
        <p><strong>Téléphone :</strong> {{ guardian.telephone }}</p>
      </div>

      <div class="mt-6">
        <h2 class="text-xl font-semibold mb-2">👶 Enfants liés</h2>
        <ul v-if="guardian.enfants?.length" class="list-disc pl-6 space-y-1">
          <li
            v-for="child in guardian.enfants"
            :key="child.id"
            @click="goToChild(child.id)"
            class="link link-hover text-blue-500 hover:text-blue-700 cursor-pointer"
          >
            {{ child.prenom }} {{ child.nom }}
          </li>
        </ul>
        <p v-else class="text-gray-500">Aucun enfant associé.</p>
      </div>
    </div>
  </div>
</template>

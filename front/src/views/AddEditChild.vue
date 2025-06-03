<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";

const route = useRoute();
const router = useRouter();
const isEdit = route.params.id !== undefined;
const isLoading = ref(isEdit);
const isSubmitting = ref(false);
const error = ref(null);

const prenom = ref("");
const nom = ref("");
const age = ref(null);
const classe = ref("");

// Pré-remplir si mode édition
onMounted(async () => {
  if (isEdit) {
    try {
      const response = await axios.get(`/api/children/${route.params.id}`);
      const child = response.data;
      prenom.value = child.prenom;
      nom.value = child.nom;
      age.value = child.age;
      classe.value = child.classe ?? "";
    } catch (err) {
      error.value = "Impossible de charger les données.";
      console.error(err);
    } finally {
      isLoading.value = false;
    }
  }
});

async function submitForm() {
  isSubmitting.value = true;
  error.value = null;

  const payload = {
    prenom: prenom.value,
    nom: nom.value,
    age: age.value,
    classe: classe.value,
  };

  try {
    if (isEdit) {
      await axios.put(`/api/children/${route.params.id}`, payload);
    } else {
      await axios.post("/api/children", payload);
    }

    router.push("/children");
  } catch (err) {
    error.value = "Erreur lors de la soumission.";
    console.error(err);
  } finally {
    isSubmitting.value = false;
  }
}
</script>

<template>
  <div class="max-w-xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">
      {{ isEdit ? "✏️ Modifier un enfant" : "➕ Ajouter un enfant" }}
    </h1>

    <div v-if="isLoading" class="text-center py-10">
      <span class="loading loading-spinner loading-lg text-primary"></span>
    </div>

    <form v-else @submit.prevent="submitForm" class="space-y-4">
      <div class="form-control">
        <label class="label">Prénom</label>
        <input
          v-model="prenom"
          type="text"
          class="input input-bordered"
          required
        />
      </div>

      <div class="form-control">
        <label class="label">Nom</label>
        <input
          v-model="nom"
          type="text"
          class="input input-bordered"
          required
        />
      </div>

      <div class="form-control">
        <label class="label">Âge</label>
        <input
          v-model="age"
          type="number"
          min="0"
          class="input input-bordered"
          required
        />
      </div>

      <div class="form-control">
        <label class="label">Classe</label>
        <input v-model="classe" type="text" class="input input-bordered" />
      </div>

      <div v-if="error" class="text-red-500 text-sm">{{ error }}</div>

      <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
        {{
          isSubmitting
            ? "Enregistrement..."
            : isEdit
            ? "Mettre à jour"
            : "Ajouter"
        }}
      </button>
    </form>
  </div>
</template>

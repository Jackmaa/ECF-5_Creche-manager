<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";

const route = useRoute();
const router = useRouter();
const isEdit = !!route.params.id;
const isLoading = ref(isEdit);
const isSubmitting = ref(false);
const error = ref(null);

const prenom = ref("");
const nom = ref("");
const email = ref("");
const telephone = ref("");

onMounted(async () => {
  if (isEdit) {
    try {
      const { data } = await axios.get(`/api/guardians/${route.params.id}`);
      prenom.value = data.prenom;
      nom.value = data.nom;
      email.value = data.email;
      telephone.value = data.telephone;
    } catch (err) {
      error.value = "Erreur lors du chargement.";
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
    email: email.value,
    telephone: telephone.value,
  };

  try {
    if (isEdit) {
      await axios.put(`/api/guardians/${route.params.id}`, payload);
    } else {
      await axios.post("/api/guardians", payload);
    }
    router.push("/guardians");
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
      {{ isEdit ? "✏️ Modifier un responsable" : "➕ Ajouter un responsable" }}
    </h1>

    <div v-if="isLoading" class="text-center py-10">
      <span class="loading loading-spinner text-primary loading-lg"></span>
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
        <label class="label">Email</label>
        <input
          v-model="email"
          type="email"
          class="input input-bordered"
          required
        />
      </div>

      <div class="form-control">
        <label class="label">Téléphone</label>
        <input
          v-model="telephone"
          type="tel"
          class="input input-bordered"
          required
        />
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

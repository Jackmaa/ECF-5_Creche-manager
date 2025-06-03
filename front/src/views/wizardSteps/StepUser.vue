<script setup>
import { reactive } from "vue";

const props = defineProps(["user"]);
const emit = defineEmits(["next"]);

if (!Array.isArray(props.user))
  props.user.splice(0, props.user.length, {
    prenom: "",
    nom: "",
    email: "",
    password: "",
  });

function addSecondParent() {
  if (props.user.length < 2) {
    props.user.push({ prenom: "", nom: "", email: "", password: "" });
  }
}

function removeSecondParent() {
  if (props.user.length === 2) {
    props.user.pop();
  }
}

function handleNext() {
  // TODO: validation simple ici si tu veux
  emit("next");
}
</script>

<template>
  <div class="space-y-6">
    <h2 class="text-xl font-semibold">👤 Création du/des parent(s)</h2>

    <div
      v-for="(u, index) in user"
      :key="index"
      class="border border-base-300 p-4 rounded-md space-y-3"
    >
      <h3 class="font-bold text-lg">👥 Parent {{ index + 1 }}</h3>

      <div class="form-control">
        <label class="label">Prénom</label>
        <input v-model="u.prenom" class="input input-bordered" />
      </div>

      <div class="form-control">
        <label class="label">Nom</label>
        <input v-model="u.nom" class="input input-bordered" />
      </div>

      <div class="form-control">
        <label class="label">Email</label>
        <input v-model="u.email" type="email" class="input input-bordered" />
      </div>

      <div class="form-control">
        <label class="label">Mot de passe</label>
        <input
          v-model="u.password"
          type="password"
          class="input input-bordered"
        />
      </div>

      <div v-if="index === 1" class="text-right">
        <button
          class="btn btn-sm btn-outline btn-error"
          @click="removeSecondParent"
        >
          ❌ Retirer ce parent
        </button>
      </div>
    </div>

    <div class="flex justify-between items-center">
      <button
        v-if="user.length < 2"
        class="btn btn-outline btn-sm"
        @click="addSecondParent"
      >
        ➕ Ajouter un second parent
      </button>

      <button class="btn btn-primary ml-auto" @click="handleNext">
        Suivant ➡️
      </button>
    </div>
  </div>
</template>

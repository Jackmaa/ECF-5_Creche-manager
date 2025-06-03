<script setup>
const props = defineProps(["children"]);
const emit = defineEmits(["next", "back"]);

// Initialiser s'il n'y a pas d'enfant
if (props.children.length === 0) {
  props.children.push({ prenom: "", nom: "", age: null, classe: "" });
}

function addChild() {
  if (props.children.length < 2) {
    props.children.push({ prenom: "", nom: "", age: null, classe: "" });
  }
}

function removeChild(index) {
  if (props.children.length > 1) {
    props.children.splice(index, 1);
  }
}

function handleNext() {
  // Optionnel : vérifier que tous les enfants ont prénom/nom/âge
  emit("next");
}

function handleBack() {
  emit("back");
}
</script>

<template>
  <div class="space-y-6">
    <h2 class="text-xl font-semibold">👶 Ajout d'enfant(s)</h2>

    <div
      v-for="(child, index) in children"
      :key="index"
      class="border border-base-300 p-4 rounded-md space-y-3"
    >
      <h3 class="font-bold text-lg">Enfant {{ index + 1 }}</h3>

      <div class="form-control">
        <label class="label">Prénom</label>
        <input v-model="child.prenom" class="input input-bordered" required />
      </div>

      <div class="form-control">
        <label class="label">Nom</label>
        <input v-model="child.nom" class="input input-bordered" required />
      </div>

      <div class="form-control">
        <label class="label">Âge</label>
        <input
          v-model="child.age"
          type="number"
          min="0"
          class="input input-bordered"
          required
        />
      </div>

      <div class="form-control">
        <label class="label">Classe</label>
        <input v-model="child.classe" class="input input-bordered" />
      </div>

      <div v-if="index === 1" class="text-right">
        <button
          class="btn btn-sm btn-outline btn-error"
          @click="removeChild(index)"
        >
          ❌ Retirer cet enfant
        </button>
      </div>
    </div>

    <div class="flex justify-between items-center">
      <button
        v-if="children.length < 2"
        class="btn btn-outline btn-sm"
        @click="addChild"
      >
        ➕ Ajouter un second enfant
      </button>

      <div class="ml-auto flex gap-2">
        <button class="btn btn-outline" @click="handleBack">⬅️ Retour</button>
        <button class="btn btn-primary" @click="handleNext">Suivant ➡️</button>
      </div>
    </div>
  </div>
</template>

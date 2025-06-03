<script setup>
const props = defineProps(["user", "guardians"]);
const emit = defineEmits(["next", "back"]);

if (props.guardians.length === 0) {
  props.user.forEach((u, i) => {
    props.guardians.push({
      nom: u.nom,
      prenom: u.prenom,
      email: u.email,
      telephone: "",
      fromUser: true,
      active: true,
    });
  });
}

function addGuardian() {
  props.guardians.push({
    nom: "",
    prenom: "",
    email: "",
    telephone: "",
    fromUser: false,
    active: true,
  });
}

function removeGuardian(index) {
  props.guardians.splice(index, 1);
}

function handleNext() {
  emit("next");
}

function handleBack() {
  emit("back");
}
</script>

<template>
  <div class="space-y-6">
    <h2 class="text-xl font-semibold">🧑‍🤝‍🧑 Responsables légaux</h2>

    <div
      v-for="(g, index) in guardians"
      :key="index"
      class="border border-base-300 p-4 rounded-md space-y-3"
    >
      <div class="flex justify-between items-center">
        <h3 class="font-bold text-lg">Responsable {{ index + 1 }}</h3>
        <span v-if="g.fromUser" class="text-xs text-gray-400"
          >(créé depuis un parent)</span
        >
      </div>

      <div class="form-control">
        <label class="label">Prénom</label>
        <input
          v-model="g.prenom"
          class="input input-bordered"
          :readonly="g.fromUser"
        />
      </div>

      <div class="form-control">
        <label class="label">Nom</label>
        <input
          v-model="g.nom"
          class="input input-bordered"
          :readonly="g.fromUser"
        />
      </div>

      <div class="form-control">
        <label class="label">Email</label>
        <input
          v-model="g.email"
          class="input input-bordered"
          :readonly="g.fromUser"
        />
      </div>

      <div class="form-control">
        <label class="label">Téléphone</label>
        <input v-model="g.telephone" class="input input-bordered" />
      </div>

      <div v-if="!g.fromUser" class="text-right">
        <button
          class="btn btn-outline btn-error btn-sm"
          @click="removeGuardian(index)"
        >
          ❌ Retirer ce responsable
        </button>
      </div>
    </div>

    <div class="flex justify-between items-center">
      <button class="btn btn-outline btn-sm" @click="addGuardian">
        ➕ Ajouter un autre responsable
      </button>

      <div class="ml-auto flex gap-2">
        <button class="btn btn-outline" @click="handleBack">⬅️ Retour</button>
        <button class="btn btn-primary" @click="handleNext">Suivant ➡️</button>
      </div>
    </div>
  </div>
</template>

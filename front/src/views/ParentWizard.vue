<script setup>
import { ref } from "vue";
import StepUser from "./wizardSteps/StepUser.vue";
import StepChildren from "./wizardSteps/StepChildren.vue";
import StepGuardians from "./wizardSteps/StepGuardians.vue";
import StepPresence from "./wizardSteps/StepPresence.vue";
import StepSummary from "./wizardSteps/StepSummary.vue";

const step = ref(1);

const user = ref([{ prenom: "", nom: "", email: "", password: "" }]);
const children = ref([]);
const guardians = ref([]);
const presence = ref([]);

const titreParÉtape = {
  1: "👤 Création du/des parent(s)",
  2: "👶 Ajout des enfant(s)",
  3: "🧑‍🤝‍🧑 Définir les responsables",
  4: "📅 Planifier les présences",
  5: "📋 Récapitulatif final",
};

const étapeActive = computed(() =>
  step.value === 1
    ? StepUser
    : step.value === 2
    ? StepChildren
    : step.value === 3
    ? StepGuardians
    : step.value === 4
    ? StepPresence
    : StepSummary
);

const propsParÉtape = computed(() => ({
  user: user.value,
  children: children.value,
  guardians: guardians.value,
  presence: presence.value,
}));

function next() {
  if (step.value < 5) step.value++;
}

function back() {
  if (step.value > 1) step.value--;
}

function submitAll() {
  alert("📤 TODO: Envoyer toutes les données à l’API !");
  console.log({
    users: user.value,
    children: children.value,
    guardians: guardians.value,
    presence: presence.value,
  });
}
</script>

<template>
  <WizardLayout
    :step="step"
    :totalSteps="5"
    :title="titreParÉtape[step]"
    :showBack="step > 1"
    :showNext="step < 5"
    :showFinish="step === 5"
    @back="back"
    @next="next"
    @finish="submitAll"
  >
    <component
      :is="étapeActive"
      v-bind="propsParÉtape"
      @next="next"
      @back="back"
    />
  </WizardLayout>
</template>

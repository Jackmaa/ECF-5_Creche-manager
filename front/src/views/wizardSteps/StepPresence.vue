<script setup>
import dayjs from "dayjs";

const props = defineProps(["children", "presence"]);
const emit = defineEmits(["next", "back"]);

// Jours de la semaine
const days = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi"];

// Générer les dates réelles de la semaine en cours (lundi à vendredi)
const today = dayjs();
const startOfWeek = today.startOf("week").add(1, "day"); // Lundi

const weekDates = days.map((_, i) =>
  startOfWeek.add(i, "day").format("YYYY-MM-DD")
);

// Initialisation si vide
if (props.presence.length === 0) {
  props.children.forEach((child, i) => {
    weekDates.forEach((date) => {
      props.presence.push({
        enfant_id: i,
        enfant: child.prenom + " " + child.nom,
        date,
        present: false,
      });
    });
  });
}

function togglePresence(enfant_id, date) {
  const record = props.presence.find(
    (p) => p.enfant_id === enfant_id && p.date === date
  );
  if (record) record.present = !record.present;
}

function isChecked(enfant_id, date) {
  return props.presence.find(
    (p) => p.enfant_id === enfant_id && p.date === date
  )?.present;
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
    <h2 class="text-xl font-semibold">📅 Présence sur la semaine</h2>

    <div class="overflow-auto">
      <table class="table w-full">
        <thead>
          <tr>
            <th>Enfant</th>
            <th v-for="(day, index) in days" :key="index">{{ day }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(child, enfant_id) in children" :key="enfant_id">
            <td>{{ child.prenom }} {{ child.nom }}</td>
            <td v-for="(date, j) in weekDates" :key="j">
              <input
                type="checkbox"
                class="checkbox checkbox-primary"
                :checked="isChecked(enfant_id, date)"
                @change="togglePresence(enfant_id, date)"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="flex justify-end gap-2">
      <button class="btn btn-outline" @click="handleBack">⬅️ Retour</button>
      <button class="btn btn-primary" @click="handleNext">Suivant ➡️</button>
    </div>
  </div>
</template>

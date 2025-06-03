<script setup>
const props = defineProps(["user", "children", "guardians", "presence"]);
const emit = defineEmits(["back"]);
</script>

<template>
  <div class="space-y-6">
    <h2 class="text-xl font-semibold mb-2">📋 Récapitulatif</h2>

    <!-- Parents -->
    <section>
      <h3 class="font-bold text-lg mb-2">👤 Parent(s)</h3>
      <ul class="space-y-1">
        <li v-for="(u, i) in user" :key="i">
          {{ u.prenom }} {{ u.nom }} – {{ u.email }}
        </li>
      </ul>
    </section>

    <!-- Enfants -->
    <section>
      <h3 class="font-bold text-lg mb-2">👶 Enfant(s)</h3>
      <ul class="space-y-1">
        <li v-for="(c, i) in children" :key="i">
          {{ c.prenom }} {{ c.nom }} – {{ c.age }} ans,
          {{ c.classe || "Classe non spécifiée" }}
        </li>
      </ul>
    </section>

    <!-- Responsables -->
    <section>
      <h3 class="font-bold text-lg mb-2">🧑‍🤝‍🧑 Responsables</h3>
      <ul class="space-y-1">
        <li v-for="(g, i) in guardians" :key="i">
          {{ g.prenom }} {{ g.nom }} – {{ g.email }} ({{
            g.telephone || "Téléphone non fourni"
          }})
        </li>
      </ul>
    </section>

    <!-- Présences -->
    <section>
      <h3 class="font-bold text-lg mb-2">📅 Présences prévues</h3>
      <div v-for="child in children" :key="child.nom" class="mb-4">
        <h4 class="font-semibold">{{ child.prenom }} {{ child.nom }}</h4>
        <ul class="flex flex-wrap gap-2 text-sm text-gray-700">
          <li
            v-for="entry in presence.filter(
              (p) => p.enfant === `${child.prenom} ${child.nom}` && p.present
            )"
            :key="entry.date"
            class="badge badge-outline"
          >
            {{ entry.date }}
          </li>
        </ul>
      </div>
    </section>

    <div class="flex justify-end gap-2">
      <button class="btn btn-outline" @click="emit('back')">⬅️ Retour</button>
      <button
        class="btn btn-success"
        @click="() => alert('💾 Données soumises !')"
      >
        ✅ Confirmer et enregistrer
      </button>
    </div>
  </div>
</template>

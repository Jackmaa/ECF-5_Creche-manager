<template>
  <table class="table table-zebra">
    <thead>
      <tr>
        <th>Enfant</th>
        <th>Arrivée</th>
        <th>Départ</th>
        <th>Présent ?</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="child in children" :key="child.id">
        <td>{{ child.name }}</td>
        <td>{{ child.check_in }}</td>
        <td>{{ child.check_out || "-" }}</td>
        <td>
          <span
            :class="
              child.check_out ? 'badge badge-error' : 'badge badge-success'
            "
          >
            {{ child.check_out ? "Non" : "Oui" }}
          </span>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
const props = defineProps({
  children: Array,
});
</script>

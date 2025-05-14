<template>
  <div class="card w-80 bg-base-100 shadow-md border border-neutral">
    <div class="card-body">
      <h2 class="card-title">{{ name }}</h2>
      <p>Présente depuis {{ checkInTime }}</p>
      <div class="card-actions justify-end">
        <BaseButton variant="success">Check-out</BaseButton>
      </div>
    </div>
  </div>
</template>

<script setup>
import BaseButton from "./BaseButton.vue";

const props = defineProps({
  name: String,
  checkInTime: String,
});
</script>

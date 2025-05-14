<template>
  <button class="btn" :class="variantClass">
    <slot></slot>
  </button>
</template>

<script setup>
const props = defineProps({
  variant: {
    type: String,
    default: "primary",
  },
});

const variantClass = `btn-${props.variant}`;
</script>

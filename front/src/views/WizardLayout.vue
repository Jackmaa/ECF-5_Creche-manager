<script setup>
const props = defineProps({
  step: Number,
  totalSteps: Number,
  title: String,
  showBack: Boolean,
  showNext: Boolean,
  showFinish: Boolean,
});

const emit = defineEmits(["next", "back", "finish"]);

function next() {
  emit("next");
}

function back() {
  emit("back");
}

function finish() {
  emit("finish");
}
</script>

<template>
  <div class="max-w-3xl mx-auto p-6 space-y-6">
    <div>
      <h1 class="text-3xl font-bold mb-2">{{ title }}</h1>
      <progress
        class="progress progress-primary w-full h-2"
        :value="step"
        :max="totalSteps"
      />
    </div>

    <div class="bg-base-100 shadow p-6 rounded-md">
      <slot />
    </div>

    <div class="flex justify-between mt-4">
      <button v-if="showBack" class="btn btn-outline" @click="back">
        ⬅️ Retour
      </button>
      <div class="ml-auto flex gap-2">
        <button v-if="showNext" class="btn btn-primary" @click="next">
          Suivant ➡️
        </button>
        <button v-if="showFinish" class="btn btn-success" @click="finish">
          ✅ Terminer
        </button>
      </div>
    </div>
  </div>
</template>

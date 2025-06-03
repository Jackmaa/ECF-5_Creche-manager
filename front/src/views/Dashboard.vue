<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

const navigateTo = (path) => {
  router.push(path);
};
</script>

<template>
  <div class="min-h-screen px-6 py-4 font-sans">
    <header class="flex items-center justify-between mb-6">
      <h1 class="text-xl font-semibold">Dashboard</h1>
      <button class="btn btn-ghost">
        <LucideUserCircle stroke="currentColor" />
      </button>
    </header>

    <section class="mb-6">
      <h2 class="text-lg font-medium mb-4">Today's Overview</h2>
      <div class="grid grid-cols-2 gap-4">
        <div class="card p-4 flex justify-between items-center border">
          <div>
            <p class="text-xl">Attendance</p>
            <p class="text-sm">120 children present</p>
          </div>
        </div>
        <div class="card p-4 flex justify-between items-center border">
          <div>
            <p class="text-xl">Staff</p>
            <p class="text-sm">25 educators on duty</p>
          </div>
        </div>
      </div>
    </section>

    <section class="mb-20">
      <h2 class="text-lg font-medium mb-4">Management Tools</h2>
      <div class="grid grid-cols-2 gap-4">
        <button
          class="btn btn-outline flex gap-2 justify-start"
          @click="navigateTo('/staff')"
        >
          <LucideUsers stroke="currentColor" />
          Staff
        </button>
        <button
          class="btn btn-outline flex gap-2 justify-start"
          @click="navigateTo('/billing')"
        >
          <LucideDollarSign stroke="currentColor" />
          Billing
        </button>
        <button
          class="btn btn-outline flex gap-2 justify-start"
          @click="navigateTo('/announcements')"
        >
          <LucideMegaphone stroke="currentColor" />
          Announcements
        </button>
      </div>
    </section>

    <nav
      class="fixed bottom-0 left-0 right-0 border-t shadow px-4 py-2 flex justify-around"
    >
      <button class="btn btn-ghost" @click="navigateTo('/dashboard')">
        <LucideHome stroke="currentColor" />
      </button>
      <button class="btn btn-ghost" @click="navigateTo('/children')">
        <LucideUsers stroke="currentColor" />
      </button>
      <button class="btn btn-ghost" @click="navigateTo('/staff')">
        <LucideUsers stroke="currentColor" />
      </button>
      <button class="btn btn-ghost" @click="navigateTo('/messages')">
        <LucideMessageCircle stroke="currentColor" />
      </button>
    </nav>
  </div>
</template>

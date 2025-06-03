<script setup>
import { ref, reactive, computed } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();
const email = ref("");
const password = ref("");
const showPassword = ref(false);
const error = ref("");

function togglePassword() {
  showPassword.value = !showPassword.value;
}

const touched = reactive({ email: false });
const isEmailValid = computed(() =>
  /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)
);

function validateEmail() {
  // la validation est réactive via le computed
}

async function handleLogin() {
  error.value = "";
  try {
    const response = await axios.post("/api/login", {
      email: email.value,
      password: password.value,
    });

    const token = response.data.token;
    localStorage.setItem("token", token);
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

    router.push("/dashboard");
  } catch (err) {
    error.value = "Invalid email or password.";
  }
}
</script>

<template>
  <div class="min-h-screen flex flex-col justify-center items-center px-4">
    <div class="w-full max-w-sm p-6 rounded-xl shadow-sm shadow-neutral-200">
      <h1 class="text-2xl font-bold mb-4 text-center">Login</h1>

      <form @submit.prevent="handleLogin" class="space-y-4">
        <div>
          <label class="label" for="email">
            <span class="label-text">Email</span>
          </label>
          <input
            v-model="email"
            type="email"
            id="email"
            placeholder="user@example.com"
            required
            @input="validateEmail"
            @blur="touched.email = true"
            :class="[
              'input input-bordered w-full shadow-sm',
              touched.email && !isEmailValid
                ? 'outline outline-2 outline-clr-error'
                : '',
              email && isEmailValid
                ? 'outline outline-2 outline-clr-emerald-300'
                : '',
            ]"
          />
          <p
            v-if="email && !isEmailValid && !touched.email"
            class="text-sm text-clr-warning mt-1"
          >
            Please enter a valid email format
          </p>
          <p
            v-if="touched.email && !isEmailValid"
            class="text-sm text-clr-error mt-1"
          >
            Please enter a valid email address
          </p>
        </div>

        <div>
          <label class="label" for="password">
            <span class="label-text">Password</span>
          </label>
          <div class="relative">
            <input
              v-model="password"
              :type="showPassword ? 'text' : 'password'"
              id="password"
              placeholder="••••••••"
              class="input input-bordered w-full pr-10 shadow-sm shadow-neutral-200 focus:outline-emerald-300"
              required
            />
            <button
              type="button"
              class="absolute right-2 top-3 text-gray-500"
              @click="togglePassword"
            >
              <LucideEye v-if="!showPassword" />
              <LucideEyeOff v-else />
            </button>
          </div>
        </div>

        <button
          class="btn btn-neutral w-full mt-2 shadow-sm shadow-neutral-200 hover:shadow-emerald-300"
          type="submit"
        >
          Log In
        </button>
      </form>

      <div v-if="error" class="mt-4 text-red-500 text-sm text-center">
        {{ error }}
      </div>
    </div>
  </div>
</template>

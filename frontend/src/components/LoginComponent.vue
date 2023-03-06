<template>
  <main class="p-10 h-screen">
    <div
      class="container h-full flex flex-col items-center justify-center w-full mx-auto gap-8"
    >
      <p class="text-xl font-semibold">Welcome to Menus Lab</p>
      <form
        class="grid bg-dark-blue gap-4 p-5 rounded-lg w-full max-w-xs"
        @submit.prevent="submitForm"
      >
        <input
          v-model="state.email"
          type="email"
          placeholder="Email Address"
          required
          class="py-2 text-base outline-none text-white bg-transparent border-b-2 border-white"
          autocomplete="off"
        />
        <div class="relative">
          <input
            v-model="state.password"
            :type="passwordFieldType"
            required
            placeholder="Password"
            class="w-full py-2 text-base outline-none text-white bg-transparent border-b-2 border-white"
            autocomplete="off"
          />

          <!-- for the icon that toggles between showing the password or not -->
          <div
            class="show-password absolute right-0 bottom-3 cursor-pointer"
            @click="togglePasswordVisibility"
          >
            <svg
              v-if="!state.passwordVisibility"
              class="h-5 w-5 text-white"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
              />
            </svg>
            <svg
              v-if="state.passwordVisibility"
              class="h-5 w-5 text-white"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
              />
            </svg>
          </div>
        </div>
        <button
          class="button bg-dark-blue-2 rounded px-3 py-2 mt-3 hover:bg-dark-blue-2/80 text-white font-semibold"
          type="submit"
          :disabled="loading"
        >
          <span class="button__text">Login</span>
        </button>
      </form>
    </div>
  </main>
</template>

<script setup lang="ts">
import { reactive, ref } from "vue";
import { useRouter } from 'vue-router';
const router = useRouter()

let loading = ref(false);
let passwordFieldType = ref("password");

const state = reactive<{
  passwordVisibility: Boolean;
  email: String;
  password: String;
}>({
  passwordVisibility: false,
  email: "",
  password: "",
});

function togglePasswordVisibility(): void {
  passwordFieldType.value === "password"
    ? (passwordFieldType.value = "text")
    : (passwordFieldType.value = "password");
  state.passwordVisibility = !state.passwordVisibility;
}

function submitForm(): void {
  loading.value = true;
  router.push({path: '/users'})
  loading.value = false;
}
</script>

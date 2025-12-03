<script setup lang="ts">
import { ref } from 'vue';

// Стан: true = Вхід, false = Реєстрація
const isLoginMode = ref(true);
const email = ref('');
const password = ref('');
const errors = ref({ email: '', password: '' });

// Перемикання режимів
const toggleMode = (mode: boolean) => {
  isLoginMode.value = mode;
  errors.value = { email: '', password: '' };
  email.value = '';
  password.value = '';
};

const handleSubmit = () => {
  errors.value = { email: '', password: '' };
  let isValid = true;

  // Валідація Email
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!email.value) {
    errors.value.email = 'Введіть email';
    isValid = false;
  } else if (!emailRegex.test(email.value)) {
    errors.value.email = 'Некоректний формат';
    isValid = false;
  }

  // Валідація Пароля
  if (!password.value) {
    errors.value.password = 'Введіть пароль';
    isValid = false;
  } else if (password.value.length < 6) {
    errors.value.password = 'Мінімум 6 символів';
    isValid = false;
  }

  // Якщо все ОК
  if (isValid) {
    console.log('--- ДАНІ ФОРМИ ---');
    console.log('Режим:', isLoginMode.value ? 'Вхід' : 'Реєстрація');
    console.log('Email:', email.value);
    console.log('Password:', password.value);
    alert('Дані відправлено! Перевірте консоль (F12).');
  }
};
</script>

<template>
  <div class="min-h-screen bg-fated-red font-sans text-white flex flex-col items-center justify-center p-6">
    <div class="w-full max-w-sm flex flex-col items-center">

      <!-- Логотип -->
      <div class="flex flex-col items-center mb-10">
        <div class="w-24 h-24 bg-white border-[5px] border-black/10 rounded-full flex items-center justify-center mb-4 shadow-2xl">
          <svg class="w-12 h-12 text-fated-red" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
          </svg>
        </div>
        <h1 class="text-3xl font-black text-white tracking-[0.2em] drop-shadow-md">FATED</h1>
      </div>

      <!-- Перемикач -->
      <div class="flex w-full bg-black/20 rounded-full p-1.5 mb-8 gap-2 backdrop-blur-sm">
        <button
          @click="toggleMode(true)"
          class="flex-1 py-3 text-sm font-bold rounded-full transition-all duration-300"
          :class="isLoginMode ? 'bg-white text-fated-red shadow-lg' : 'text-white/70 hover:text-white'"
        >
          LOGIN
        </button>
        <button
          @click="toggleMode(false)"
          class="flex-1 py-3 text-sm font-bold rounded-full transition-all duration-300"
          :class="!isLoginMode ? 'bg-white text-fated-red shadow-lg' : 'text-white/70 hover:text-white'"
        >
          REGISTER
        </button>
      </div>

      <!-- Форма -->
      <form @submit.prevent="handleSubmit" class="flex flex-col w-full space-y-4">

        <!-- Email -->
        <div>
          <input
            v-model="email"
            type="text"
            placeholder="Email"
            class="w-full p-4 px-6 bg-white rounded-full text-gray-800 placeholder:text-gray-400 outline-none focus:ring-4 focus:ring-white/30 shadow-sm transition-all"
            :class="{'border-4 border-yellow-400': errors.email}"
          >
          <p v-if="errors.email" class="text-yellow-300 text-xs font-bold mt-1 ml-4">{{ errors.email }}</p>
        </div>

        <!-- Password -->
        <div>
          <input
            v-model="password"
            type="password"
            placeholder="Password"
            class="w-full p-4 px-6 bg-white rounded-full text-gray-800 placeholder:text-gray-400 outline-none focus:ring-4 focus:ring-white/30 shadow-sm transition-all"
            :class="{'border-4 border-yellow-400': errors.password}"
          >
          <p v-if="errors.password" class="text-yellow-300 text-xs font-bold mt-1 ml-4">{{ errors.password }}</p>
        </div>

        <div v-if="isLoginMode" class="flex justify-end pt-1">
          <a href="#" class="text-xs font-bold text-white/90 hover:text-white uppercase tracking-wide">Forgot Password?</a>
        </div>

        <!-- Кнопка -->
        <button
          type="submit"
          class="w-full py-4 bg-white text-fated-red rounded-full text-base font-extrabold uppercase tracking-widest shadow-xl hover:shadow-2xl hover:-translate-y-0.5 transition-all duration-300 mt-2"
        >
          {{ isLoginMode ? 'LOG IN' : 'SIGN UP' }}
        </button>

      </form>

      <!-- Футер -->
      <p class="text-xs text-white/80 mt-8 font-medium">
        {{ isLoginMode ? "Don't have an account?" : "Already have an account?" }}
        <button @click="toggleMode(!isLoginMode)" class="text-white font-bold underline decoration-2 underline-offset-4 ml-1">
          {{ isLoginMode ? 'Register' : 'Log in' }}
        </button>
      </p>

    </div>
  </div>
</template>

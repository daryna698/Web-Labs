<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// 1. Стан форми (тут зберігаються дані)
const form = ref({
  username: '',
  password: ''
})

// 2. Стан помилок
const errors = ref({
  username: '',
  password: ''
})

// 3. Функція валідації
const validate = () => {
  let isValid = true
  // Очищаємо попередні помилки
  errors.value = { username: '', password: '' }

  if (!form.value.username) {
    errors.value.username = 'Username is required'
    isValid = false
  }

  if (!form.value.password) {
    errors.value.password = 'Password is required'
    isValid = false
  } else if (form.value.password.length < 6) {
    errors.value.password = 'Password must be at least 6 chars'
    isValid = false
  }

  return isValid
}

// 4. Функція входу
const handleLogin = () => {
  if (validate()) {
    // Якщо валідація пройшла успішно:
    console.group('Login Data Submitted')
    console.log('Username:', form.value.username)
    console.log('Password:', form.value.password)
    console.groupEnd()

    window.alert("Вхід успішний! Дані в консолі.")
    // Тут можна зробити router.push('/dashboard')
  } else {
    console.warn('Form validation failed')
  }
}

const goToRegister = () => {
  router.push('/register')
}
</script>

<template>
  <div class="flex flex-col min-h-screen bg-[#FF5A5F] px-8 py-6 font-sans">

    <!-- Логотип -->
    <div class="flex flex-col items-center justify-center mt-8 mb-8">
      <div class="w-28 h-28 bg-[#FFE5E5] rounded-full flex items-center justify-center border-[6px] border-[#4A3B3B] shadow-lg mb-2 relative">
        <div class="w-20 h-20 border-[3px] border-[#4A3B3B] rounded-full flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-[#FF5A5F] mt-1">
            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
          </svg>
        </div>
      </div>
      <h1 class="font-logo text-5xl text-[#FFE5E5] tracking-widest drop-shadow-md">FATED</h1>
    </div>

    <!-- Вкладки -->
    <div class="flex flex-row gap-4 mb-8">
      <button class="flex-1 py-3 rounded-lg font-bold text-sm tracking-wider shadow-md bg-[#FFE5E5] text-[#FF5A5F]">
        LOGIN
      </button>
      <button @click="goToRegister" class="flex-1 py-3 rounded-lg font-bold text-sm tracking-wider shadow-sm bg-white/20 text-white hover:bg-white/30 transition-all">
        REGISTER
      </button>
    </div>

    <!-- Поля вводу -->
    <div class="space-y-4 w-full">

      <!-- Username Input -->
      <div>
        <input
          v-model="form.username"
          type="text"
          placeholder="user name"
          class="w-full p-4 rounded-xl bg-[#FFE5E5] text-[#4A4A4A] placeholder-gray-500 font-bold text-center shadow-inner focus:outline-none focus:ring-4 focus:ring-white/40"
          :class="{ 'ring-4 ring-red-800 bg-red-100': errors.username }"
        />
        <p v-if="errors.username" class="text-white text-xs font-bold mt-1 text-center bg-red-800/20 rounded py-1">
          {{ errors.username }}
        </p>
      </div>

      <!-- Password Input -->
      <div>
        <input
          v-model="form.password"
          type="password"
          placeholder="password"
          class="w-full p-4 rounded-xl bg-[#FFE5E5] text-[#4A4A4A] placeholder-gray-500 font-bold text-center shadow-inner focus:outline-none focus:ring-4 focus:ring-white/40"
          :class="{ 'ring-4 ring-red-800 bg-red-100': errors.password }"
        />
        <p v-if="errors.password" class="text-white text-xs font-bold mt-1 text-center bg-red-800/20 rounded py-1">
          {{ errors.password }}
        </p>
      </div>

    </div>

    <div class="w-full flex justify-end mt-3">
      <p class="text-xs text-white font-bold uppercase tracking-wide opacity-90 cursor-pointer hover:opacity-100">
        Forgot Password?
      </p>
    </div>

    <button
      @click="handleLogin"
      class="w-full bg-[#FFE5E5] text-[#FF5A5F] font-black text-lg py-4 rounded-xl shadow-xl mt-8 hover:bg-white hover:scale-[1.02] active:scale-95 transition-all uppercase tracking-widest"
    >
      Login
    </button>

    <div class="mt-auto mb-4 text-center pt-8">
      <p class="text-xs text-white/80 font-bold uppercase tracking-wide">
        Don't have an account?
        <span @click="goToRegister" class="text-white font-black cursor-pointer hover:underline ml-1">Register</span>
      </p>
    </div>

  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Nunito:wght@600;700;900&display=swap');

.font-sans {
  font-family: 'Nunito', sans-serif;
}
.font-logo {
  font-family: 'Fredoka One', cursive;
}
</style>

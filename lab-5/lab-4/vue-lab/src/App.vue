<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header>
    <div class="max-w-4xl mx-auto">
      <nav class="p-4 bg-gray-100 rounded-b-lg shadow-md flex gap-4 dark:bg-gray-800">
        <RouterLink to="/" class="text-blue-600 hover:underline dark:text-blue-400">Home</RouterLink>
        <RouterLink to="/about" class="text-blue-600 hover:underline dark:text-blue-400">About</RouterLink>
        <RouterLink to="/contact" class="text-blue-600 hover:underline dark:text-blue-400">Contact</RouterLink>
      </nav>
    </div>
  </header>

  <main class="max-w-4xl mx-auto mt-5 p-4">
    <RouterView />
  </main>
</template>

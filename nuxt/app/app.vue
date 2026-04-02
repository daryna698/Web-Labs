<script setup>
useHead({
  script: [
    { src: 'https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js', defer: true }
  ],
  meta: [
    { name: 'viewport', content: 'width=device-width, initial-scale=1' }
  ],
  htmlAttrs: { lang: 'uk' }
})
</script>

<template>
  <UApp>
    <UHeader class="bg-white border-b border-gray-200">
      <template #left>
        <NuxtLink to="/" class="mr-6 flex items-center gap-2">
          <iconify-icon icon="logos:nuxt-icon" class="text-2xl"></iconify-icon>
          <span class="font-bold text-xl text-gray-900">Nuxt</span>
        </NuxtLink>

        <nav class="flex gap-6 font-medium text-sm">
          <NuxtLink
            to="/"
            class="text-gray-500 hover:text-gray-900 transition-colors py-4"
            active-class="text-[#00DC82] font-bold border-b-2 border-[#00DC82]"
          >
            Список продуктів
          </NuxtLink>
          <NuxtLink
            to="/products"
            class="text-gray-500 hover:text-gray-900 transition-colors py-4"
            active-class="text-[#00DC82] font-bold border-b-2 border-[#00DC82]"
          >
            Таблиця
          </NuxtLink>
        </nav>
      </template>
    </UHeader>

    <UMain class="min-h-screen bg-gray-50 py-10">
      <NuxtPage />
    </UMain>

    <UFooter>
      <template #left>
        <p class="text-sm text-gray-400">Built with Nuxt UI • {{ new Date().getFullYear() }}</p>
      </template>
    </UFooter>
  </UApp>
</template>

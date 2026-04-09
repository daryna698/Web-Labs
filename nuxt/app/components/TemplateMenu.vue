<template>
  <div class="flex items-center gap-2">
    <UDropdownMenu
      v-slot="{ open }"
      :modal="false"
      :items="[{
        label: 'Starter',
        to: 'https://starter-template.nuxt.dev/',
        color: 'primary',
        checked: true,
        type: 'checkbox'
      }, {
        label: 'Landing',
        to: 'https://landing-template.nuxt.dev/'
      }, {
        label: 'Docs',
        to: 'https://docs-template.nuxt.dev/'
      }, {
        label: 'SaaS',
        to: 'https://saas-template.nuxt.dev/'
      }, {
        label: 'Dashboard',
        to: 'https://dashboard-template.nuxt.dev/'
      }, {
        label: 'Chat',
        to: 'https://chat-template.nuxt.dev/'
      }, {
        label: 'Portfolio',
        to: 'https://portfolio-template.nuxt.dev/'
      }, {
        label: 'Changelog',
        to: 'https://changelog-template.nuxt.dev/'
      }]"
      :content="{ align: 'start' }"
      :ui="{ content: 'min-w-fit' }"
      size="xs"
    >
      <UButton
        label="Starter"
        variant="subtle"
        trailing-icon="i-lucide-chevron-down"
        size="xs"
        class="-mb-[6px] font-semibold rounded-full truncate"
        :class="[open && 'bg-primary/15']"
        :ui="{
          trailingIcon: ['transition-transform duration-200', open ? 'rotate-180' : undefined].filter(Boolean).join(' ')
        }"
      />
    </UDropdownMenu>

    <ClientOnly>
      <UButton
        :icon="isDark ? 'i-lucide-moon' : 'i-lucide-sun'"
        color="gray"
        variant="ghost"
        size="xs"
        aria-label="Theme toggle"
        class="-mb-[6px] rounded-full"
        @click="toggleTheme"
      />
    </ClientOnly>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const isDark = ref(false)

const toggleTheme = () => {
  isDark.value = !isDark.value
  if (isDark.value) {
    document.documentElement.classList.add('dark')
    localStorage.setItem('theme', 'dark')
  } else {
    document.documentElement.classList.remove('dark')
    localStorage.setItem('theme', 'light')
  }
}

onMounted(() => {
  if (localStorage.getItem('theme') === 'dark') {
    isDark.value = true
    document.documentElement.classList.add('dark')
  }
})
</script>

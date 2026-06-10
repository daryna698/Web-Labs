<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-sm border border-gray-200">
      <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Управління публікаціями (Nuxt UI)</h1>

      <div class="mb-4 flex justify-between items-center">
        <UButton to="/admin/blog/posts/create" color="primary" variant="solid">
          Додати публікацію
        </UButton>
      </div>

      <UTable
        :key="page"
        :columns="columns"
        :data="paginatedPosts"
        class="w-full"
      />

      <div class="flex justify-end mt-6 border-t pt-4">
        <UPagination
          v-model:page="page"
          :page-count="pageCount"
          :total="posts.length"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'

// --- Стан компонента ---
const posts = ref<any[]>([])
const page = ref(1)
const pageCount = 10 // Скільки записів показувати на одній сторінці

// --- ОНОВЛЕНІ КОЛОНКИ (використовуємо accessorKey та header) ---
const columns: any[] = [
  { accessorKey: 'id', header: '#' },
  { accessorKey: 'author', header: 'Автор' },
  { accessorKey: 'category', header: 'Категорія' },
  { accessorKey: 'title', header: 'Заголовок' },
  { accessorKey: 'published_at', header: 'Дата публікації' }
]

// --- Отримання даних з Laravel ---
const fetchPosts = async () => {
  try {
    const response = await $fetch<any>('http://localhost:80/api/blog/posts')

    const rawData = response.data || response
    posts.value = rawData.map((post: any) => ({
      id: post.id,
      author: post.user?.name || 'Невідомо',
      category: post.category?.title || 'Невідомо',
      title: post.title,
      published_at: post.published_at || 'Чернетка'
    }))
  } catch (error) {
    console.error('Помилка завантаження:', error)
  }
}

// --- Пагінація ---
const paginatedPosts = computed(() => {
  const start = (page.value - 1) * pageCount
  const end = start + pageCount
  return posts.value.slice(start, end)
})

onMounted(() => {
  fetchPosts()
})
</script>

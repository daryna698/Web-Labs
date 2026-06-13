<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-2xl mx-auto">
      <UButton
        to="/BlogPostsUi"
        icon="i-heroicons-arrow-left"
        variant="ghost"
        color="neutral"
        class="mb-4"
      >
        Назад до таблиці
      </UButton>

      <div v-if="pending" class="text-center py-10 text-gray-500">
        Завантаження статті...
      </div>

      <div v-else-if="error" class="text-center py-10 text-red-500 font-medium">
        Статтю не знайдено або сталася помилка сервера.
      </div>

      <UCard v-else-if="post">
        <template #header>
          <h1 class="text-2xl font-bold text-gray-900">
            {{ post.title }}
          </h1>
          <p class="text-xs text-gray-400 mt-1">
            ID поста: {{ post.id }}
          </p>
        </template>

        <div class="space-y-4">
          <div>
            <span class="text-sm font-semibold text-gray-500 block">Slug (ЧПУ):</span>
            <span class="font-mono bg-gray-100 px-2 py-0.5 rounded text-sm text-gray-700">{{ post.slug }}</span>
          </div>

          <div>
            <span class="text-sm font-semibold text-gray-500 block">Дата публікації:</span>
            <span class="text-gray-700">{{ post.date_published || 'Не опубліковано' }}</span>
          </div>

          <div>
            <span class="text-sm font-semibold text-gray-500 block">Статус:</span>
            <UBadge :color="post.is_published ? 'success' : 'neutral'" class="mt-1">
              {{ post.is_published ? 'Опубліковано' : 'Чернетка' }}
            </UBadge>
          </div>
        </div>
      </UCard>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'

interface Post {
  id: number
  title: string
  slug: string
  is_published: boolean
  date_published: string | null
}

const route = useRoute()
const postId = route.params.id

// Запит до нашого ендпоінту show
const { data: response, pending, error } = await useFetch<{ data: Post }>(
  `http://localhost/api/blog/posts/${postId}`
)

const post = computed(() => response.value?.data || null)
</script>

<template>
  <div class="container mx-auto p-4">
    <div class="flex justify-center">
      <div class="w-full">
        <nav class="navbar bg-gray-100 p-3 mb-4 rounded">
          <a href="/admin/blog/posts/create" class="text-blue-600 hover:underline">Додати</a>
        </nav>
        <div class="card border rounded shadow-sm bg-white">
          <div class="card-body p-4">
            <table class="table-auto w-full text-left border-collapse">
              <thead>
              <tr class="bg-gray-50 border-b">
                <th class="p-2">#</th>
                <th class="p-2">Автор</th>
                <th class="p-2">Категорія</th>
                <th class="p-2">Заголовок</th>
                <th class="p-2">Дата публікації</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="post in posts" :key="post.id" class="border-b hover:bg-gray-50">
                <td class="p-2">{{ post.id }}</td>
                <td class="p-2">{{ post.user?.name || 'Невідомо' }}</td>
                <td class="p-2">{{ post.category?.title || 'Невідомо' }}</td>
                <td class="p-2">
                  <a :href="'/admin/blog/posts/' + post.id + '/edit'" class="text-blue-500 hover:underline">
                    {{ post.title }}
                  </a>
                </td>
                <td class="p-2">{{ post.published_at || 'Чернетка' }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const posts = ref<any[]>([])

const getPosts = async () => {
  try {
    // Запит до твого Laravel
    const response = await $fetch<any>('http://localhost:80/api/blog/posts')
    console.log('Дані з API:', response)
    posts.value = response.data || response
  } catch (error) {
    console.error('Помилка завантаження постів:', error)
  }
}

getPosts()
</script>

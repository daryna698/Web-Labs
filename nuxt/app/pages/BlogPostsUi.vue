<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-sm border border-gray-200">
      <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">
        Управління публікаціями
      </h1>

      <div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-4">
        <UButton
          to="/admin/blog/posts/create"
          color="primary"
          variant="solid"
          icon="i-heroicons-plus"
        >
          Додати публікацію
        </UButton>

        <UInput
          v-model="search"
          icon="i-heroicons-magnifying-glass-20-solid"
          placeholder="Пошук..."
          class="w-full sm:w-64"
        />
      </div>

      <UTable
        :columns="columns"
        :data="posts"
        :loading="pending"
        class="w-full"
      >
        <template #title-cell="{ row }">
          <NuxtLink
            :to="`/posts/${row.original.id}`"
            class="text-blue-500 hover:underline font-medium text-left"
          >
            {{ row.original.title }}
          </NuxtLink>
        </template>

        <template #actions-cell="{ row }">
          <UDropdownMenu :items="getActionItems(row.original)">
            <UButton
              color="neutral"
              variant="ghost"
              icon="i-heroicons-ellipsis-horizontal-20-solid"
            />
          </UDropdownMenu>
        </template>
      </UTable>

      <div class="flex flex-col sm:flex-row justify-between items-center mt-6 border-t pt-4 gap-4">
        <div class="flex items-center gap-2 text-sm text-gray-500">
          <span>Показувати по:</span>
          <USelect
            v-model="perPage"
            :items="[5, 10, 20, 50]"
            size="sm"
            class="w-20"
          />
        </div>

        <UPagination
          v-model:page="page"
          :items-per-page="perPage"
          :total="total"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch, onMounted } from 'vue'

interface RawPost {
  id?: number | string
  title?: string
  date_published?: string | null
  author_name?: string | null
  category_title?: string | null
}

interface ApiResponse {
  data?: RawPost[]
  meta?: { total?: number }
}

interface Post {
  id: number
  author: string
  category: string
  title: string
  published_at: string
}

const posts = ref<Post[]>([])
const page = ref(1)
const perPage = ref(10)
const total = ref(0)
const search = ref('')
const pending = ref(false)

const columns = [
  { accessorKey: 'id', header: '#' },
  { accessorKey: 'author', header: 'Автор' },
  { accessorKey: 'category', header: 'Категорія' },
  { accessorKey: 'title', header: 'Заголовок' },
  { accessorKey: 'published_at', header: 'Дата публікації' },
  { accessorKey: 'actions', header: 'Дії' }
]

const getActionItems = (post: Post) => [
  [
    {
      label: 'Редагувати',
      icon: 'i-heroicons-pencil-square-20-solid',
      to: `/admin/blog/posts/${post.id}/edit`
    },
    {
      label: 'Видалити',
      icon: 'i-heroicons-trash-20-solid',
      onClick: () => removePost(post.id)
    }
  ]
]

const fetchPosts = async () => {
  pending.value = true
  try {
    const response = await $fetch<ApiResponse>('http://localhost:80/api/admin/blog/posts', {
      query: {
        page: page.value,
        per_page: perPage.value,
        search: search.value
      }
    })

    const rawData = Array.isArray(response?.data) ? response.data : []

    posts.value = rawData.map(post => ({
      id: Number(post?.id),
      author: post?.author_name || 'Невідомо',
      category: post?.category_title || 'Невідомо',
      title: post?.title || '',
      published_at: post?.date_published || 'Чернетка'
    }))

    total.value = response?.meta?.total ?? rawData.length
  } catch (e) {
    console.error('Помилка завантаження даних:', e)
  } finally {
    pending.value = false
  }
}

const removePost = async (id: number) => {
  if (!confirm('Видалити цю статтю?')) return

  try {
    await $fetch(`http://localhost:80/api/admin/blog/posts/${id}`, {
      method: 'DELETE'
    })
    await fetchPosts()
  } catch (e) {
    console.error('Помилка видалення:', e)
  }
}

watch([page, perPage], fetchPosts)

watch(search, () => {
  page.value = 1
  fetchPosts()
})

onMounted(() => {
  fetchPosts()
})
</script>

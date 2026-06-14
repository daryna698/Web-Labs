<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-sm border border-gray-200">
      <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">
        Категорії блогу
      </h1>

      <div class="mb-4">
        <UButton
          to="/admin/blog/categories/create"
          color="primary"
          variant="solid"
          icon="i-heroicons-plus"
        >
          Додати категорію
        </UButton>
      </div>

      <UTable
        :columns="columns"
        :data="categories"
        :loading="pending"
        class="w-full"
      >
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

      <div class="flex justify-center mt-6 border-t pt-4">
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

interface RawCategory {
  id: number
  title: string
  slug: string | null
  description: string | null
  parent_id: number | null
  parent_title: string | null
}

interface ApiResponse {
  data: RawCategory[]
  meta?: { total?: number }
}

const categories = ref<RawCategory[]>([])
const page = ref(1)
const perPage = ref(10)
const total = ref(0)
const pending = ref(false)

const columns = [
  { accessorKey: 'id', header: '#' },
  { accessorKey: 'title', header: 'Назва' },
  { accessorKey: 'parent_title', header: 'Батьківська категорія' },
  { accessorKey: 'slug', header: 'Slug' },
  { accessorKey: 'actions', header: 'Дії' }
]

const getActionItems = (category: RawCategory) => [
  [
    {
      label: 'Редагувати',
      icon: 'i-heroicons-pencil-square-20-solid',
      to: `/admin/blog/categories/${category.id}/edit`
    },
    {
      label: 'Видалити',
      icon: 'i-heroicons-trash-20-solid',
      onClick: () => removeCategory(category.id)
    }
  ]
]

const fetchCategories = async () => {
  pending.value = true
  try {
    const response = await $fetch<ApiResponse>('http://localhost:80/api/admin/blog/categories', {
      query: { page: page.value }
    })

    categories.value = response.data
    total.value = response.meta?.total ?? response.data.length
  } catch (e) {
    console.error('Помилка завантаження категорій:', e)
  } finally {
    pending.value = false
  }
}

const removeCategory = async (id: number) => {
  if (!confirm('Видалити цю категорію?')) return

  try {
    await $fetch(`http://localhost:80/api/admin/blog/categories/${id}`, {
      method: 'DELETE'
    })
    await fetchCategories()
  } catch (e) {
    console.error('Помилка видалення:', e)
  }
}

watch(page, fetchCategories)

onMounted(() => {
  fetchCategories()
})
</script>

<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-sm border border-gray-200">
      <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">
        Категорії блогу
      </h1>

      <div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-4">
        <UButton
          to="/admin/blog/categories/create"
          color="primary"
          variant="solid"
          icon="i-heroicons-plus"
        >
          Додати категорію
        </UButton>

        <UInput
          v-model="search"
          icon="i-heroicons-magnifying-glass-20-solid"
          placeholder="Пошук за назвою..."
          class="w-full sm:w-64"
        />
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

const toast = useToast()

const categories = ref<RawCategory[]>([])
const page = ref(1)
const perPage = ref(10)
const total = ref(0)
const search = ref('')
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
      query: {
        page: page.value,
        per_page: perPage.value,
        search: search.value
      }
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

    toast.add({
      title: 'Категорію видалено',
      color: 'success',
      duration: 3000
    })

    await fetchCategories()
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    toast.add({
      title: 'Неможливо видалити',
      description: err?.data?.message || 'Помилка видалення',
      color: 'error',
      duration: 5000
    })
  }
}

watch([page, perPage], fetchCategories)

watch(search, () => {
  page.value = 1
  fetchCategories()
})

onMounted(() => {
  fetchCategories()
})
</script>

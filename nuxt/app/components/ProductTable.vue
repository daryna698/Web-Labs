<template>
  <div class="max-w-[1200px] mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-800">Список продуктів</h2>
      <UInput v-model="searchQuery" placeholder="Пошук..." class="w-72" />
    </div>

    <div class="overflow-x-auto">
      <UTable
        :data="paginatedRows"
        :columns="columns"
        class="bg-white shadow-sm border border-gray-200 rounded-lg min-w-[900px]"
      >
        <template #description-cell="{ row }">
          <div class="max-w-[250px] truncate text-gray-600" :title="row.original.description">
            {{ row.original.description }}
          </div>
        </template>

        <template #thumbnail-cell="{ row }">
          <img :src="row.original.thumbnail" alt="Product" class="w-[60px] h-[60px] object-cover rounded-md border border-gray-100" />
        </template>

        <template #rating-cell="{ row }">
          <span :class="row.original.rating < 4.5 ? 'text-red-500 font-bold' : 'text-green-500 font-bold'">
            {{ row.original.rating }}
          </span>
        </template>

        <template #price-cell="{ row }">
          <span class="font-semibold text-gray-800">${{ row.original.price }}</span>
        </template>
      </UTable>
    </div>

    <div class="mt-6 flex justify-end">
      <UPagination
        v-model:page="currentPage"
        :total="sortedAndFilteredProducts.length"
        :items-per-page="itemsPerPage"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const { data: productsData } = await useFetch('https://dummyjson.com/products?limit=0')
const allProducts = computed(() => productsData.value?.products || [])

const columns = [
  { id: 'title', accessorKey: 'title', header: 'Назва' },
  { id: 'description', accessorKey: 'description', header: 'Опис' },
  { id: 'price', accessorKey: 'price', header: 'Ціна' },
  { id: 'rating', accessorKey: 'rating', header: 'Оцінка' },
  { id: 'brand', accessorKey: 'brand', header: 'Бренд' },
  { id: 'category', accessorKey: 'category', header: 'Категорія' },
  { id: 'thumbnail', accessorKey: 'thumbnail', header: 'Фото' }
]

const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(5)

const sortedAndFilteredProducts = computed(() => {
  let result = [...allProducts.value]
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    result = result.filter(product =>
      Object.values(product).some(val => String(val).toLowerCase().includes(query))
    )
  }
  return result
})

const paginatedRows = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = currentPage.value * itemsPerPage.value
  return sortedAndFilteredProducts.value.slice(start, end)
})

watch(searchQuery, () => {
  currentPage.value = 1
})
</script>

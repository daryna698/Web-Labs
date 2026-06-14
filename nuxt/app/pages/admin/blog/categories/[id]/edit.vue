<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-sm border border-gray-200">
      <UButton
        to="/admin/blog/categories"
        icon="i-heroicons-arrow-left"
        variant="ghost"
        color="neutral"
        class="mb-4"
      >
        Назад до категорій
      </UButton>

      <h1 class="text-2xl font-bold mb-6 text-gray-800">
        Редагування категорії
      </h1>

      <div
        v-if="loading"
        class="text-gray-500"
      >
        Завантаження...
      </div>

      <UForm
        v-else
        :schema="schema"
        :state="state"
        class="space-y-4"
        @submit="onSubmit"
      >
        <UFormField
          label="Назва"
          name="title"
          required
        >
          <UInput
            v-model="state.title"
            class="w-full"
          />
        </UFormField>

        <UFormField
          label="Slug (ЧПУ)"
          name="slug"
          hint="Можна залишити порожнім"
        >
          <UInput
            v-model="state.slug"
            class="w-full"
          />
        </UFormField>

        <UFormField
          label="Опис"
          name="description"
        >
          <UTextarea
            v-model="state.description"
            class="w-full"
            :rows="3"
          />
        </UFormField>

        <UFormField
          label="Батьківська категорія"
          name="parent_id"
          required
        >
          <USelect
            v-model="state.parent_id"
            :items="categoryItems"
            placeholder="Оберіть категорію"
            class="w-full"
          />
        </UFormField>

        <p
          v-if="generalError"
          class="text-red-500 text-sm"
        >
          {{ generalError }}
        </p>

        <UButton
          type="submit"
          color="primary"
          :loading="submitting"
        >
          Зберегти
        </UButton>
      </UForm>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref, onMounted } from 'vue'
import * as z from 'zod'
import type { FormSubmitEvent } from '@nuxt/ui'

const route = useRoute()
const router = useRouter()
const categoryId = route.params.id

const schema = z.object({
  title: z.string().min(5, 'Мінімум 5 символів').max(200, 'Максимум 200 символів'),
  slug: z.string().max(200, 'Максимум 200 символів').optional(),
  description: z.string().min(3, 'Мінімум 3 символи').max(500, 'Максимум 500 символів').optional(),
  parent_id: z.number({ error: 'Оберіть батьківську категорію' })
})

type Schema = z.output<typeof schema>

const state = reactive<Partial<Schema>>({
  title: '',
  slug: '',
  description: '',
  parent_id: undefined
})

interface CategoryComboItem {
  id: number
  id_title: string
}

interface CategoryData {
  id: number
  title: string
  slug: string | null
  description: string | null
  parent_id: number | null
}

const categoryItems = ref<{ label: string, value: number }[]>([])
const loading = ref(true)
const generalError = ref('')
const submitting = ref(false)

const getErrorMessage = (e: unknown): string => {
  if (e && typeof e === 'object' && 'data' in e) {
    const data = (e as { data?: { message?: string } }).data
    if (data?.message) {
      return data.message
    }
  }
  return 'Помилка збереження. Перевірте дані.'
}

const loadCategories = async () => {
  const data = await $fetch<CategoryComboItem[]>(
    'http://localhost:80/api/admin/blog/categories/combobox'
  )
  categoryItems.value = data.map(c => ({ label: c.id_title, value: c.id }))
}

const loadCategory = async () => {
  const response = await $fetch<{ data: CategoryData }>(
    `http://localhost:80/api/admin/blog/categories/${categoryId}`
  )
  const category = response.data

  state.title = category.title
  state.slug = category.slug ?? ''
  state.description = category.description ?? ''
  state.parent_id = category.parent_id ?? undefined
}

const onSubmit = async (event: FormSubmitEvent<Schema>) => {
  generalError.value = ''
  submitting.value = true

  try {
    await $fetch(`http://localhost:80/api/admin/blog/categories/${categoryId}`, {
      method: 'PUT',
      body: event.data
    })

    router.push('/admin/blog/categories')
  } catch (e) {
    generalError.value = getErrorMessage(e)
  } finally {
    submitting.value = false
  }
}

onMounted(async () => {
  loading.value = true
  await Promise.all([loadCategories(), loadCategory()])
  loading.value = false
})
</script>

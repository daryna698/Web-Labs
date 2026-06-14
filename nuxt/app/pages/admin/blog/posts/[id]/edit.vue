<template>
  <div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-sm border border-gray-200">
      <UButton
        to="/BlogPostsUi"
        icon="i-heroicons-arrow-left"
        variant="ghost"
        color="neutral"
        class="mb-4"
      >
        Назад до таблиці
      </UButton>

      <h1 class="text-2xl font-bold mb-6 text-gray-800">
        Редагування публікації
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
          label="Заголовок"
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
          label="Короткий опис"
          name="excerpt"
        >
          <UTextarea
            v-model="state.excerpt"
            class="w-full"
            :rows="2"
          />
        </UFormField>

        <UFormField
          label="Текст статті"
          name="content_raw"
          required
        >
          <UTextarea
            v-model="state.content_raw"
            class="w-full"
            :rows="8"
          />
        </UFormField>

        <UFormField
          label="Категорія"
          name="category_id"
          required
        >
          <USelect
            v-model="state.category_id"
            :items="categoryItems"
            placeholder="Оберіть категорію"
            class="w-full"
          />
        </UFormField>

        <UFormField
          label="Дата публікації"
          name="published_at"
        >
          <UInput
            v-model="state.published_at"
            type="datetime-local"
            class="w-full"
          />
        </UFormField>

        <UFormField name="is_published">
          <UCheckbox
            v-model="state.is_published"
            label="Опублікувати"
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
const postId = route.params.id

const schema = z.object({
  title: z.string().min(5, 'Мінімум 5 символів').max(200, 'Максимум 200 символів'),
  slug: z.string().max(200, 'Максимум 200 символів').optional(),
  excerpt: z.string().max(500, 'Максимум 500 символів').optional(),
  content_raw: z.string().min(5, 'Мінімум 5 символів').max(10000, 'Максимум 10000 символів'),
  category_id: z.number({ error: 'Оберіть категорію' }),
  is_published: z.boolean(),
  published_at: z.string().optional()
})

type Schema = z.output<typeof schema>

const state = reactive<Partial<Schema>>({
  title: '',
  slug: '',
  excerpt: '',
  content_raw: '',
  category_id: undefined,
  is_published: false,
  published_at: ''
})

interface CategoryComboItem {
  id: number
  id_title: string
}

interface PostData {
  id: number
  title: string
  slug: string | null
  excerpt: string | null
  content_raw: string | null
  category_id: number
  is_published: boolean
  published_at: string | null
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

const loadPost = async () => {
  const response = await $fetch<{ data: PostData }>(
    `http://localhost:80/api/admin/blog/posts/${postId}`
  )
  const post = response.data

  state.title = post.title
  state.slug = post.slug ?? ''
  state.excerpt = post.excerpt ?? ''
  state.content_raw = post.content_raw ?? ''
  state.category_id = post.category_id
  state.is_published = !!post.is_published
  state.published_at = post.published_at ?? ''
}

const onSubmit = async (event: FormSubmitEvent<Schema>) => {
  generalError.value = ''
  submitting.value = true

  try {
    await $fetch(`http://localhost:80/api/admin/blog/posts/${postId}`, {
      method: 'PUT',
      body: event.data
    })

    router.push('/BlogPostsUi')
  } catch (e) {
    generalError.value = getErrorMessage(e)
  } finally {
    submitting.value = false
  }
}

onMounted(async () => {
  loading.value = true
  await Promise.all([loadCategories(), loadPost()])
  loading.value = false
})
</script>

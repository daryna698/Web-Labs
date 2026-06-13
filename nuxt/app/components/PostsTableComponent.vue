<template>
  <div class="container">
    <div class="flex justify-center">
      <div class="w-full">
        <nav class="navbar bg-gray-100">
          <a href="/admin/blog/posts/create">Додати</a>
        </nav>
        <div class="card">
          <div class="card-body">
            <table class="table table-auto w-full border">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Автор</th>
                  <th>Категорія</th>
                  <th>Заголовок</th>
                  <th>Дата публікації</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="post in posts"
                  :key="post.id"
                >
                  <td>{{ post.id }}</td>
                  <td>{{ post.author_name }}</td>
                  <td>{{ post.category_title }}</td>
                  <td>
                    <a :href="'/admin/blog/posts/' + post.id + '/edit'">
                      {{ post.title }}
                    </a>
                  </td>
                  <td>{{ post.date_published }}</td>
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

interface Post {
  id: number
  author_name: string | null
  category_title: string | null
  title: string
  date_published: string | null
}

interface PostsResponse {
  data: Post[]
}

const posts = ref<Post[]>([])

const getPosts = () => {
  $fetch<PostsResponse>('http://localhost:80/api/blog/posts')
    .then((response) => {
      console.log(response)
      posts.value = response.data
    })
}

getPosts()
</script>

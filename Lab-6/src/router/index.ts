import { createRouter, createWebHistory } from 'vue-router'
import Onboarding from '../components/Onboarding.vue' // Або OnboardingView.vue, як ти назвала

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'onboarding',
      component: Onboarding
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../components/Login.vue')
    },
    // ДОДАЄМО ОСЬ ЦЕЙ БЛОК:
    {
      path: '/register',
      name: 'register',
      component: () => import('../components/Register.vue')
    }
  ]
})

export default router

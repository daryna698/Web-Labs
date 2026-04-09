<template>
  <div class="min-h-screen bg-white dark:bg-[#121212] pb-12 font-sans transition-colors duration-300">
    <div class="bg-[#333333] dark:bg-black text-white text-center py-4 text-lg font-bold mb-8">
      Checkout
    </div>

    <div class="max-w-[1000px] mx-auto px-4">
      <NuxtLink to="/" class="text-gray-500 dark:text-gray-400 text-sm hover:underline mb-6 inline-block">&lt;&lt; back</NuxtLink>

      <h1 class="text-[22px] font-bold text-gray-800 dark:text-white mb-2">You're Almost In - Start Your 3-Day Free Trial Now!</h1>
      <p class="text-gray-600 dark:text-gray-400 mb-8 text-[15px]">Set up your account to gain instant access! You won't be charged if you decide to cancel within 3 days</p>

      <div class="flex flex-col md:flex-row gap-8 items-start" v-if="selectedPlan">

        <PricingCard :plan="selectedPlan" :is-annual="isAnnual" />

        <div class="flex-1 bg-white dark:bg-[#1e1e1e] p-8 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 w-full transition-colors duration-300">

          <h3 class="text-[17px] font-bold text-gray-800 dark:text-white mb-4 border-b dark:border-gray-700 pb-2">Order Summary</h3>
          <div class="space-y-2.5 text-sm text-gray-600 dark:text-gray-300 mb-4 px-1">
            <div class="flex justify-between">
              <span>{{ planTitle }} - {{ planType }} Plan</span>
              <span>{{ planPrice }}</span>
            </div>
            <div class="flex justify-between text-gray-800 dark:text-white">
              <span class="font-bold">Total Due <span class="text-[10px] font-normal text-gray-400 ml-1">(*not including sales tax)</span></span>
              <span class="font-bold">{{ planPrice }}</span>
            </div>
            <div class="flex justify-between font-bold text-gray-800 dark:text-white pt-1">
              <span>Due Today</span>
              <span>$0.00</span>
            </div>
          </div>
          <div class="bg-gray-100 dark:bg-gray-800 text-center py-3 rounded text-[13px] text-gray-500 dark:text-gray-400 font-medium mb-8">
            Includes 3-Day Free Trial
          </div>

          <h3 class="text-[17px] font-bold text-gray-800 dark:text-white mb-4 border-b dark:border-gray-700 pb-2">Billing Information</h3>

          <form @submit.prevent="submitForm">
            <div class="mb-5">
              <label class="block text-[13px] text-gray-600 dark:text-gray-400 mb-1">Card Details</label>
              <div class="flex border border-gray-300 dark:border-gray-600 rounded-md overflow-hidden bg-white dark:bg-[#2a2a2a]">
                <input type="text" v-model="form.cardNumber" placeholder="Number" class="w-full p-2.5 text-sm bg-transparent outline-none dark:text-white" required />
                <input type="text" v-model="form.expiry" placeholder="MM / YY" class="w-24 p-2.5 text-sm border-l border-gray-300 dark:border-gray-600 bg-transparent outline-none dark:text-white" required />
                <input type="text" v-model="form.cvc" placeholder="CVC" class="w-20 p-2.5 text-sm border-l border-gray-300 dark:border-gray-600 bg-transparent outline-none dark:text-white" required />
              </div>
            </div>

            <div class="mb-6">
              <label class="block text-[13px] text-gray-600 dark:text-gray-400 mb-1">Address</label>
              <div class="border border-gray-300 dark:border-gray-600 rounded-md p-4 bg-gray-50/50 dark:bg-[#2a2a2a]">
                <input type="text" v-model="form.fullName" placeholder="Full name" class="w-full p-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded mb-3 bg-white dark:bg-[#1e1e1e] outline-none dark:text-white" required />
                <input type="text" v-model="form.address" placeholder="Address" class="w-full p-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-[#1e1e1e] outline-none dark:text-white" required />
              </div>
            </div>

            <div class="flex items-start gap-2.5 mb-6 px-1">
              <input type="checkbox" v-model="form.consent" id="consent" class="mt-1 cursor-pointer" required />
              <label for="consent" class="text-[11px] text-gray-600 dark:text-gray-400 cursor-pointer text-justify">
                I consent to Terms of Use and understand my 3-day free trial will automatically convert...
              </label>
            </div>

            <button
              type="submit"
              class="font-bold py-2.5 px-6 rounded-md transition-all duration-200 text-sm w-full md:w-auto"
              :class="form.consent ? 'bg-[#f8981d] text-white hover:bg-[#e0891a]' : 'bg-gray-200 dark:bg-gray-700 text-gray-400 cursor-not-allowed'"
              :disabled="!form.consent"
            >
              Try It Free
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const route = useRoute()
const { data: planData } = await useFetch('/api/plans')

const planTitle = computed(() => route.query.plan || 'Team')
const planType = computed(() => route.query.type || 'Annual')
const planPrice = computed(() => route.query.price || '$2,490')
const isAnnual = computed(() => planType.value === 'Annual')

const selectedPlan = computed(() => {
  if (!planData.value) return null
  return planData.value.find(p => p.title === planTitle.value) || planData.value[1]
})

const form = ref({
  cardNumber: '', expiry: '', cvc: '', fullName: 'dev4 dev4', address: '', consent: false
})

const submitForm = async () => {
  try {
    const response = await $fetch('/api/subscription/create', { method: 'POST', body: form.value })
    alert(response.message)
  } catch (error) {
    alert('Помилка: ' + error.message)
  }
}
</script>

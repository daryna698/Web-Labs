<template>
  <div class="max-w-[1080px] mx-auto py-12 px-4">

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
      <h2 class="text-[28px] font-bold text-gray-900 dark:text-white">
        Start Your 3 Day Free Trial
      </h2>

      <div class="flex items-center gap-4">
        <span class="text-[#3bdf49] text-[13px] font-bold">Save up to 20%</span>

        <div class="bg-gray-50 border border-gray-200 dark:bg-gray-800 dark:border-gray-700 p-1 rounded-lg flex items-center">
          <button
            @click="isAnnual = true"
            :class="isAnnual ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200'"
            class="px-5 py-1.5 rounded text-[14px] font-bold transition-all"
          >
            Annual
          </button>
          <button
            @click="isAnnual = false"
            :class="!isAnnual ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200'"
            class="px-5 py-1.5 rounded text-[14px] font-bold transition-all"
          >
            Monthly
          </button>
        </div>
      </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 justify-center items-stretch w-full">
      <PricingCard
        v-for="plan in plans"
        :key="plan.title"
        :plan="plan"
        :is-annual="isAnnual"
      />
    </div>

  </div>
</template>

<script setup>
import { ref } from 'vue'

const isAnnual = ref(true)

const { data: plans } = await useFetch('/api/plans')
</script>

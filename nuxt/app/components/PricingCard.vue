<template>
  <div class="w-full md:w-[320px] bg-white dark:bg-[#1e1e1e] rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors duration-300 relative">

    <div class="h-1.5 w-full bg-gradient-to-r from-[#3bdf49] to-[#0bc5ea] absolute top-0 left-0"></div>

    <div class="p-6 mt-2">
      <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
        {{ plan.title }} - {{ isAnnual ? 'Annual' : 'Monthly' }}
      </h2>
      <span class="bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300 text-xs font-bold px-2 py-1 rounded inline-block mb-3">3-days free then:</span>

      <div class="flex items-baseline mb-1">
        <span class="text-4xl font-extrabold text-gray-900 dark:text-white">
          {{ isAnnual ? plan.price : plan.priceMonthly }}
        </span>
        <span class="text-gray-400 font-medium ml-1 text-sm">/month</span>
      </div>

      <div class="h-[20px] mb-2">
        <p v-if="isAnnual" class="text-xs text-gray-400">
          billed yearly at <del class="mr-1">{{ plan.originalYearly }}</del>
          <strong class="text-gray-600 dark:text-gray-300">{{ plan.billedYearly }}</strong>
        </p>
        <p v-else class="text-xs text-gray-400">billed monthly</p>
      </div>

      <div class="h-[28px] mb-6">
        <span v-if="isAnnual" class="bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs font-bold px-2 py-1 rounded inline-block">
          {{ plan.savings }}
        </span>
      </div>

      <NuxtLink
        :to="{ path: '/checkout', query: { plan: plan.title, price: isAnnual ? plan.billedYearly : plan.priceMonthly, type: isAnnual ? 'Annual' : 'Monthly' } }"
        class="block w-full text-center bg-[#f8981d] hover:bg-[#e0891a] text-white font-bold py-2.5 px-4 rounded-md transition-colors mb-6"
      >
        Try It Free
      </NuxtLink>

      <ul class="space-y-3">
        <li v-for="(feature, idx) in plan.features" :key="idx" class="flex items-start">
          <span class="text-[#3bdf49] text-lg mr-2 leading-none">✦</span>
          <div>
            <p class="text-[13px] text-gray-700 dark:text-gray-200 leading-tight">
              <span v-if="feature.highlight" class="font-bold">{{ feature.highlight }} </span>
              <span>{{ feature.main }}</span>
            </p>
            <p v-if="feature.sub" class="text-[11px] text-gray-400 mt-0.5">{{ feature.sub }}</p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
defineProps({
  plan: {
    type: Object,
    required: true
  },
  isAnnual: {
    type: Boolean,
    default: true
  }
})
</script>

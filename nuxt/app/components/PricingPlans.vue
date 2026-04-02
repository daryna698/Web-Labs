<template>
  <div class="mb-10 max-w-[1200px] w-full mx-auto font-sans p-6">

    <div class="flex flex-col md:flex-row justify-between items-end mb-8">
      <h1 class="text-[28px] font-bold text-gray-800 tracking-tight">
        Start Your 3 Day Free Trial
      </h1>
      <div class="flex items-center gap-3 mt-4 md:mt-0">
        <div class="relative text-[#3bdf49] text-xs font-bold flex items-center pr-2">
          <span>Save up to 20%</span>
          <iconify-icon icon="mdi:arrow-top-right-bold-outline" class="absolute -top-3 -right-1 text-lg rotate-45"></iconify-icon>
        </div>
        <div class="bg-gray-50 border border-gray-200 p-1 rounded-lg flex text-sm font-bold">
          <button class="bg-white shadow-sm px-4 py-1.5 rounded-md text-gray-800">Annual</button>
          <button class="px-4 py-1.5 text-gray-400 hover:text-gray-600 transition-colors">Monthly</button>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" v-if="plans">

      <div
        v-for="(plan, index) in plans"
        :key="index"
        class="bg-white rounded-xl shadow-sm hover:shadow-xl border border-gray-100 transition-shadow duration-300 w-full overflow-hidden flex flex-col"
      >
        <div class="h-1.5 w-full bg-gradient-to-r from-green-400 to-cyan-400"></div>

        <div class="p-8 flex-1 flex flex-col">
          <h2 class="text-xl font-bold text-gray-800 mb-4">{{ plan.title }}</h2>

          <div>
            <span class="bg-gray-100 text-gray-500 text-[11px] font-bold px-2 py-1 rounded inline-block mb-4">
              3-days free then:
            </span>
          </div>

          <div class="flex items-baseline mt-1">
            <span class="text-[40px] font-extrabold text-gray-900 tracking-tight">{{ plan.price }}</span>
            <span class="text-gray-400 font-medium ml-1 text-sm">/month</span>
          </div>

          <p class="text-[13px] text-gray-400 mt-1 mb-2">
            billed yearly at <del class="mr-1">{{ plan.originalYearly }}</del>
            <span class="font-bold text-gray-600">{{ plan.billedYearly }}</span>
          </p>

          <div>
            <span class="bg-green-100 text-green-600 text-[12px] font-bold px-2 py-1 rounded inline-block mb-6">
              {{ plan.savings }}
            </span>
          </div>

          <button class="w-full bg-[#f8981d] hover:bg-[#e0891a] text-white font-bold py-2.5 px-4 rounded-md transition-all duration-150">
            Try It Free
          </button>

          <hr class="my-6 border-gray-100">

          <ul class="space-y-4 flex-1">
            <li v-for="(feature, idx) in plan.features" :key="idx" class="flex items-start">
              <iconify-icon icon="mdi:star-four-points" class="text-[#3bdf49] text-xl mt-0.5 mr-3 shrink-0"></iconify-icon>
              <div>
                <p class="text-[14px] text-gray-700 leading-tight" :class="feature.highlight ? '' : 'font-semibold'">
                  <span v-if="feature.highlight" class="font-bold">{{ feature.highlight }} </span>
                  <span :class="feature.highlight ? 'font-normal' : ''">{{ feature.main }}</span>
                </p>
                <p v-if="feature.sub" class="text-[12px] text-gray-400 mt-1">{{ feature.sub }}</p>
              </div>
            </li>
          </ul>

        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
const { data: plans } = await useFetch('/api/plans')
// Функцію getGradientClass видалено, оскільки вона більше не потрібна
</script>

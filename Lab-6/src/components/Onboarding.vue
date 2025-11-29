<script setup>
import { ref } from 'vue'

import img1 from '@/assets/slide1.png'
import img2 from '@/assets/slide2.png'
import img3 from '@/assets/slide3.png'

const slides = [
  {
    title: "MEET NEW PEOPLE",
    desc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lacinia tellus quis est pharetra fermentum. Curabitur dapibus, neque id lacus.hendrerit rhoncus.Vivamus quis,pretium metus.",
    image: img1
  },
  {
    title: "CHAT WITH EASE",
    desc: "Vivamus porta tortor sit amet quam eleifend hendrerit. Praesent molestie lobortis sodales. Sed.volutpat. tempus.orci.",
    image: img2
  },
  {
    title: "FIND YOUR MATCH",
    desc: "Praesent varius tortor sit amet quam eleifend hendrerit. Suspendisse potenti. Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
    image: img3
  }
]

const currentStep = ref(0)

const nextStep = () => {
  if (currentStep.value < slides.length - 1) {
    currentStep.value++
  } else {
    alert("Вітаємо! Ви пройшли навчання.")
    // Тут можна додати логіку переходу на іншу сторінку, наприклад:
  }
}

const skip = () => {
  alert("Пропущено. Перехід на іншу сторінку.")
}
</script>

<template>
  <div class="flex flex-col h-screen bg-[#FFFFFF] font-sans text-gray-800 overflow-hidden">

    <div class="flex-1 flex items-center justify-center p-4 pt-10">
      <img
        :src="slides[currentStep].image"
        alt="Illustration"
        class="w-full max-w-[360px] object-contain transition-all duration-500"
      />
    </div>

    <div class="px-8 pb-12 text-center relative">

      <h2 class="mb-6 inline-block">
        <span class="bg-[#FF6B6B] text-white text-xl font-bold px-12 py-4 rounded-lg shadow-md uppercase tracking-wider leading-none">
            {{ slides[currentStep].title }}
        </span>
      </h2>

      <p class="text-sm text-gray-500 leading-relaxed mb-16 px-6 h-20 flex items-center justify-center">
        {{ slides[currentStep].desc }}
      </p>

      <div class="flex items-center justify-between relative h-12">

        <button @click="skip" class="text-sm font-bold text-gray-400 hover:text-gray-600 uppercase tracking-wider transition-colors absolute left-0">
          SKIP
        </button>

        <div class="flex space-x-3 mx-auto">
          <span
            v-for="(slide, index) in slides"
            :key="index"
            class="transition-all duration-300"
            :class="[
              index === currentStep ? 'w-2 h-2 bg-[#FF6B6B]' : 'w-2 h-2 bg-gray-300',
              'block' // щоб були квадрати
            ]"
          ></span>
        </div>

        <button
          @click="nextStep"
          class="bg-[#FF6B6B] text-white text-sm font-bold px-8 py-3 rounded-lg shadow-md hover:bg-[#ff5252] active:scale-95 transition-all uppercase tracking-wider absolute right-0"
        >
          NEXT
        </button>

      </div>
    </div>
  </div>
</template>

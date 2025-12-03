<script setup lang="ts">
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';

// ВАЖЛИВО: Перевірте, чи ваші файли в папці assets називаються САМЕ ТАК (з великої літери)
import img1 from '@/assets/slide1.png';
import img2 from '@/assets/slide2.png';
import img3 from '@/assets/slide3.png';

const router = useRouter();

interface Slide { id: number; image: string; title: string; desc: string; }

const slides: Slide[] = [
  { id: 1, image: img1, title: 'MEET NEW PEOPLE', desc: 'Meet new people and open the door to new adventures!' },
  { id: 2, image: img2, title: 'CHAT WITH EASE', desc: 'Chat with ease and enjoy every moment of communication!' },
  { id: 3, image: img3, title: 'FIND YOUR LOVE', desc: 'Find your love and start a new chapter in your life!' },
];

const step = ref(0);
const current = computed(() => slides[step.value]);
const isLast = computed(() => step.value === slides.length - 1);

const next = () => {
  if (!isLast.value) {
    step.value++;
  } else {
    router.push('/login');
  }
};
</script>

<template>
  <div class="min-h-screen bg-fated-pink font-sans text-gray-800 flex flex-col justify-between p-6 overflow-hidden">

    <main class="flex-grow flex flex-col items-center text-center justify-center pb-10">
      <div class="mb-10 w-full flex justify-center h-64 items-end transition-transform duration-500 hover:scale-105">
        <img :src="current.image" class="w-full max-w-[280px] h-auto object-contain drop-shadow-xl rounded-2xl">
      </div>
      <div class="bg-fated-red text-white font-bold text-sm py-3 px-8 rounded-full shadow-soft tracking-widest mb-6 uppercase">
        {{ current.title }}
      </div>
      <p class="text-gray-500 text-sm leading-relaxed max-w-md mx-auto px-4">
        {{ current.desc }}
      </p>
    </main>

    <footer class="flex items-center justify-between w-full mb-4">
      <button v-if="!isLast" @click="step = 2" class="font-bold text-gray-400 text-sm tracking-wider py-2 px-4 hover:text-fated-red">SKIP</button>
      <div v-else class="w-16"></div>

      <div class="flex space-x-2">
        <div v-for="(s, i) in slides" :key="s.id" class="w-2.5 h-2.5 rounded-full transition-all duration-300"
             :class="i === step ? 'bg-fated-red scale-125' : 'bg-gray-300'"></div>
      </div>

      <button @click="next" class="bg-fated-red text-white font-bold text-sm py-3 px-6 rounded-full shadow-soft tracking-wider min-w-[100px]">
        {{ isLast ? 'START' : 'NEXT' }}
      </button>
    </footer>
  </div>
</template>

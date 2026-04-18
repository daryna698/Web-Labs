import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useSubscriptionStore = defineStore('subscription', () => {
  const planName = ref('Team')
  const planType = ref('Annual')
  const planPrice = ref('$2,490')

  function setSubscription(name: string, type: string, price: string) {
    planName.value = name
    planType.value = type
    planPrice.value = price
  }

  return {
    planName,
    planType,
    planPrice,
    setSubscription
  }
})

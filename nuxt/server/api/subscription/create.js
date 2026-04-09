export default defineEventHandler(async (event) => {
  const body = await readBody(event)

  console.log('Отримані дані підписки:', body)

  return {
    success: true,
    message: 'Дані успішно відправлено на ендпоінт /api/subscription/create!',
    data: body
  }
})

export default defineEventHandler(async (event) => {
  const body = await readBody(event)
  return { success: true, message: 'Дані успішно відправлені!', data: body }
})

export default async function run(page, ui) {
  await page.locator('#login-email').fill('referrer1@example.com')
  await page.locator('#login-email').press('Tab')
  await page.keyboard.type('password')
  await page.locator('button:has-text("Sign in")').last().click()
  await page.waitForTimeout(3000)

  await page.goto('http://localhost:8000/affiliate/earners')
  await page.waitForTimeout(3000)

  const snapshot = await ui.snapshot({ full: true })
  return snapshot
}

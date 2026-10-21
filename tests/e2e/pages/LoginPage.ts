import { Page, Locator } from '@playwright/test';

export class LoginPage {
  readonly page: Page;
  readonly usernameInput: Locator;
  readonly passwordInput: Locator;
  readonly submitButton: Locator;

  constructor(page: Page) {
    this.page = page;
    this.usernameInput = page.locator('#login');
    this.passwordInput = page.locator('#password');
    this.submitButton = page.getByRole('button', { name: /Đăng nhập hệ thống/i });
  }

  async goto() {
    await this.page.goto('/dang-nhap');
    await this.page.waitForLoadState('domcontentloaded');
  }

  async login(username = 'admin', password = '1') {
    await this.goto();
    await this.usernameInput.fill(username);
    await this.passwordInput.fill(password);
    await this.submitButton.click();
    await this.page.waitForLoadState('networkidle');
  }
}

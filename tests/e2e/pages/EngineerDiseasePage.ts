import { Page, Locator, expect } from '@playwright/test';

export class EngineerDiseasePage {
  readonly page: Page;
  readonly brandTitle: Locator;
  readonly navPhoiTron: Locator;
  readonly navHoatChat: Locator;
  readonly navBenhHai: Locator;
  readonly searchInput: Locator;
  readonly clearSearchBtn: Locator;
  readonly countDisplay: Locator;
  readonly diseaseCards: Locator;
  readonly filterButtons: Locator;

  constructor(page: Page) {
    this.page = page;
    this.brandTitle = page.locator('header').getByText('PHÂN HỆ KỸ SƯ BVTV');
    this.navPhoiTron = page.locator('nav a', { hasText: 'Kỵ Phối Trộn' });
    this.navHoatChat = page.locator('nav a', { hasText: 'Tra Cứu Hoạt Chất' });
    this.navBenhHai = page.locator('nav a', { hasText: 'Bệnh Hại & Phác Đồ' });
    this.searchInput = page.locator('#inputSearchDisease');
    this.clearSearchBtn = page.locator('#btnClearSearch');
    this.countDisplay = page.locator('#countDisplay');
    this.diseaseCards = page.locator('.disease-card:not(.hidden)');
    this.filterButtons = page.locator('#selectDichHaiFilter');
  }

  async goto(crop = 'all') {
    await this.page.goto(`/ky-su/benh-hai?crop=${crop}`);
    await this.page.waitForLoadState('domcontentloaded');
  }

  async search(query: string) {
    await this.searchInput.fill(query);
    await this.page.waitForTimeout(300); // Debounce / dynamic DOM filtering
  }

  async clearSearch() {
    await this.clearSearchBtn.click();
    await this.page.waitForTimeout(300);
  }

  async selectFilter(filterKey: string) {
    await this.page.locator('#selectDichHaiFilter').selectOption(filterKey);
    await this.page.waitForTimeout(300);
  }

  async clickFilter(filterKey: string) {
    await this.selectFilter(filterKey);
  }

  async getVisibleCardsCount(): Promise<number> {
    return await this.diseaseCards.count();
  }

  async getDisplayedCounterText(): Promise<string> {
    return (await this.countDisplay.textContent())?.trim() || '';
  }
}

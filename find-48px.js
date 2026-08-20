const puppeteer = require('puppeteer');

const URL = 'http://localhost/andre-wp/trajetoria/';

(async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();
  await page.setViewport({ width: 1440, height: 900 });
  await page.goto(URL, { waitUntil: 'networkidle0' });

  await page.evaluate(async () => {
    await new Promise(resolve => {
      let total = 0;
      const step = 300;
      const timer = setInterval(() => {
        window.scrollBy(0, step);
        total += step;
        if (total >= document.body.scrollHeight) {
          clearInterval(timer);
          resolve();
        }
      }, 60);
    });
  });
  await new Promise(r => setTimeout(r, 800));

  const result = await page.evaluate(() => {
    const vw = document.documentElement.clientWidth;

    function seletor(el) {
      const classes = el.className && typeof el.className === 'string'
        ? '.' + el.className.trim().split(/\s+/).join('.')
        : '';
      const idPart = el.id ? '#' + el.id : '';
      return el.tagName.toLowerCase() + idPart + classes;
    }

    const offenders = [];
    document.querySelectorAll('*').forEach(el => {
      const rect = el.getBoundingClientRect();
      const overflow = rect.right - vw;
      if (overflow > 0.5) {
        const cs = getComputedStyle(el);
        offenders.push({
          seletor: seletor(el),
          'overflow(px)': Math.round(overflow * 10) / 10,
          'right(px)': Math.round(rect.right),
          'width(px)': Math.round(rect.width),
          'position': cs.position,
          'display': cs.display,
        });
      }
    });

    offenders.sort((a, b) => b['overflow(px)'] - a['overflow(px)']);
    return offenders;
  });

  console.log(`Total de elementos ultrapassando a tela (após scroll): ${result.length}`);
  console.table(result.slice(0, 30));

  await page.screenshot({ path: 'apos-scroll.png', fullPage: true });
  console.log('\nScreenshot salvo em apos-scroll.png para conferência visual.');

  await browser.close();
})();
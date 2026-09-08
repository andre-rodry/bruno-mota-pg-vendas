<section class="hero-launch">
  <div class="hero-launch__scale" style="--hero-bg: url('<?php echo get_template_directory_uri(); ?>/assets/img/banner-bruno-mota-welinton-santos.webp');">
    <div class="container">

      <div class="hero-launch__block hero-launch__block--content">

        <div class="hero-launch__rule-row">
          <span class="hero-launch__rule"></span>
          <span class="hero-launch__eyebrow">Lançamento</span>
          <span class="hero-launch__rule"></span>
        </div>

        <h1 class="hero-launch__title">
          Inteligência<br>Artificial
          <span class="hero-launch__rule-row hero-launch__rule-row--sub">
            <span class="hero-launch__rule"></span>
            <span class="hero-launch__title-sub">para</span>
            <span class="hero-launch__rule"></span>
          </span>
          Economistas<br>e Contadores
        </h1>

        <p class="hero-launch__tag">
          <svg class="hero-launch__tag-arrow" width="26" height="10" viewBox="0 0 26 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 5H10" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
            <path d="M10 1.5L14 5L10 8.5" stroke="currentColor" stroke-width="1.3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M14 1.5L18 5L14 8.5" stroke="currentColor" stroke-width="1.3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          A mágica dos prompts
          <svg class="hero-launch__tag-arrow" width="26" height="10" viewBox="0 0 26 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M26 5H16" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
            <path d="M16 1.5L12 5L16 8.5" stroke="currentColor" stroke-width="1.3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 1.5L8 5L12 8.5" stroke="currentColor" stroke-width="1.3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </p>

        <p class="hero-launch__desc">
          Um guia prático e acessível para dominar a IA
          e transformar sua rotina profissional.
        </p>

        <div class="hero-launch__actions">
          <a href="https://clubedeautores.com.br/livro/inteligencia-artificial-para-economistas-e-contadores" target="_blank" rel="noopener" class="hero-launch__cta">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M2 3H4L4.8 6M4.8 6H20.5L18.5 14H7.2M4.8 6L7.2 14M7.2 14L6.3 16.5C6.1 17.2 6.6 18 7.4 18H18"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
              <circle cx="9" cy="20.5" r="1.4" fill="currentColor"/>
              <circle cx="17" cy="20.5" r="1.4" fill="currentColor"/>
            </svg>
            Comprar o livro
          </a>

          <span class="hero-launch__divider-v" aria-hidden="true"></span>

          <div class="hero-launch__amazon">
            <span>Disponível na</span>
            <strong>
              amazon
              <svg width="52" height="14" viewBox="0 0 52 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 3C14 11 38 11 49 3" stroke="#FF9900" stroke-width="2" stroke-linecap="round" fill="none"/>
                <path d="M43 2.5L50 2L48.5 8.5" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
              </svg>
            </strong>
          </div>
        </div>

      </div>

      <div class="hero-launch__book">
        <img
          src="<?php echo get_template_directory_uri(); ?>/assets/img/livro-inteligencia-artificial-para-economistas-contadores.webp"
          alt="Capa do livro Inteligência Artificial para Economistas e Contadores"
        >
      </div>

      <div class="hero-launch__spacer" aria-hidden="true"></div>

      <div class="hero-launch__authors">

        <div class="hero-launch__author">
          <div class="hero-launch__author-photo-wrap">
            <img
              class="hero-launch__author-photo"
              src="<?php echo get_template_directory_uri(); ?>/assets/img/bruno-mota-lopes.webp"
              alt="Bruno Mota Lopes"
            >
          </div>
          <div class="hero-launch__author-info">
            <span class="hero-launch__author-name">Bruno Mota Lopes</span>
            <span class="hero-launch__author-role">Economista, Educador Financeiro e Pesquisador</span>
          </div>
        </div>

        <div class="hero-launch__author">
          <div class="hero-launch__author-photo-wrap">
            <img
              class="hero-launch__author-photo"
              src="<?php echo get_template_directory_uri(); ?>/assets/img/welinton-dos-santos.webp"
              alt="Welinton dos Santos"
            >
          </div>
          <div class="hero-launch__author-info">
            <span class="hero-launch__author-name">Welinton dos Santos</span>
            <span class="hero-launch__author-role">Economista e Especialista em Gestão e Finanças</span>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

<script>
(function () {
  var DESIGN_WIDTH = 1697;
  var FREEZE_MAX = 1625;
  var FREEZE_MIN = 1123;
  var TRANSITION_MIN = 400;
  var EASE_POWER = 0.2;

  var BOOST_BREAK = 783;
  var BOOST_MAX = 0.18;

  var FREEZE_SCALE = FREEZE_MAX / DESIGN_WIDTH;
  var FROZEN_AT_BOUNDARY = FREEZE_SCALE / (FREEZE_MIN / DESIGN_WIDTH);

  var hero = document.querySelector('.hero-launch');
  if (!hero) return;

  function updateScale() {
    var width = hero.offsetWidth;
    var ratio = width / DESIGN_WIDTH;

    hero.style.setProperty('--hero-scale', ratio);

    var contentScale;

    if (width >= FREEZE_MAX) {
      contentScale = 1;
    } else if (width >= FREEZE_MIN) {
      contentScale = FREEZE_SCALE / ratio;
    } else if (width >= TRANSITION_MIN) {
      var t = (width - TRANSITION_MIN) / (FREEZE_MIN - TRANSITION_MIN);
      var tEased = Math.pow(t, EASE_POWER);
      contentScale = 1 + tEased * (FROZEN_AT_BOUNDARY - 1);

      if (width < BOOST_BREAK) {
        var localT = (BOOST_BREAK - width) / (BOOST_BREAK - TRANSITION_MIN);
        var boost = BOOST_MAX * Math.sin(Math.PI * localT);
        contentScale = contentScale * (1 + boost);
      }
    } else {
      contentScale = 1;
    }

    hero.style.setProperty('--content-scale', contentScale);
  }

  if (window.ResizeObserver) {
    new ResizeObserver(updateScale).observe(hero);
  } else {
    window.addEventListener('resize', updateScale);
  }

  updateScale();
})();
</script>
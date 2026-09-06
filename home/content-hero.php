<?php
/**
 * Template part: Hero de lançamento - Home
 * Layout: Banner de fundo (aspect-ratio) + texto sobreposto
 * Sistema de escala única: fundo + texto escalam juntos
 * (como se fossem uma imagem estática), via transform: scale().
 * Exceção: entre 1123px e 1625px, o texto trava no tamanho de 1625px.
 * Entre 400px e 1123px, transição suave e não-linear de volta ao normal
 * (fica maior por mais tempo, cai mais rápido só perto do fim).
 * Reforço extra: abaixo de 783px, aplicamos um boost adicional de escala
 * (as letras estavam ficando pequenas demais nessa faixa), com transição
 * suave que não quebra nem em 783px nem em 400px.
 * Abaixo de 400px, tudo escala junto normalmente.
 *
 * Responsivo mobile (via CSS, sem alterar a lógica JS acima):
 * - Acima de 871px: nada muda, continua o sistema de escala com o banner de fundo.
 * - Em 870px e abaixo: o fundo some, o transform: scale() do texto é travado
 *   em none (!important, para não conflitar com o JS de escala do desktop).
 *   O texto (centralizado internamente) fica lado a lado com a capa do
 *   livro, e os autores aparecem em linha própria logo abaixo dos dois.
 *   Se não houver espaço suficiente, o texto e a capa quebram linha
 *   automaticamente (flex-wrap) antes de virar coluna abaixo de 480px.
 * - Em 480px e abaixo: tudo centralizado, capa do livro desce para depois
 *   do botão/Amazon.
 * - Em 477px e abaixo: autores viram lista (avatar circular + texto ao lado).
 */
?>
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
          <a href="#comprar" class="hero-launch__cta">
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

      <!-- Capa do livro: visível apenas em telas de 870px e abaixo -->
      <div class="hero-launch__book">
        <img
          src="<?php echo get_template_directory_uri(); ?>/assets/img/livro-inteligencia-artificial-para-economistas-contadores.webp"
          alt="Capa do livro Inteligência Artificial para Economistas e Contadores"
        >
      </div>

      <div class="hero-launch__spacer" aria-hidden="true"></div>

      <!-- Autores: visível apenas em telas de 870px e abaixo -->
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
  var DESIGN_WIDTH = 1697;    // largura nativa do banner (mesmo valor do CSS)
  var FREEZE_MAX = 1625;      // acima disso: escala normal, sem travar
  var FREEZE_MIN = 1123;      // entre FREEZE_MIN e FREEZE_MAX: texto travado no tamanho de 1625px
  var TRANSITION_MIN = 400;   // entre TRANSITION_MIN e FREEZE_MIN: transição suave; abaixo: normal de novo
  var EASE_POWER = 0.2;       // <1 = fica grande por mais tempo e cai mais rápido só perto do fim

  var BOOST_BREAK = 783;      // abaixo deste ponto, aplicamos um reforço extra (letras ficavam pequenas)
  var BOOST_MAX = 0.18;       // força do reforço extra no pico (18%). Ajuste este valor se precisar de mais ou menos.

  var FREEZE_SCALE = FREEZE_MAX / DESIGN_WIDTH;
  // valor de contentScale exatamente no limite inferior da faixa travada (em FREEZE_MIN)
  var FROZEN_AT_BOUNDARY = FREEZE_SCALE / (FREEZE_MIN / DESIGN_WIDTH);

  var hero = document.querySelector('.hero-launch');
  if (!hero) return;

  function updateScale() {
    var width = hero.offsetWidth;
    var ratio = width / DESIGN_WIDTH;

    // fundo, imagem, espaçador etc: sempre escalam normalmente
    hero.style.setProperty('--hero-scale', ratio);

    var contentScale;

    if (width >= FREEZE_MAX) {
      // acima de 1625px: tudo normal
      contentScale = 1;
    } else if (width >= FREEZE_MIN) {
      // entre 1123px e 1625px: texto travado no tamanho de 1625px
      contentScale = FREEZE_SCALE / ratio;
    } else if (width >= TRANSITION_MIN) {
      // entre 400px e 1123px: transição suave e não-linear —
      // fica maior por mais tempo, cai mais rápido só perto do fim
      var t = (width - TRANSITION_MIN) / (FREEZE_MIN - TRANSITION_MIN); // 0 a 1
      var tEased = Math.pow(t, EASE_POWER);
      contentScale = 1 + tEased * (FROZEN_AT_BOUNDARY - 1);

      // reforço extra abaixo de 783px: uma "corcova" suave que começa em 0
      // exatamente em BOOST_BREAK (sem quebrar a curva ali) e volta a 0
      // exatamente em TRANSITION_MIN (sem quebrar o "normal" abaixo de 400px),
      // com o pico do reforço no meio do caminho entre os dois.
      if (width < BOOST_BREAK) {
        var localT = (BOOST_BREAK - width) / (BOOST_BREAK - TRANSITION_MIN); // 0 em BOOST_BREAK, 1 em TRANSITION_MIN
        var boost = BOOST_MAX * Math.sin(Math.PI * localT); // 0 nas duas pontas, pico no meio
        contentScale = contentScale * (1 + boost);
      }
    } else {
      // abaixo de 400px: volta a escalar tudo junto normalmente
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
<?php
/**
 * content-cta-home.php
 * Bloco "Vamos transformar ideias em impacto real?" (CTA) exibido na página inicial.
 *
 * Uso: <?php get_template_part( 'template-parts/content', 'cta-home' ); ?>
 * CSS correspondente: page-cta-home.css
 */
?>

<section class="cta-home">
  <div class="cta-home__container">
    <div class="cta-home__box">

      <div class="cta-home__info">
        <span class="cta-home__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 15.5H7.5C8.05228 15.5 8.5 15.9477 8.5 16.5V18.6459C8.5 19.0873 9.03216 19.309 9.34564 18.9973L11.5442 16.8095C11.7317 16.6224 11.9857 16.5172 12.2506 16.5172H15C16.6569 16.5172 18 15.1741 18 13.5172V8.5C18 6.84315 16.6569 5.5 15 5.5H8C6.34315 5.5 5 6.84315 5 8.5V13.5C5 14.6046 5.89543 15.5 7 15.5Z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>

        <div class="cta-home__texto">
          <h2 class="cta-home__titulo">Vamos transformar ideias em impacto real?</h2>
          <p class="cta-home__subtitulo">Entre em contato para palestras, consultorias e parcerias.</p>
        </div>
      </div>

      <a href="#" class="cta-home__btn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M21 3L11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M21 3L14.5 21L11 13L3 9.5L21 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Fale comigo
      </a>

    </div>
  </div>
</section>
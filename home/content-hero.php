<?php
/**
 * Template part: Hero de lançamento - Home
 * Layout: 2 Blocos separados (Esquerda | Direita)
 *
 * Uso no front-page.php:
 * get_template_part( 'home/content-hero' );
 */
?>
<section class="hero-launch">
  <div class="container">
    
    <!-- BLOCO 1: CONTEÚDO (ESQUERDA) -->
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

    <!-- BLOCO 2: IMAGENS (DIREITA) -->
    <div class="hero-launch__block hero-launch__block--media">

      <!-- Livro -->
      <div class="hero-launch__book">
        <img 
          src="<?php echo get_template_directory_uri(); ?>/assets/img/livro-inteligencia-artificial-para-economistas-contadores.webp" 
          alt="Livro Inteligência Artificial para Economistas e Contadores"
          class="hero-launch__book-img"
        />
      </div>

      <!-- Autores em Linha -->
      <div class="hero-launch__authors">
        
        <div class="hero-launch__author">
          <img 
            src="<?php echo get_template_directory_uri(); ?>/assets/img/bruno-mota-lopes.webp" 
            alt="Bruno Mota Lopes"
            class="hero-launch__author-img"
          />
          <div class="hero-launch__author-info">
            <p class="hero-launch__author-name">Bruno Mota Lopes</p>
            <p class="hero-launch__author-role">Economista, Educador<br>Financeiro e Pesquisador</p>
          </div>
        </div>

        <div class="hero-launch__author">
          <img 
            src="<?php echo get_template_directory_uri(); ?>/assets/img/welinton-dos-santos.webp" 
            alt="Welinton dos Santos"
            class="hero-launch__author-img"
          />
          <div class="hero-launch__author-info">
            <p class="hero-launch__author-name">Welinton dos Santos</p>
            <p class="hero-launch__author-role">Economista e Especialista<br>em Gestão e Finanças</p>
          </div>
        </div>

      </div>

    </div>

  </div>
</section>
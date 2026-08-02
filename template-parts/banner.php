<?php
/**
 * Template part: Banner da home
 * Uso: get_template_part( 'template-parts/banner' );
 */
?>

<!-- Fallback para quem tem JavaScript desabilitado -->
<noscript>
  <style>
    .bml-home-banner .bml-gsap-init { opacity: 1 !important; transform: none !important; }
  </style>
</noscript>

<div class="bml-home-banner bml-midia">
  <div class="bml-hero-section" data-gsap="section" style="background-image: url('<?php echo esc_url( 'https://i.ibb.co/VpJ4Qkxc/banner-site.png' ); ?>');">
    <div class="bml-hero-group">
      <div class="bml-hero-overlay-content">
        <h1 class="bml-hero-title bml-gsap-init" data-gsap="title">
          Economia que <span class="bml-highlight">transforma</span><br>
          pessoas, instituições e o futuro.
        </h1>
        <p class="bml-hero-subtitle bml-gsap-init" data-gsap="subtitle">Conhecimento • Experiência • Resultados</p>
        <div class="bml-hero-buttons">
          <a href="#" class="bml-btn bml-btn-primary bml-gsap-init" data-gsap="btn">
            <svg class="bml-btn-icon" width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M1 0.5L9 5L1 9.5V0.5Z" fill="currentColor"/>
            </svg>
            ASSISTA À TRAJETÓRIA
          </a>
          <a href="#" class="bml-btn bml-btn-secondary bml-gsap-init" data-gsap="btn">CONHEÇA MINHA TRAJETÓRIA</a>
        </div>
      </div>
      <div class="bml-scroll-down bml-gsap-init" data-gsap="scroll">
        <span class="bml-scroll-text">ROLE PARA BAIXO</span>
        <span class="bml-scroll-line"></span>
      </div>
    </div>

    <!-- BARRA DE REDES SOCIAIS -->
    <div class="bml-social-bar" data-gsap="social-bar">
      <span class="bml-social-label bml-gsap-init">Redes sociais</span>
      <div class="bml-social-icons">
        <a href="#" target="_blank" rel="noopener" aria-label="Instagram" class="bml-gsap-init"><i class="fab fa-instagram"></i></a>
        <a href="#" target="_blank" rel="noopener" aria-label="WhatsApp" class="bml-gsap-init"><i class="fab fa-whatsapp"></i></a>
        <a href="#" target="_blank" rel="noopener" aria-label="Facebook" class="bml-gsap-init"><i class="fab fa-facebook-f"></i></a>
        <a href="#" target="_blank" rel="noopener" aria-label="YouTube" class="bml-gsap-init"><i class="fab fa-youtube"></i></a>
        <a href="#" target="_blank" rel="noopener" aria-label="Spotify" class="bml-gsap-init"><i class="fab fa-spotify"></i></a>
        <a href="#" target="_blank" rel="noopener" aria-label="LinkedIn" class="bml-gsap-init"><i class="fab fa-linkedin-in"></i></a>
        <a href="#" target="_blank" rel="noopener" aria-label="TikTok" class="bml-gsap-init"><i class="fab fa-tiktok"></i></a>
      </div>
    </div>
  </div>
</div>
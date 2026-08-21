<?php
/**
 * home/content-banner-home.php
 * Banner principal (hero) da página inicial.
 */
?>

<div class="bml-home-banner bml-midia">
  <div class="bml-hero-section" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/img/home/bruno-mota-economista-banner-home.webp' ); ?>');">
    <div class="bml-hero-group">
      <div class="bml-hero-overlay-content">
        <h1 class="bml-hero-title">
          Economia que <span class="bml-highlight">transforma</span><br>
          pessoas, instituições e o futuro.
        </h1>
        <p class="bml-hero-subtitle">Conhecimento • Experiência • Resultados</p>
        <div class="bml-hero-buttons">
          <a href="<?php echo esc_url( home_url( '/trajetoria' ) ); ?>" class="bml-btn bml-btn-primary">
            CONHEÇA MINHA TRAJETÓRIA
          </a>
          <a href="#" class="bml-btn bml-btn-secondary">
            <svg class="bml-btn-icon" width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M1 0.5L9 5L1 9.5V0.5Z" fill="currentColor"/>
            </svg>
            ACESSE MEU CANAL NO YOUTUBE
          </a>
        </div>
      </div>
      <div class="bml-scroll-down">
        <span class="bml-scroll-text">ROLE PARA BAIXO</span>
        <span class="bml-scroll-line"></span>
      </div>
    </div>

    <!-- BARRA DE REDES SOCIAIS -->
    <div class="bml-social-bar">
      <span class="bml-social-label">Redes sociais</span>
      <div class="bml-social-icons">
        <a href="#" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
        <a href="#" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        <a href="#" target="_blank" rel="noopener" aria-label="Spotify"><i class="fab fa-spotify"></i></a>
        <a href="#" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        <a href="#" target="_blank" rel="noopener" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
      </div>
    </div>
  </div>
</div>
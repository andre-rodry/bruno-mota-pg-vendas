<?php
/**
 * Template Part: Timeline de Trajetoria (SOMENTE a seção pinada)
 * Uso: get_template_part( 'trajetoria/content-timeline-trajetoria' );
 *
 * Estilos:  page-timeline-trajetoria.css
 * Script:   page-timeline-trajetoria.js  (vanilla JS puro, sem GSAP/Lenis)
 *
 * Imagens: definidas aqui via PHP (get_template_directory_uri()) e passadas
 * ao JS/CSS através de data-attributes. Existem duas versões da foto:
 *  - Desktop: usada em telas > 1024px
 *  - Mobile/Tablet: usada em telas <= 1024px
 * Troque os nomes de arquivo abaixo quando tiver as fotos definitivas.
 */
$tlc_img_base    = get_template_directory_uri() . '/assets/img/trajetoria/';
$tlc_img_desktop = $tlc_img_base . 'educacao-financeira-salvador-proposta-bruno-mota-lopes-desktop.webp';
$tlc_img_mobile  = $tlc_img_base . 'educacao-financeira-salvador-bruno-mota-lopes-mobile-tablet.webp';
?>
<div class="tlc"
     data-img-desktop="<?php echo esc_url( $tlc_img_desktop ); ?>"
     data-img-mobile="<?php echo esc_url( $tlc_img_mobile ); ?>">

  <!-- STORY / PINNED VIA CSS STICKY -->
  <section class="story" id="tlcStory">
    <div class="story-stage" id="tlcStage">
      <div class="timeline">
        <div class="tl-head">
          <span class="eyebrow">Trajetória de Impacto</span>
          <p>Role para reviver os cinco marcos que definiram uma jornada.</p>
        </div>
        <div class="tl-track">
          <div class="tl-line"></div>
          <div class="tl-progress" id="tlcProgress"></div>
          <div class="tl-points" id="tlcPoints"></div>
        </div>
      </div>
      <div class="stage-body" id="tlcStageBody"></div>
    </div>
  </section>

</div>
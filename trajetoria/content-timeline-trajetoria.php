<?php
/**
 * Template Part: Timeline de Trajetoria (SOMENTE a seção pinada)
 * Uso: get_template_part( 'trajetoria/content-timeline-trajetoria' );
 *
 * Estilos:  page-timeline-trajetoria.css
 * Script:   page-timeline-trajetoria.js  (vanilla JS puro, sem GSAP/Lenis)
 */
?>
<div class="tlc">

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
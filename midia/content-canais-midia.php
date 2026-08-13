<?php
/**
 * content-canais-midia.php
 * Seção "Canais de Mídia" — Rádio / Podcasts / Imprensa
 * Requer: page-canais-midia.css
 */

// Caminho real: wp-content/themes/andreWP/assets/img/midia/
$img_base = get_template_directory_uri() . '/assets/img/midia/';
?>

<section class="canais-midia" id="canais-midia">
  <div class="canais-midia__inner">

    <div class="canais-midia__grid">

      <!-- ============ RÁDIO ============ -->
      <div class="canais-painel canais-painel--radio">
        <h3 class="canais-painel__titulo">Rádio</h3>

        <ul class="radio-lista">

          <li class="radio-item">
            <span class="radio-item__icone radio-item__icone--sinal radio-item__icone--bahiacast" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="2"></circle>
                <path d="M16.24 7.76a6 6 0 0 1 0 8.49m-8.48-.01a6 6 0 0 1 0-8.49m11.31-2.82a10 10 0 0 1 0 14.14m-14.14 0a10 10 0 0 1 0-14.14"></path>
              </svg>
            </span>
            <div class="radio-item__info">
              <p class="radio-item__nome">Rádio BahiaCast</p>
              <p class="radio-item__desc">Entrevista sobre economia</p>
              <p class="radio-item__data">12 de abril de 2025</p>
            </div>
            <a href="#" class="btn-ouvir">
              <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M6 4l14 8-14 8V4z"/></svg>
              Ouvir
            </a>
          </li>

          <li class="radio-item">
            <span class="radio-item__icone radio-item__icone--sinal radio-item__icone--metropole" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="2"></circle>
                <path d="M16.24 7.76a6 6 0 0 1 0 8.49m-8.48-.01a6 6 0 0 1 0-8.49m11.31-2.82a10 10 0 0 1 0 14.14m-14.14 0a10 10 0 0 1 0-14.14"></path>
              </svg>
            </span>
            <div class="radio-item__info">
              <p class="radio-item__nome">Rádio Metrópole</p>
              <p class="radio-item__desc">Mercado financeiro</p>
              <p class="radio-item__data">09 de março de 2025</p>
            </div>
            <a href="#" class="btn-ouvir">
              <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M6 4l14 8-14 8V4z"/></svg>
              Ouvir
            </a>
          </li>

          <li class="radio-item">
            <span class="radio-item__icone radio-item__icone--sinal radio-item__icone--sociedade" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="2"></circle>
                <path d="M16.24 7.76a6 6 0 0 1 0 8.49m-8.48-.01a6 6 0 0 1 0-8.49m11.31-2.82a10 10 0 0 1 0 14.14m-14.14 0a10 10 0 0 1 0-14.14"></path>
              </svg>
            </span>
            <div class="radio-item__info">
              <p class="radio-item__nome">Rádio Sociedade</p>
              <p class="radio-item__desc">Educação financeira</p>
              <p class="radio-item__data">22 de fevereiro de 2025</p>
            </div>
            <a href="#" class="btn-ouvir">
              <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M6 4l14 8-14 8V4z"/></svg>
              Ouvir
            </a>
          </li>

          <li class="radio-item">
            <span class="radio-item__icone radio-item__icone--sinal radio-item__icone--itapoan" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="2"></circle>
                <path d="M16.24 7.76a6 6 0 0 1 0 8.49m-8.48-.01a6 6 0 0 1 0-8.49m11.31-2.82a10 10 0 0 1 0 14.14m-14.14 0a10 10 0 0 1 0-14.14"></path>
              </svg>
            </span>
            <div class="radio-item__info">
              <p class="radio-item__nome">Rádio Itapoan FM</p>
              <p class="radio-item__desc">Análise econômica</p>
              <p class="radio-item__data">14 de janeiro de 2025</p>
            </div>
            <a href="#" class="btn-ouvir">
              <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M6 4l14 8-14 8V4z"/></svg>
              Ouvir
            </a>
          </li>

        </ul>
      </div>

      <!-- ============ PODCASTS ============ -->
      <div class="canais-painel canais-painel--podcasts">
        <h3 class="canais-painel__titulo">Podcasts</h3>

        <ul class="podcast-lista">

          <li class="podcast-item">
            <span class="podcast-item__icone podcast-item__icone--img">
              <img src="<?= $img_base ?>logo-spotify.webp" alt="Spotify" loading="lazy">
            </span>
            <div class="podcast-item__info">
              <p class="podcast-item__nome">Spotify</p>
              <p class="podcast-item__desc">Economia, finanças e desenvolvimento</p>
              <p class="podcast-item__data">18 de abril de 2025</p>
              <a href="#" class="btn-plataforma">
                Ouvir no Spotify
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </a>
            </div>
          </li>

          <li class="podcast-item">
            <span class="podcast-item__icone podcast-item__icone--img">
              <img src="<?= $img_base ?>logo-yutube.webp" alt="YouTube" loading="lazy">
            </span>
            <div class="podcast-item__info">
              <p class="podcast-item__nome">YouTube</p>
              <p class="podcast-item__desc">Finanças na Prática<br>Dicas e educação financeira</p>
              <p class="podcast-item__data">10 de março de 2025</p>
              <a href="#" class="btn-plataforma">
                Assistir no YouTube
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </a>
            </div>
          </li>

        </ul>
      </div>

      <!-- ============ IMPRENSA ============ -->
      <div class="canais-painel canais-painel--imprensa">
        <h3 class="canais-painel__titulo">Imprensa</h3>

        <a href="#" class="imprensa-figura">
          <img src="<?= $img_base ?>43-por-cento-dos-brasileiros-planejam-fazer-investimentos-este-ano.webp"
               alt="Matéria de jornal: 43% dos brasileiros planejam fazer investimentos este ano"
               loading="lazy">
        </a>

        <div class="imprensa-conteudo">
          <h4 class="imprensa-titulo">Matéria em jornal impresso</h4>
          <p class="imprensa-texto">
            Artigo publicado em jornal impresso abordando o comportamento dos investidores
            brasileiros e perspectivas econômicas, com participação do economista Bruno Mota.
          </p>
          <a href="#" class="btn-materia">
            Ler matéria
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>
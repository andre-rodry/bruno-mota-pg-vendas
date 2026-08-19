<?php
/**
 * front-page.php
 * Template usado especificamente para a página inicial do site.
 *
 * Versão CONSOLIDADA: todas as seções (banner, último artigo, stats, about,
 * mídia, instituições, galeria, publicações) foram trazidas para dentro
 * deste único arquivo, no lugar dos antigos get_template_part().
 *
 * O loader de entrada é global e vive no header.php — aparece em
 * qualquer página quando há um F5/refresh, não só na home.
 */

get_header();
?>

<!-- =========================================================
     BANNER
========================================================== -->
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

<main id="main-content">

    <!-- =========================================================
         ÚLTIMO ARTIGO
         Obs: o "return;" original foi trocado por "if" pra não
         encerrar o resto da página quando não houver posts.
    ========================================================== -->
    <?php
    $ultimo_artigo = get_posts( array(
        'numberposts' => 1,
        'post_status' => 'publish',
    ) );

    if ( ! empty( $ultimo_artigo ) ) :
        $post = $ultimo_artigo[0];
        ?>
        <section class="latest-article-bar">
            <div class="latest-article-bar__inner">

                <div class="latest-article-bar__label">
                    <i class="fa-solid fa-book-open latest-article-bar__icon" aria-hidden="true"></i>
                    <span>Último artigo publicado</span>
                </div>

                <div class="latest-article-bar__title">
                    <?php echo esc_html( get_the_title( $post ) ); ?>
                </div>

                <a class="latest-article-bar__link" href="<?php echo esc_url( get_permalink( $post ) ); ?>">
                    Ler artigo
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>

            </div>
        </section>
    <?php endif; ?>

    <!-- =========================================================
         STATS
    ========================================================== -->
    <?php
    $stats = array(
        array(
            'icon'  => 'fa-book-open',
            'value' => '+20',
            'label' => 'Publicações',
            'sub'   => 'acadêmicas',
        ),
        array(
            'icon'  => 'fa-user-group',
            'value' => '+100 mil',
            'label' => 'Pessoas alcançadas',
            'sub'   => 'na mídia nacional',
        ),
        array(
            'icon'  => 'fa-globe',
            'value' => '+10',
            'label' => 'Eventos',
            'sub'   => 'nacionais e internacionais',
        ),
        array(
            'icon'  => 'fa-landmark',
            'value' => '1',
            'label' => 'Lei municipal',
            'sub'   => 'aprovada na área da educação',
        ),
        array(
            'icon'  => 'fa-microphone',
            'value' => '+100 mil',
            'label' => 'Alcance na mídia',
            'sub'   => 'entrevistas e reportagens',
        ),
    );
    ?>

    <section class="stats-bar">
        <div class="stats-bar__inner">
            <?php foreach ( $stats as $index => $stat ) : ?>

                <div class="stats-bar__item">
                    <i class="fa-solid <?php echo esc_attr( $stat['icon'] ); ?> stats-bar__icon" aria-hidden="true"></i>
                    <div class="stats-bar__text">
                        <div class="stats-bar__value"><?php echo esc_html( $stat['value'] ); ?></div>
                        <div class="stats-bar__label"><?php echo esc_html( $stat['label'] ); ?></div>
                        <div class="stats-bar__sub"><?php echo esc_html( $stat['sub'] ); ?></div>
                    </div>
                </div>

                <?php if ( $index < count( $stats ) - 1 ) : ?>
                    <div class="stats-bar__divider"></div>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>
    </section>

    <!-- =========================================================
         SOBRE (Quem é Bruno Mota)
    ========================================================== -->
    <?php $about_img = 'https://i.ibb.co/mFNCDYM3/6ea39959-81fd-481f-aa97-48ccaa054e45.png'; ?>

    <div class="bml-sobre-mota">

        <section class="bml-about">
            <div class="bml-about-inner">

                <div class="bml-about-photo">
                    <img src="<?php echo esc_url( $about_img ); ?>" alt="Bruno Mota">
                </div>

                <div class="bml-about-content">
                    <span class="bml-eyebrow">Quem é</span>
                    <h2 class="bml-name">Bruno Mota</h2>

                    <p>Economista, pesquisador e consultor com atuação destacada em políticas públicas, desenvolvimento econômico e educação financeira.</p>

                    <p>Com mais de 20 publicações acadêmicas e presença constante na mídia nacional, Bruno Mota transforma conhecimento técnico em soluções práticas para o desenvolvimento de pessoas, instituições e da sociedade.</p>

                    <p>Sua trajetória é marcada pelo compromisso com a educação, a ética e o impacto real na vida das pessoas.</p>

                    <a href="<?php echo esc_url( home_url( '/sobre' ) ); ?>" class="bml-cta-button">
                        Saiba mais sobre mim
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 12h16M14 6l6 6-6 6"/>
                        </svg>
                    </a>
                </div>

            </div>
        </section>

    </div>

    <!-- =========================================================
         MÍDIA (carrossel "Participações na Mídia")
    ========================================================== -->
    <?php
    $itens_midia = array(
        array(
            'thumb'    => 'https://i.ibb.co/LLCVm7T/bgh6777.png',
            'duracao'  => '05:00',
            'fonte'    => 'BATV GLOBO',
            'desc'     => 'Outubro chega com aumentos nos preços do gás e combustíveis',
            'link'     => '#',
        ),
        array(
            'thumb'    => 'https://i.ibb.co/cSNyw5KT/nmyuy8879.png',
            'duracao'  => '05:00',
            'fonte'    => 'BATV GLOBO',
            'desc'     => 'Calor impulsiona vendas de ar condicionado',
            'link'     => '#',
        ),
        array(
            'thumb'    => 'https://i.ibb.co/0jcdPrb9/3434gh67.png',
            'duracao'  => '05:00',
            'fonte'    => 'BATV GLOBO',
            'desc'     => 'Inflação desacelera em Salvador e região metropolitana',
            'link'     => '#',
        ),
        array(
            'thumb'    => 'https://i.ibb.co/bjDbrYSV/bahiatv.png',
            'duracao'  => '05:00',
            'fonte'    => 'BATV GLOBO',
            'desc'     => 'Clientes podem levar dívidas de um banco para outro',
            'link'     => '#',
        ),
        array(
            'thumb'    => 'https://i.ibb.co/wZMRF3My/obo567766.png',
            'duracao'  => '05:00',
            'fonte'    => 'BATV GLOBO',
            'desc'     => 'Vantagens e desvantagens do empréstimo consignado',
            'link'     => '#',
        ),
        array(
            'thumb'    => 'https://i.ibb.co/hJz11hSx/ad409e27-0312-48f2-ab8f-75d8401ab2b2.png',
            'duracao'  => '05:00',
            'fonte'    => 'BAND CIDADE',
            'desc'     => 'Entrevista sobre economia',
            'link'     => '#',
        ),
        array(
            'thumb'    => 'https://i.ibb.co/WWZPHtdW/tv-5.png',
            'duracao'  => '06:12',
            'fonte'    => 'BATV GLOBO',
            'desc'     => 'Crédito rotativo do cartão pode acabar',
            'link'     => '#',
        ),
        array(
            'thumb'    => 'https://i.ibb.co/9mKQwF5b/tv-767.png',
            'duracao'  => '05:08',
            'fonte'    => 'AGRO BAND BAHIA',
            'desc'     => 'Revogação das Tarifária pelo EUA: Impactos no Agronegócio',
            'link'     => '#',
        ),
        array(
            'thumb'    => 'https://i.ibb.co/k2m7cytz/a69c3137-a6b7-4653-a343-a6703031169f.png',
            'duracao'  => '05:40',
            'fonte'    => 'TVARATU SBT',
            'desc'     => 'Aumentos nos preços dos combustíveis',
            'link'     => '#',
        ),
    );
    ?>

    <section class="bml-midia-secao">
      <div class="bml-midia-container">

        <div class="bml-midia-cabecalho">
          <h2 class="bml-midia-titulo">Participações na Mídia</h2>
          <a href="#" class="bml-midia-btn-todas">Ver todas</a>
        </div>

        <div class="bml-midia-carousel-wrapper">
          <button class="bml-midia-seta bml-midia-seta-prev" type="button" aria-label="Anterior">
            <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M9 1L1.5 8L9 15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>

          <div class="bml-midia-track-viewport">
            <div class="bml-midia-track">

              <?php foreach ( $itens_midia as $item ) : ?>
              <article class="bml-midia-card">
                <a href="<?php echo esc_url( $item['link'] ); ?>" class="bml-midia-thumb" style="background-image:url('<?php echo esc_url( $item['thumb'] ); ?>');">
                  <span class="bml-midia-play">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M5 3L15 9L5 15V3Z" fill="currentColor"/></svg>
                  </span>
                  <span class="bml-midia-duracao"><?php echo esc_html( $item['duracao'] ); ?></span>
                </a>
                <div class="bml-midia-info">
                  <span class="bml-midia-fonte"><?php echo esc_html( $item['fonte'] ); ?></span>
                  <p class="bml-midia-desc"><?php echo esc_html( $item['desc'] ); ?></p>
                </div>
              </article>
              <?php endforeach; ?>

            </div>
          </div>

          <button class="bml-midia-seta bml-midia-seta-next" type="button" aria-label="Próximo">
            <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M1 1L8.5 8L1 15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
        </div>

      </div>
    </section>

    <!-- =========================================================
         INSTITUIÇÕES
    ========================================================== -->
    <?php
    $instituicoes = array(
        array( 'nome' => 'CORECON', 'logo' => 'https://i.ibb.co/mFyRrqTW/1.png' ),
        array( 'nome' => 'COFECON', 'logo' => 'https://i.ibb.co/pjtRjBFP/2.png' ),
        array( 'nome' => 'UNICAMP', 'logo' => 'https://i.ibb.co/392nqFDY/3.png' ),
        array( 'nome' => 'BAND', 'logo' => 'https://i.ibb.co/7NL6C7sv/4.png' ),
        array( 'nome' => 'OUTRAS PALAVRAS', 'logo' => 'https://i.ibb.co/Wv3byZWx/5.png' ),
        array( 'nome' => 'RED', 'logo' => 'https://i.ibb.co/h17YTMvg/6.png' ),
        array( 'nome' => 'Expert', 'logo' => 'https://i.ibb.co/pr1ryqQy/7.png' ),
    );
    ?>

    <section class="bml-instituicoes">
        <div class="bml-instituicoes__inner">

            <p class="bml-instituicoes__titulo">Atuação reconhecida por importantes instituições</p>

            <div class="bml-instituicoes__logos">
                <?php foreach ( $instituicoes as $inst ) : ?>
                    <img
                        src="<?php echo esc_url( $inst['logo'] ); ?>"
                        alt="<?php echo esc_attr( $inst['nome'] ); ?>"
                        class="bml-instituicoes__logo"
                        loading="lazy"
                    >
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- =========================================================
         GALERIA DE MOMENTOS
    ========================================================== -->
    <?php
    $gallery_images = array(
        array(
            'full'  => 'https://i.ibb.co/FqYSjMKV/Whats-App-Image-2026-08-01-at-14-26-43-1.jpg',
            'thumb' => 'https://i.ibb.co/FqYSjMKV/Whats-App-Image-2026-08-01-at-14-26-43-1.jpg',
            'title' => 'Palestra',
            'desc'  => 'Momento de fala durante o evento.',
        ),
        array(
            'full'  => 'https://i.ibb.co/6cYsYCrp/Whats-App-Image-2026-08-01-at-14-26-43-2.jpg',
            'thumb' => 'https://i.ibb.co/6cYsYCrp/Whats-App-Image-2026-08-01-at-14-26-43-2.jpg',
            'title' => 'Painel de debate',
            'desc'  => 'Participação em mesa redonda sobre finanças.',
        ),
        array(
            'full'  => 'https://i.ibb.co/bgKwM9kf/Whats-App-Image-2026-08-01-at-14-26-43-3.jpg',
            'thumb' => 'https://i.ibb.co/bgKwM9kf/Whats-App-Image-2026-08-01-at-14-26-43-3.jpg',
            'title' => 'Apresentação',
            'desc'  => 'Condução de apresentação institucional.',
        ),
        array(
            'full'  => 'https://i.ibb.co/MDH2LVGX/Whats-App-Image-2026-08-01-at-14-26-43.jpg',
            'thumb' => 'https://i.ibb.co/MDH2LVGX/Whats-App-Image-2026-08-01-at-14-26-43.jpg',
            'title' => 'Reconhecimento',
            'desc'  => 'Entrega de certificado e homenagem.',
        ),
        array(
            'full'  => 'https://i.ibb.co/wrL7Rmjm/livro900.png',
            'thumb' => 'https://i.ibb.co/wrL7Rmjm/livro900.png',
            'title' => 'Lançamento',
            'desc'  => 'Registro de material institucional.',
        ),
        array(
            'full'  => 'https://i.ibb.co/DBGFn6G/7980909.png',
            'thumb' => 'https://i.ibb.co/DBGFn6G/7980909.png',
            'title' => 'Entrevista',
            'desc'  => 'Entrevista concedida durante cobertura do evento.',
        ),
        array(
            'full'  => 'https://i.ibb.co/Q34WgJ7n/m5656.png',
            'thumb' => 'https://i.ibb.co/Q34WgJ7n/m5656.png',
            'title' => 'Pronunciamento',
            'desc'  => 'Discurso no púlpito do Corecon.',
        ),
    );
    ?>

    <section class="gallery-section" id="galeria-de-momentos">
        <div class="gallery-section__inner">

            <h2 class="gallery-section__title">
                <span class="gallery-section__title-line" aria-hidden="true"></span>
                <span class="gallery-section__title-text">Galeria de Momentos</span>
                <span class="gallery-section__title-line" aria-hidden="true"></span>
            </h2>

            <div class="gallery-grid-wrap">
                <button type="button" class="gallery-grid__nav gallery-grid__nav--prev" data-grid-prev aria-label="Ver fotos anteriores">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 5l-7 7 7 7"/>
                    </svg>
                </button>

                <div class="gallery-grid" data-gallery-grid>
                    <?php foreach ( $gallery_images as $index => $image ) : ?>
                        <button
                            type="button"
                            class="gallery-grid__item"
                            data-gallery-trigger
                            data-index="<?php echo esc_attr( $index ); ?>"
                            data-full="<?php echo esc_url( $image['full'] ); ?>"
                            data-title="<?php echo esc_attr( $image['title'] ); ?>"
                            data-desc="<?php echo esc_attr( $image['desc'] ); ?>"
                            aria-label="Ampliar foto: <?php echo esc_attr( $image['title'] ); ?>"
                        >
                            <img
                                src="<?php echo esc_url( $image['thumb'] ); ?>"
                                alt="<?php echo esc_attr( $image['title'] ); ?>"
                                loading="lazy"
                            >
                        </button>
                    <?php endforeach; ?>
                </div>

                <button type="button" class="gallery-grid__nav gallery-grid__nav--next" data-grid-next aria-label="Ver mais fotos">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

        </div>

        <!-- Lightbox (instância única, populada via JS) -->
        <div class="gallery-lightbox" data-gallery-lightbox aria-hidden="true">
            <div class="gallery-lightbox__backdrop" data-gallery-close></div>

            <div class="gallery-lightbox__dialog" role="dialog" aria-modal="true" aria-label="Visualizador de fotos">

                <button type="button" class="gallery-lightbox__close" data-gallery-close aria-label="Fechar">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                        <path d="M5 5l14 14M19 5L5 19"/>
                    </svg>
                </button>

                <button type="button" class="gallery-lightbox__nav gallery-lightbox__nav--prev" data-gallery-prev aria-label="Foto anterior">
                    <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 5l-7 7 7 7"/>
                    </svg>
                </button>

                <button type="button" class="gallery-lightbox__nav gallery-lightbox__nav--next" data-gallery-next aria-label="Próxima foto">
                    <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <div class="gallery-lightbox__stage" data-gallery-stage>
                    <img src="" alt="" class="gallery-lightbox__image" data-gallery-image draggable="false">
                </div>

                <div class="gallery-lightbox__footer">
                    <div class="gallery-lightbox__caption">
                        <p class="gallery-lightbox__caption-title" data-gallery-caption-title></p>
                        <p class="gallery-lightbox__caption-desc" data-gallery-caption-desc></p>
                    </div>
                    <div class="gallery-lightbox__counter" data-gallery-counter>1 / 1</div>
                </div>

            </div>
        </div>
    </section>

    <!-- =========================================================
         PUBLICAÇÕES E ARTIGOS
    ========================================================== -->
    <section class="publications-section">
      <div class="publications-section__inner">

        <p class="publications-section__title">Publicações e Artigos</p>

        <div class="publications-cols">

          <!-- LIVROS -->
          <div>
            <div class="publications-col-head">
              <h3>Livros</h3>
              <a class="publications-ver-todos" href="https://economistabrunomota.com.br/ebooks/" target="_blank" rel="noopener">Ver todos</a>
            </div>
            <div class="publications-livros-grid" id="publications-livros-grid">
              <!-- Conteúdo fixo: a página /ebooks/ não usa a REST API do WordPress,
                   é montada manualmente no Elementor, sem post type próprio.
                   Os dados abaixo foram tirados direto do conteúdo real da página. -->
              <a class="publications-livro-card" href="https://suasfinancasnoazul.com.br/" target="_blank" rel="noopener">
                <img src="https://economistabrunomota.com.br/wp-content/uploads/2025/02/Ebooks-Suas-Financas-no-Azul-1024x1024.webp" alt="Suas Finanças no Azul">
              </a>
              <a class="publications-livro-card" href="https://drive.google.com/file/d/1Z3saHfUhChx-OmAA-pJh1lkVzuuR1JJN/view?usp=drive_link" target="_blank" rel="noopener">
                <img src="https://economistabrunomota.com.br/wp-content/uploads/2025/02/saia-das-dividas-1024x1024.webp" alt="Saia das Dívidas">
              </a>
              <a class="publications-livro-card" href="https://bnb.gov.br/s482-dspace/bitstream/123456789/800/1/2011_LIV_AEMB.pdf" target="_blank" rel="noopener">
                <img src="https://economistabrunomota.com.br/wp-content/uploads/2025/02/Analise-da-Evolucao-do-Microcredito-na-Bahia-1024x1024.webp" alt="Análise da Evolução do Microcrédito na Bahia">
              </a>
            </div>
          </div>

          <!-- ARTIGOS -->
          <div>
            <div class="publications-col-head">
              <h3>Artigos</h3>
              <a class="publications-ver-todos" href="https://economistabrunomota.com.br/blog/" target="_blank" rel="noopener">Ver todos</a>
            </div>
            <div id="publications-artigos-list">
              <p class="publications-status">Carregando artigos...</p>
            </div>
          </div>

          <!-- ENTREVISTAS E COLUNAS -->
          <div>
            <div class="publications-col-head">
              <h3>Entrevistas e Colunas</h3>
              <a class="publications-ver-todos" href="#" id="publications-entrevistas-ver-todas">Ver todas</a>
            </div>
            <div class="publications-entrevistas-carousel">
              <div class="publications-entrevistas-track" id="publications-entrevistas-track"></div>
            </div>
            <div class="publications-entrevistas-dots" id="publications-entrevistas-dots"></div>
          </div>

        </div>
      </div>
    </section>

    <!-- Aqui entram as próximas seções: atuação, trajetória, contato -->

</main>

<?php
get_footer();
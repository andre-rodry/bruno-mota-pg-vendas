<?php
/**
 * content-midia-home.php
 * Bloco "Participações na Mídia" (carrossel) exibido na página inicial.
 *
 * Uso: <?php get_template_part( 'template-parts/content', 'midia-home' ); ?>
 * CSS correspondente: page-midia-home.css
 */

$midia_home_base_url = get_template_directory_uri() . '/assets/img/home/';

$itens_midia_home = array(
    array(
        'thumb'   => $midia_home_base_url . 'entrevista-band.webp',
        'fonte'   => 'TV BAND',
        'desc'    => 'Inflação tem menor alta do ano com queda no preço dos alimentos',
        'link'    => '#',
    ),
    array(
        'thumb'   => $midia_home_base_url . 'entrevista-agro-band.webp',
        'fonte'   => 'TV BAND',
        'desc'    => 'Revogação das Tarifária pelo EUA: Impactos no Agronegócio',
        'link'    => '#',
    ),
    array(
        'thumb'   => $midia_home_base_url . 'entrevista-batv.webp',
        'fonte'   => 'TV GLOBO',
        'desc'    => 'Crédito rotativo do cartão pode acabar',
        'link'    => '#',
    ),
    array(
        'thumb'   => $midia_home_base_url . 'entrevista-band-cidade.webp',
        'fonte'   => 'TV BAND',
        'desc'    => 'Inflação desacelera: alimentos e bebidas têm queda de preço',
        'link'    => '#',
    ),
    array(
        'thumb'   => $midia_home_base_url . 'entrevista-tv-globo.webp',
        'fonte'   => 'TV GLOBO',
        'desc'    => 'Bom Dia Brasil: queda no preço do café',
        'link'    => '#',
    ),
);
?>

<section class="midia-home">
  <div class="midia-home__container">

    <div class="midia-home__cabecalho">
      <a href="#" class="midia-home__btn-todas">Ver todas</a>

      <div class="midia-home__cabecalho-texto">
        <span class="midia-home__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="28" height="28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="2.5" y="5.5" width="19" height="13" rx="2" stroke="currentColor" stroke-width="1.4"/>
            <path d="M9.5 9.2v5.6l5-2.8-5-2.8Z" fill="currentColor"/>
          </svg>
        </span>

        <h2 class="midia-home__titulo">PARTICIPAÇÕES <span class="text-gold">NA TV</span></h2>

        <div class="midia-home__divider"><span></span><i class="diamond"></i><span></span></div>

        <p class="midia-home__subtitulo">Entrevistas e matérias exibidas em diferentes emissoras de TV.</p>
      </div>
    </div>

    <div class="midia-home__carousel-wrapper">
      <button class="midia-home__seta midia-home__seta--prev" type="button" aria-label="Anterior">
        <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M9 1L1.5 8L9 15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>

      <div class="midia-home__track-viewport">
        <div class="midia-home__track">

          <?php foreach ( $itens_midia_home as $item ) : ?>
          <article class="midia-home__card">
            <a href="<?php echo esc_url( $item['link'] ); ?>" class="midia-home__thumb" style="background-image:url('<?php echo esc_url( $item['thumb'] ); ?>');">
              <span class="midia-home__play">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M5 3L15 9L5 15V3Z" fill="currentColor"/></svg>
              </span>
            </a>
            <div class="midia-home__info">
              <span class="midia-home__fonte"><?php echo esc_html( $item['fonte'] ); ?></span>
              <p class="midia-home__desc"><?php echo esc_html( $item['desc'] ); ?></p>
            </div>
          </article>
          <?php endforeach; ?>

        </div>
      </div>

      <button class="midia-home__seta midia-home__seta--next" type="button" aria-label="Próximo">
        <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M1 1L8.5 8L1 15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
    </div>

  </div>
</section>
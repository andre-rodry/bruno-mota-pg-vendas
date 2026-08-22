<?php
/**
 * content-midia-home.php
 * Bloco "Participações na Mídia" (carrossel) exibido na página inicial.
 *
 * Uso: <?php get_template_part( 'template-parts/content', 'midia-home' ); ?>
 * CSS correspondente: page-midia-home.css
 */

$itens_midia_home = array(
    array(
        'thumb'   => 'https://i.ibb.co/LLCVm7T/bgh6777.png',
        'duracao' => '05:00',
        'fonte'   => 'BATV GLOBO',
        'desc'    => 'Outubro chega com aumentos nos preços do gás e combustíveis',
        'link'    => '#',
    ),
    array(
        'thumb'   => 'https://i.ibb.co/cSNyw5KT/nmyuy8879.png',
        'duracao' => '05:00',
        'fonte'   => 'BATV GLOBO',
        'desc'    => 'Calor impulsiona vendas de ar condicionado',
        'link'    => '#',
    ),
    array(
        'thumb'   => 'https://i.ibb.co/0jcdPrb9/3434gh67.png',
        'duracao' => '05:00',
        'fonte'   => 'BATV GLOBO',
        'desc'    => 'Inflação desacelera em Salvador e região metropolitana',
        'link'    => '#',
    ),
    array(
        'thumb'   => 'https://i.ibb.co/bjDbrYSV/bahiatv.png',
        'duracao' => '05:00',
        'fonte'   => 'BATV GLOBO',
        'desc'    => 'Clientes podem levar dívidas de um banco para outro',
        'link'    => '#',
    ),
    array(
        'thumb'   => 'https://i.ibb.co/wZMRF3My/obo567766.png',
        'duracao' => '05:00',
        'fonte'   => 'BATV GLOBO',
        'desc'    => 'Vantagens e desvantagens do empréstimo consignado',
        'link'    => '#',
    ),
    array(
        'thumb'   => 'https://i.ibb.co/hJz11hSx/ad409e27-0312-48f2-ab8f-75d8401ab2b2.png',
        'duracao' => '05:00',
        'fonte'   => 'BAND CIDADE',
        'desc'    => 'Entrevista sobre economia',
        'link'    => '#',
    ),
    array(
        'thumb'   => 'https://i.ibb.co/WWZPHtdW/tv-5.png',
        'duracao' => '06:12',
        'fonte'   => 'BATV GLOBO',
        'desc'    => 'Crédito rotativo do cartão pode acabar',
        'link'    => '#',
    ),
    array(
        'thumb'   => 'https://i.ibb.co/9mKQwF5b/tv-767.png',
        'duracao' => '05:08',
        'fonte'   => 'AGRO BAND BAHIA',
        'desc'    => 'Revogação das Tarifária pelo EUA: Impactos no Agronegócio',
        'link'    => '#',
    ),
    array(
        'thumb'   => 'https://i.ibb.co/k2m7cytz/a69c3137-a6b7-4653-a343-a6703031169f.png',
        'duracao' => '05:40',
        'fonte'   => 'TVARATU SBT',
        'desc'    => 'Aumentos nos preços dos combustíveis',
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
              <span class="midia-home__duracao"><?php echo esc_html( $item['duracao'] ); ?></span>
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
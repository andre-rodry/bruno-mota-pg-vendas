<?php
/**
 * template-parts/media.php
 * Carrossel "Participações na Mídia".
 *
 * Adaptado do widget HTML feito originalmente pro Elementor.
 * Prefixo mantido: .bml-midia-
 *
 * Pra editar/adicionar itens, mexa no array $itens_midia abaixo.
 */

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
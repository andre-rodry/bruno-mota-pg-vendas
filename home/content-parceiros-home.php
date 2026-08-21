<?php
/**
 * content-parceiros-home.php
 * Bloco "Instituições / Parceiros" exibido na página inicial.
 *
 * Uso: <?php get_template_part( 'template-parts/content', 'parceiros-home' ); ?>
 * CSS correspondente: page-parceiros-home.css
 */

$itens_parceiros_home = array(
    array(
        'nome' => 'CORECON',
        'logo' => 'https://i.ibb.co/mFyRrqTW/1.png',
    ),
    array(
        'nome' => 'COFECON',
        'logo' => 'https://i.ibb.co/pjtRjBFP/2.png',
    ),
    array(
        'nome' => 'UNICAMP',
        'logo' => 'https://i.ibb.co/392nqFDY/3.png',
    ),
    array(
        'nome' => 'BAND',
        'logo' => 'https://i.ibb.co/7NL6C7sv/4.png',
    ),
    array(
        'nome' => 'OUTRAS PALAVRAS',
        'logo' => 'https://i.ibb.co/Wv3byZWx/5.png',
    ),
    array(
        'nome' => 'RED',
        'logo' => 'https://i.ibb.co/h17YTMvg/6.png',
    ),
    array(
        'nome' => 'Expert',
        'logo' => 'https://i.ibb.co/pr1ryqQy/7.png',
    ),
);
?>

<section class="parceiros-home">
  <div class="parceiros-home__container">

    <p class="parceiros-home__titulo">Atuação reconhecida por importantes instituições</p>

    <div class="parceiros-home__logos">
      <?php foreach ( $itens_parceiros_home as $item ) : ?>
        <img
          src="<?php echo esc_url( $item['logo'] ); ?>"
          alt="<?php echo esc_attr( $item['nome'] ); ?>"
          class="parceiros-home__logo"
          loading="lazy"
        >
      <?php endforeach; ?>
    </div>

  </div>
</section>
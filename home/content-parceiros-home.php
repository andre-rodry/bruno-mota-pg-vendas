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
        'nome' => 'COFECON',
        'logo' => get_template_directory_uri() . '/assets/img/home/cofecon-conselho-federal-economia.webp',
    ),
    array(
        'nome' => 'CORECON-BA',
        'logo' => get_template_directory_uri() . '/assets/img/home/corecon-ba-conselho-regional-economia.webp',
    ),
    array(
        'nome' => 'Expert Editora',
        'logo' => get_template_directory_uri() . '/assets/img/home/expert-editora.webp',
    ),
    array(
        'nome' => 'Outras Palavras',
        'logo' => get_template_directory_uri() . '/assets/img/home/outras-palavras-jornalismo.webp',
    ),
    array(
        'nome'   => 'RED',
        'logo'   => get_template_directory_uri() . '/assets/img/home/red.webp',
        'escala' => 1.2,
    ),
    array(
        'nome' => 'Revista Desenvolvimento Econômico',
        'logo' => get_template_directory_uri() . '/assets/img/home/revista-desenvolvimento-economico.webp',
    ),
    array(
        'nome' => 'SEI - Superintendência de Estudos Econômicos e Sociais da Bahia',
        'logo' => get_template_directory_uri() . '/assets/img/home/sei-superintendencia-estudos-economicos-sociais-bahia.webp',
    ),
    array(
        'nome'   => 'Band',
        'logo'   => get_template_directory_uri() . '/assets/img/home/tv-band.webp',
        'escala' => 1.15,
    ),
    array(
        'nome'   => 'Globo',
        'logo'   => get_template_directory_uri() . '/assets/img/home/tv-globo.webp',
        'escala' => 1.15,
    ),
    array(
        'nome' => 'UNICAMP',
        'logo' => get_template_directory_uri() . '/assets/img/home/unicamp-universidade-estadual-campinas.webp',
    ),
);
?>

<section class="parceiros-home">
  <div class="parceiros-home__container">

    <p class="parceiros-home__titulo">Atuação reconhecida por importantes instituições</p>

    <div class="parceiros-home__logos">
      <?php foreach ( $itens_parceiros_home as $item ) :
          $escala = isset( $item['escala'] ) ? $item['escala'] : 1;
      ?>
        <span class="parceiros-home__logo-box">
          <img
            src="<?php echo esc_url( $item['logo'] ); ?>"
            alt="<?php echo esc_attr( $item['nome'] ); ?>"
            class="parceiros-home__logo"
            style="--escala: <?php echo esc_attr( $escala ); ?>;"
            loading="lazy"
          >
        </span>
      <?php endforeach; ?>
    </div>

  </div>
</section>
<?php
/**
 * Conteúdo: Emissoras e Veículos (carrossel)
 * Usado em: page-midia.php
 */

$emissoras = array(
    array( 'arquivo' => 'agro-band-logo.webp',        'alt' => 'Agro Band' ),
    array( 'arquivo' => 'bahia-cast-logo.webp',        'alt' => 'Bahia Cast' ),
    array( 'arquivo' => 'bahia-tv.webp-logo.webp',     'alt' => 'BA TV' ),
    array( 'arquivo' => 'band-logo.webp',              'alt' => 'Band' ),
    array( 'arquivo' => 'band-news-tv-logo.webp',      'alt' => 'Band News TV' ),
    array( 'arquivo' => 'dia-dia-news-logo.webp',      'alt' => 'Dia a Dia News' ),
    array( 'arquivo' => 'globo-logo.webp',             'alt' => 'Globo' ),
    array( 'arquivo' => 'jornal-da-band-logo.webp',    'alt' => 'Jornal da Band' ),
    array( 'arquivo' => 'sbt-logo.webp',               'alt' => 'SBT' ),
    array( 'arquivo' => 'sociedade-news-fm-logo.webp', 'alt' => 'Sociedade News FM' ),
    array( 'arquivo' => 'tv-aratu-logo.webp',          'alt' => 'TV Aratu' ),
    array( 'arquivo' => 'tve-logo.webp',               'alt' => 'TVE Bahia' ),
    array( 'arquivo' => 'tv-resistencia-logo.webp',    'alt' => 'TV Resistência' ),
);

$midia_uri = get_template_directory_uri() . '/assets/img/midia/';
?>

<section class="emissoras-midia">
    <div class="emissoras-midia__container">

        <h2 class="emissoras-midia__title">Onde Bruno Mota já participou</h2>

        <div class="emissoras-midia__carousel">
            <div class="emissoras-midia__track">

                <?php foreach ( $emissoras as $item ) : ?>
                    <div class="emissoras-midia__card">
                        <img
                            src="<?php echo esc_url( $midia_uri . $item['arquivo'] ); ?>"
                            alt="<?php echo esc_attr( $item['alt'] ); ?>"
                            loading="lazy"
                        >
                    </div>
                <?php endforeach; ?>

                <?php // duplicata para o loop infinito ficar contínuo ?>
                <?php foreach ( $emissoras as $item ) : ?>
                    <div class="emissoras-midia__card" aria-hidden="true">
                        <img
                            src="<?php echo esc_url( $midia_uri . $item['arquivo'] ); ?>"
                            alt=""
                            loading="lazy"
                        >
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

    </div>
</section>
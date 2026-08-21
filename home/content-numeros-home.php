<?php
/**
 * content-numeros-home.php
 * Bloco de estatísticas ("Números") exibido na página inicial.
 *
 * Uso: <?php get_template_part( 'template-parts/content', 'numeros-home' ); ?>
 * CSS correspondente: page-numeros-home.css
 */

$numeros_home = array(
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
        'value' => '',
        'label' => 'Líder mundial',
        'sub'   => 'na indústria de ferro e aço (ex-diretor)',
    ),
    array(
        'icon'  => 'fa-microphone',
        'value' => '+100 mil',
        'label' => 'Alcance na mídia',
        'sub'   => 'entrevistas e reportagens',
    ),
);
?>

<section class="numeros-home">
    <div class="numeros-home__inner">
        <?php foreach ( $numeros_home as $index => $numero ) : ?>

            <div class="numeros-home__item<?php echo empty( $numero['value'] ) ? ' numeros-home__item--headline-only' : ''; ?>">
                <i class="fa-solid <?php echo esc_attr( $numero['icon'] ); ?> numeros-home__icon" aria-hidden="true"></i>
                <div class="numeros-home__text">
                    <div class="numeros-home__headline">
                        <?php if ( ! empty( $numero['value'] ) ) : ?>
                            <span class="numeros-home__value"><?php echo esc_html( $numero['value'] ); ?></span>
                        <?php endif; ?>
                        <span class="numeros-home__label"><?php echo esc_html( $numero['label'] ); ?></span>
                    </div>
                    <div class="numeros-home__sub"><?php echo esc_html( $numero['sub'] ); ?></div>
                </div>
            </div>

            <?php if ( $index < count( $numeros_home ) - 1 ) : ?>
                <div class="numeros-home__divider"></div>
            <?php endif; ?>

        <?php endforeach; ?>
    </div>
</section>
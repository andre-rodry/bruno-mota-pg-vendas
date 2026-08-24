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
        'icon'  => 'fa-trophy',
        'value' => '',
        'label' => 'Prêmios',
        'sub'   => 'Corecon-BA & BNB',
    ),
    array(
        'icon'  => 'fa-book',
        'value' => '',
        'label' => 'Educador',
        'sub'   => 'Finanças para Jovens Oficial',
    ),
    array(
        'icon'  => 'fa-landmark',
        'value' => '',
        'label' => 'Conselheiro',
        'sub'   => 'Corecon-BA · 2026',
    ),
    array(
        'icon'  => 'fa-scale-balanced',
        'value' => '',
        'label' => 'Autor de Lei',
        'sub'   => 'Lei 9838/2025',
    ),
    array(
        'icon'  => 'fa-earth-americas',
        'value' => '',
        'label' => 'Presença Global',
        'sub'   => 'Congressos e debates sobre economia',
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
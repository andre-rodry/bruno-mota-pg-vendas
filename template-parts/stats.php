<?php
/**
 * template-parts/stats.php
 * Barra escura com os números de destaque (publicações, alcance, eventos etc).
 *
 * Por enquanto os valores estão fixos aqui embaixo. Se no futuro você quiser
 * editar isso pelo painel do WordPress, dá pra migrar pra Campos Personalizados
 * (ACF) ou pro Personalizador — por ora, é só trocar os valores no array.
 */

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
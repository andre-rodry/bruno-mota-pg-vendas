<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="bm-loader">
    <div class="bm-loader-inner">
        <div class="bm-loader-logo">BM</div>
        <div class="bm-loader-sub">Carregando</div>
        <div class="bm-loader-bar"></div>
    </div>
</div>

<header class="container" style="padding: var(--space-md) 0;">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="font-family: var(--font-display); font-size: 1.5rem; color: var(--text-light);">
        <?php bloginfo( 'name' ); ?>
    </a>
</header>

<?php
/**
 * header.php
 * Início do documento HTML, carregado em toda página via get_header().
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); // OBRIGATÓRIO: plugins e o próprio WP dependem disso ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); // OBRIGATÓRIO desde WP 5.2 ?>

<header class="site-header">
    <div class="container">
        <p class="site-title">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php bloginfo( 'name' ); ?>
            </a>
        </p>

        <nav class="main-navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'fallback_cb'    => false, // não mostra nada se o menu não existir
            ) );
            ?>
        </nav>
    </div>
</header>

<main class="site-content">
    <div class="container">

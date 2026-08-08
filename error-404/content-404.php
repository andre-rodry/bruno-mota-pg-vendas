<?php
/**
 * 404.php
 * Página de erro INDEPENDENTE — não usa get_header()/get_footer(),
 * então não herda o menu nem o rodapé do resto do site.
 * Ocupa a tela inteira (100vh), pensada pra ser um momento isolado.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php esc_html_e( 'Página não encontrada', 'andrewp' ); ?> — <?php bloginfo( 'name' ); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'error-404-standalone' ); ?>>
<?php wp_body_open(); ?>

<section class="error-404-hero error-404-fullscreen">
    <svg class="hero-chartline" viewBox="0 0 1200 500" preserveAspectRatio="none" aria-hidden="true">
        <polyline
            points="0,420 150,400 300,340 450,360 600,260 750,280 900,160 1050,190 1200,90"
            fill="none"
            stroke="#C9962C"
            stroke-width="2"
        />
    </svg>

    <div class="container error-404-inner">
        <span class="hero-eyebrow">Erro 404</span>

        <h1 class="error-404-title">Essa página <em>não existe</em>.</h1>

        <p class="error-404-text">
            O conteúdo que você procura foi movido, removido, ou o endereço
            digitado está incorreto.
        </p>

        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary error-404-back">
            &larr; Voltar para a página inicial
        </a>
    </div>
</section>

<?php wp_footer(); ?>
</body>
</html>
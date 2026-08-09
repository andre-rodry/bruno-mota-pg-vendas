<?php
/**
 * inc/assets.php
 * Carrega todo CSS/JS do tema, com caminhos apontando para as pastas
 * por página (sobre/, atuacao/, conquistas/, home/, error-404/) e
 * para assets/ (arquivos globais: header, footer, loader, reveal-scroll).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function meu_tema_scripts() {

    // Fontes do Google.
    wp_enqueue_style(
        'meu-tema-fonts',
        'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&family=Poppins:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'meu-tema-style',
        get_stylesheet_uri(),
        array( 'meu-tema-fonts' ),
        wp_get_theme()->get( 'Version' )
    );

    // ---- HEADER (global) ----
    wp_enqueue_style(
        'meu-tema-header',
        get_template_directory_uri() . '/assets/css/header.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/assets/css/header.css' )
    );

    wp_enqueue_script(
        'meu-tema-header',
        get_template_directory_uri() . '/assets/js/header.js',
        array(),
        filemtime( get_template_directory() . '/assets/js/header.js' ),
        true
    );

    // Font Awesome (ícones das redes sociais).
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );

    // ---- LOADER GLOBAL ----
    wp_enqueue_style(
        'andrewp-loader',
        get_template_directory_uri() . '/assets/css/loader.css',
        array( 'meu-tema-fonts', 'meu-tema-style' ),
        filemtime( get_template_directory() . '/assets/css/loader.css' )
    );

    wp_enqueue_script(
        'andrewp-loader',
        get_template_directory_uri() . '/assets/js/loader.js',
        array(),
        filemtime( get_template_directory() . '/assets/js/loader.js' ),
        true
    );

    // ---- FOOTER (global) ----
    wp_enqueue_style(
        'andrewp-footer',
        get_template_directory_uri() . '/assets/css/footer.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/assets/css/footer.css' )
    );

    // ---- ANIMAÇÃO DE SCROLL (global) ----
    wp_enqueue_style(
        'meu-tema-reveal-scroll',
        get_template_directory_uri() . '/assets/css/reveal-scroll.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/assets/css/reveal-scroll.css' )
    );

    wp_enqueue_script(
        'meu-tema-reveal-scroll',
        get_template_directory_uri() . '/assets/js/reveal-scroll.js',
        array(),
        filemtime( get_template_directory() . '/assets/js/reveal-scroll.js' ),
        true
    );

    // ---- HOME ----
    if ( is_front_page() ) {

        wp_enqueue_style(
            'meu-tema-home',
            get_template_directory_uri() . '/home/home.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/home/home.css' )
        );

        wp_enqueue_script(
            'meu-tema-home',
            get_template_directory_uri() . '/home/home.js',
            array(),
            filemtime( get_template_directory() . '/home/home.js' ),
            true
        );

        wp_localize_script( 'meu-tema-home', 'publicationsData', array(
            'restUrl' => esc_url_raw( rest_url( 'wp/v2/' ) ),
        ) );
    }

    // ---- PÁGINA SOBRE ----
    if ( is_page( 'sobre' ) ) {
        wp_enqueue_style(
            'andrewp-page-sobre',
            get_template_directory_uri() . '/sobre/sobre.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/sobre/sobre.css' )
        );

        wp_enqueue_script(
            'andrewp-header-scroll',
            get_template_directory_uri() . '/assets/js/header-scroll.js',
            array( 'meu-tema-header' ),
            filemtime( get_template_directory() . '/assets/js/header-scroll.js' ),
            true
        );
    }

    // ---- PÁGINA ATUAÇÃO ----
    if ( is_page( 'atuacao' ) ) {
        wp_enqueue_style(
            'andrewp-atuacao',
            get_template_directory_uri() . '/atuacao/atuacao.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/atuacao/atuacao.css' )
        );

        wp_enqueue_script(
            'andrewp-header-scroll',
            get_template_directory_uri() . '/assets/js/header-scroll.js',
            array( 'meu-tema-header' ),
            filemtime( get_template_directory() . '/assets/js/header-scroll.js' ),
            true
        );
    }

    // ---- PÁGINA CONQUISTAS ----
    if ( is_page( 'conquistas' ) ) {

        wp_enqueue_style(
            'andrewp-conquistas-banner',
            get_template_directory_uri() . '/conquistas/page-banner-conquistas.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/conquistas/page-banner-conquistas.css' )
        );

        wp_enqueue_style(
            'andrewp-conquistas-marquee',
            get_template_directory_uri() . '/conquistas/page-marquee-conquistas.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/conquistas/page-marquee-conquistas.css' )
        );

        wp_enqueue_style(
            'andrewp-conquistas-timeline',
            get_template_directory_uri() . '/conquistas/page-timeline-conquistas.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/conquistas/page-timeline-conquistas.css' )
        );

        wp_enqueue_style(
            'andrewp-conquistas-parceiros',
            get_template_directory_uri() . '/conquistas/page-parceiros-conquistas.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/conquistas/page-parceiros-conquistas.css' )
        );

        wp_enqueue_style(
            'andrewp-conquistas-midia',
            get_template_directory_uri() . '/conquistas/page-midia-conquistas.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/conquistas/page-midia-conquistas.css' )
        );

        wp_enqueue_style(
            'andrewp-conquistas-grid',
            get_template_directory_uri() . '/conquistas/content-grid-conquistas.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/conquistas/content-grid-conquistas.css' )
        );

        wp_enqueue_style(
            'andrewp-conquistas-modal',
            get_template_directory_uri() . '/conquistas/modal-conquista.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/conquistas/modal-conquista.css' )
        );

        wp_enqueue_style( 'dashicons' );

        wp_enqueue_script(
            'andrewp-conquistas-timeline',
            get_template_directory_uri() . '/conquistas/page-timeline-conquistas.js',
            array(),
            filemtime( get_template_directory() . '/conquistas/page-timeline-conquistas.js' ),
            true
        );

        wp_enqueue_script(
            'andrewp-conquistas-grid',
            get_template_directory_uri() . '/conquistas/content-grid-conquistas.js',
            array(),
            filemtime( get_template_directory() . '/conquistas/content-grid-conquistas.js' ),
            true
        );

        wp_localize_script( 'andrewp-conquistas-grid', 'andrewpConquistas', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'andrewp_conquistas_nonce' ),
        ) );
    }

    // ---- PÁGINA PUBLICAÇÕES ----
    if ( is_page( 'publicacoes' ) ) {

        wp_enqueue_style(
            'andrewp-publicacoes-banner',
            get_template_directory_uri() . '/publicacoes/page-banner-publicacoes.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/publicacoes/page-banner-publicacoes.css' )
        );

        wp_enqueue_style(
            'andrewp-publicacoes-categorias',
            get_template_directory_uri() . '/publicacoes/page-categorias-publicacoes.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/publicacoes/page-categorias-publicacoes.css' )
        );

        wp_enqueue_style(
            'andrewp-publicacoes-lista',
            get_template_directory_uri() . '/publicacoes/page-lista-publicacoes.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/publicacoes/page-lista-publicacoes.css' )
        );

        wp_enqueue_style( 'dashicons' );

        wp_enqueue_script(
            'andrewp-publicacoes-categorias',
            get_template_directory_uri() . '/publicacoes/page-categorias-publicacoes.js',
            array(),
            filemtime( get_template_directory() . '/publicacoes/page-categorias-publicacoes.js' ),
            true
        );

        wp_enqueue_script(
            'andrewp-publicacoes-lista',
            get_template_directory_uri() . '/publicacoes/page-lista-publicacoes.js',
            array(),
            filemtime( get_template_directory() . '/publicacoes/page-lista-publicacoes.js' ),
            true
        );

        wp_localize_script( 'andrewp-publicacoes-lista', 'andrewpPublicacoes', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'andrewp_publicacoes_nonce' ),
        ) );
    }

    // ---- PÁGINA 404 ----
    if ( is_404() ) {
        wp_enqueue_style(
            'meu-tema-error-404',
            get_template_directory_uri() . '/error-404/error-404.min.css',
            array( 'meu-tema-style' ),
            wp_get_theme()->get( 'Version' )
        );
    }
}
add_action( 'wp_enqueue_scripts', 'meu_tema_scripts' );
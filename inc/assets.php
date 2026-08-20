<?php
/**
 * inc/assets.php
 * Carrega todo CSS/JS do tema, com caminhos apontando para as pastas
 * pastas por página (sobre/, atuacao/, trajetoria/, home/, error-404/) e
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

    // ---- GLOBAL (regras base do site inteiro) ----
    wp_enqueue_style(
        'meu-tema-global',
        get_template_directory_uri() . '/assets/css/global.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/assets/css/global.css' )
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

        // // Um CSS por seção, seguindo o mesmo padrão usado em "trajetoria".
        // Se algum arquivo ainda não existir, ele é simplesmente ignorado
        // (evita o erro de filemtime() em arquivo inexistente).
        $secoes_sobre = array(
            'banner'   => 'sobre/page-banner-sobre.css',
            'numeros'  => 'sobre/page-numeros-sobre.css',
            'perfil'   => 'sobre/page-perfil-sobre.css',
            'pilares'  => 'sobre/page-pilares-sobre.css',
            'cta'      => 'sobre/page-cta-sobre.css',
        );

        foreach ( $secoes_sobre as $handle_sufixo => $caminho_relativo ) {
            $caminho_absoluto = get_template_directory() . '/' . $caminho_relativo;

            if ( file_exists( $caminho_absoluto ) ) {
                wp_enqueue_style(
                    'andrewp-sobre-' . $handle_sufixo,
                    get_template_directory_uri() . '/' . $caminho_relativo,
                    array( 'meu-tema-style' ),
                    filemtime( $caminho_absoluto )
                );
            }
        }

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

        // Um CSS por seção, seguindo o mesmo padrão usado em "sobre".
        $secoes_atuacao = array(
            'banner'          => 'atuacao/page-banner-atuacao.css',
            'especializacao'  => 'atuacao/page-especializacao-atuacao.css',
            'areas'           => 'atuacao/page-areas-atuacao.css',
            'cta'             => 'atuacao/page-cta-atuacao.css',
        );

        foreach ( $secoes_atuacao as $handle_sufixo => $caminho_relativo ) {
            $caminho_absoluto = get_template_directory() . '/' . $caminho_relativo;

            if ( file_exists( $caminho_absoluto ) ) {
                wp_enqueue_style(
                    'andrewp-atuacao-' . $handle_sufixo,
                    get_template_directory_uri() . '/' . $caminho_relativo,
                    array( 'meu-tema-style' ),
                    filemtime( $caminho_absoluto )
                );
            }
        }

        wp_enqueue_script(
            'andrewp-header-scroll',
            get_template_directory_uri() . '/assets/js/header-scroll.js',
            array( 'meu-tema-header' ),
            filemtime( get_template_directory() . '/assets/js/header-scroll.js' ),
            true
        );
    }

    // ---- PÁGINA TRAJETÓRIA ----
if ( is_page( 'trajetoria' ) ) {
 
    wp_enqueue_style(
        'andrewp-trajetoria-banner',
        get_template_directory_uri() . '/trajetoria/page-banner-trajetoria.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/trajetoria/page-banner-trajetoria.css' )
    );
 
    wp_enqueue_style(
        'andrewp-trajetoria-numeros',
        get_template_directory_uri() . '/trajetoria/page-numeros-trajetoria.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/trajetoria/page-numeros-trajetoria.css' )
    );
 
    wp_enqueue_style(
        'andrewp-trajetoria-valores',
        get_template_directory_uri() . '/trajetoria/page-valores-trajetoria.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/trajetoria/page-valores-trajetoria.css' )
    );
 
    wp_enqueue_style(
        'andrewp-trajetoria-timeline',
        get_template_directory_uri() . '/trajetoria/page-timeline-trajetoria.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/trajetoria/page-timeline-trajetoria.css' )
    );
 
    wp_enqueue_style(
        'andrewp-trajetoria-grid',
        get_template_directory_uri() . '/trajetoria/content-grid-trajetoria.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/trajetoria/content-grid-trajetoria.css' )
    );
 
    wp_enqueue_style(
        'andrewp-trajetoria-galeria',
        get_template_directory_uri() . '/trajetoria/page-galeria-trajetoria.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/trajetoria/page-galeria-trajetoria.css' )
    );
 
    wp_enqueue_style(
        'andrewp-trajetoria-cta',
        get_template_directory_uri() . '/trajetoria/page-cta-trajetoria.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/trajetoria/page-cta-trajetoria.css' )
    );
 
    wp_enqueue_style(
        'andrewp-trajetoria-modal',
        get_template_directory_uri() . '/trajetoria/modal-trajetoria.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/trajetoria/modal-trajetoria.css' )
    );
 
    wp_enqueue_style( 'dashicons' );
 
    wp_enqueue_script(
        'andrewp-trajetoria-timeline',
        get_template_directory_uri() . '/trajetoria/page-timeline-trajetoria.js',
        array(),
        filemtime( get_template_directory() . '/trajetoria/page-timeline-trajetoria.js' ),
        true
    );
 
    wp_enqueue_script(
        'andrewp-trajetoria-grid',
        get_template_directory_uri() . '/trajetoria/content-grid-trajetoria.js',
        array(),
        filemtime( get_template_directory() . '/trajetoria/content-grid-trajetoria.js' ),
        true
    );
 
    wp_enqueue_script(
        'andrewp-trajetoria-galeria',
        get_template_directory_uri() . '/trajetoria/content-galeria-trajetoria.js',
        array(),
        filemtime( get_template_directory() . '/trajetoria/content-galeria-trajetoria.js' ),
        true
    );
 
    wp_localize_script( 'andrewp-trajetoria-grid', 'andrewpTrajetoria', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'andrewp_trajetoria_nonce' ),
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

    // ---- PÁGINA MÍDIA ----
    if ( is_page( 'midia' ) ) {

        wp_enqueue_style(
            'andrewp-midia-banner',
            get_template_directory_uri() . '/midia/page-banner-midia.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/midia/page-banner-midia.css' )
        );

        wp_enqueue_style(
            'andrewp-midia-stats',
            get_template_directory_uri() . '/midia/page-midia-stats.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/midia/page-midia-stats.css' )
        );

        wp_enqueue_style(
            'andrewp-midia-destaques',
            get_template_directory_uri() . '/midia/page-destaques-midia.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/midia/page-destaques-midia.css' )
        );

        wp_enqueue_style(
            'andrewp-midia-emissoras',
            get_template_directory_uri() . '/midia/page-emissoras-midia.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/midia/page-emissoras-midia.css' )
        );

        wp_enqueue_style(
            'andrewp-midia-tv',
            get_template_directory_uri() . '/midia/page-tv-midia.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/midia/page-tv-midia.css' )
        );

        wp_enqueue_style(
            'andrewp-midia-canais',
            get_template_directory_uri() . '/midia/page-canais-midia.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/midia/page-canais-midia.css' )
        );

    }

    // ---- PÁGINA CONTATO ----
    if ( is_page( 'contato' ) ) {

        wp_enqueue_style(
            'andrewp-contato-banner',
            get_template_directory_uri() . '/contato/page-banner-contato.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/contato/page-banner-contato.css' )
        );

        wp_enqueue_style(
            'andrewp-contato-form',
            get_template_directory_uri() . '/contato/page-form-contato.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/contato/page-form-contato.css' )
        );

        wp_enqueue_style(
            'andrewp-contato-faq',
            get_template_directory_uri() . '/contato/page-faq-contato.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/contato/page-faq-contato.css' )
        );

        wp_enqueue_script(
            'andrewp-contato-form',
            get_template_directory_uri() . '/contato/page-form-contato.js',
            array(),
            filemtime( get_template_directory() . '/contato/page-form-contato.js' ),
            true
        );

        wp_localize_script( 'andrewp-contato-form', 'andrewpContato', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        ) );

        wp_enqueue_script(
            'andrewp-contato-faq',
            get_template_directory_uri() . '/contato/page-faq-contato.js',
            array(),
            filemtime( get_template_directory() . '/contato/page-faq-contato.js' ),
            true
        );
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
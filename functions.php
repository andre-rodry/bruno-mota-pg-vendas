<?php
/**
 * functions.php
 * Aqui você registra tudo que o tema "sabe fazer": menus, imagens destacadas,
 * carregamento correto de CSS/JS, tamanhos de imagem, etc.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Bloqueia acesso direto ao arquivo.
}

/**
 * CPT "Conquista" + taxonomia "Tipo de Conquista" + metaboxes
 * (Destaque/Ano e Conteúdo do Modal).
 * Usado pela página /conquistas/ (grid + modal "Ver mais").
 */
require_once get_template_directory() . '/inc/cpt-conquistas.php';

/**
 * Função que renderiza o HTML do modal "Ver mais" de uma conquista
 * a partir do post_id (usada pelo endpoint AJAX abaixo).
 */
require_once get_template_directory() . '/inc/modal-conquista.php';

/**
 * AJAX: "carregar mais" do grid de conquistas + busca do modal "Ver mais".
 * Registra os hooks wp_ajax_andrewp_load_conquistas,
 * wp_ajax_nopriv_andrewp_load_conquistas, wp_ajax_andrewp_get_conquista_modal
 * e wp_ajax_nopriv_andrewp_get_conquista_modal usados por
 * assets/js/content-grid-conquistas.js na página /conquistas/.
 */
require_once get_template_directory() . '/inc/ajax-conquistas.php';

/**
 * Configurações básicas do tema.
 */
function meu_tema_setup() {
    // Permite que o WordPress gerencie o <title> automaticamente.
    add_theme_support( 'title-tag' );

    // Habilita imagem destacada (thumbnail) nos posts.
    add_theme_support( 'post-thumbnails' );

    // Permite logo personalizada via Personalizar > Identidade do site.
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 60,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Suporte a HTML5 para formulários de busca, comentários, galerias etc.
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    // Registra os menus de navegação.
    register_nav_menus( array(
        'primary' => __( 'Menu Principal', 'meu-tema' ),
        'footer'  => __( 'Menu do Rodapé', 'meu-tema' ),
    ) );
}
add_action( 'after_setup_theme', 'meu_tema_setup' );

/**
 * Carrega CSS e JS de forma correta (nunca colocar <link> ou <script> direto no header.php).
 */
function meu_tema_scripts() {
    // Fontes do Google: Fraunces (títulos), Inter (corpo), IBM Plex Mono (dados/números),
    // Poppins (label/CTA em uppercase — página Conquistas).
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

    // CSS do header: carrega em TODAS as páginas, logo depois do style.css principal.
    wp_enqueue_style(
        'meu-tema-header',
        get_template_directory_uri() . '/assets/css/header.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/assets/css/header.css' )
    );

    // JS do header: controla o efeito de scroll e o menu mobile.
    wp_enqueue_script(
        'meu-tema-header',
        get_template_directory_uri() . '/assets/js/header.js',
        array(),
        filemtime( get_template_directory() . '/assets/js/header.js' ),
        true
    );

    // Font Awesome (ícones das redes sociais) — usado no header e no footer.
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

    // CSS do footer: carrega em TODAS as páginas.
    wp_enqueue_style(
        'andrewp-footer',
        get_template_directory_uri() . '/assets/css/footer.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/assets/css/footer.css' )
    );

    // ---- ANIMAÇÃO DE SCROLL (reveal-scroll) ----
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

    // ---- SEÇÕES DA HOME ----
    if ( is_front_page() ) {

        wp_enqueue_style(
            'meu-tema-home',
            get_template_directory_uri() . '/assets/css/home.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/assets/css/home.css' )
        );

        wp_enqueue_script(
            'meu-tema-home',
            get_template_directory_uri() . '/assets/js/home.js',
            array(),
            filemtime( get_template_directory() . '/assets/js/home.js' ),
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
            get_template_directory_uri() . '/assets/css/page-sobre.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/assets/css/page-sobre.css' )
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
            get_template_directory_uri() . '/assets/css/page-atuacao.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/assets/css/page-atuacao.css' )
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
            get_template_directory_uri() . '/assets/css/page-banner-conquistas.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/assets/css/page-banner-conquistas.css' )
        );

        wp_enqueue_style(
            'andrewp-conquistas-marquee',
            get_template_directory_uri() . '/assets/css/page-marquee-conquistas.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/assets/css/page-marquee-conquistas.css' )
        );

        wp_enqueue_style(
            'andrewp-conquistas-timeline',
            get_template_directory_uri() . '/assets/css/page-timeline-conquistas.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/assets/css/page-timeline-conquistas.css' )
        );

        // CSS do grid "Todas as Conquistas" (cards + carregar mais).
        wp_enqueue_style(
            'andrewp-conquistas-grid',
            get_template_directory_uri() . '/assets/css/content-grid-conquistas.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/assets/css/content-grid-conquistas.css' )
        );

        // CSS do modal "Ver mais" (abas Resumo/Galeria/Documentos/Impacto).
        wp_enqueue_style(
            'andrewp-conquistas-modal',
            get_template_directory_uri() . '/assets/css/modal-conquista.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/assets/css/modal-conquista.css' )
        );

        // Dashicons no front-end: o modal usa vários (globo, local, download
        // etc). No admin já vem carregado por padrão; no front precisa
        // habilitar manualmente.
        wp_enqueue_style( 'dashicons' );

        wp_enqueue_script(
            'andrewp-conquistas-timeline',
            get_template_directory_uri() . '/assets/js/page-timeline-conquistas.js',
            array(),
            filemtime( get_template_directory() . '/assets/js/page-timeline-conquistas.js' ),
            true
        );

        // JS do grid + modal "Ver mais" (carregar mais, abrir/fechar
        // modal via AJAX, trocar de aba).
        wp_enqueue_script(
            'andrewp-conquistas-grid',
            get_template_directory_uri() . '/assets/js/content-grid-conquistas.js',
            array(),
            filemtime( get_template_directory() . '/assets/js/content-grid-conquistas.js' ),
            true
        );

        // Passa a URL do admin-ajax.php e o nonce de segurança pro JS
        // (usado tanto pelo "carregar mais" quanto pela busca do modal).
        wp_localize_script( 'andrewp-conquistas-grid', 'andrewpConquistas', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'andrewp_conquistas_nonce' ),
        ) );
    }

    // CSS da página 404.
    if ( is_404() ) {
        wp_enqueue_style(
            'meu-tema-error-404',
            get_template_directory_uri() . '/assets/css/error-404.min.css',
            array( 'meu-tema-style' ),
            wp_get_theme()->get( 'Version' )
        );
    }
}
add_action( 'wp_enqueue_scripts', 'meu_tema_scripts' );

/**
 * Registra uma área de widgets (sidebar), caso queira usar futuramente.
 */
function meu_tema_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Barra Lateral', 'meu-tema' ),
        'id'            => 'sidebar-1',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'meu_tema_widgets_init' );
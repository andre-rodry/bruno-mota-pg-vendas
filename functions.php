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
 * Configurações básicas do tema.
 */
function meu_tema_setup() {
    // Permite que o WordPress gerencie o <title> automaticamente.
    add_theme_support( 'title-tag' );

    // Habilita imagem destacada (thumbnail) nos posts.
    add_theme_support( 'post-thumbnails' );

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
 * Carrega CSS e JS de forma correta (nunca colocar <link> direto no header.php).
 */
function meu_tema_scripts() {
    // Fontes do Google: Fraunces (títulos), Inter (corpo), IBM Plex Mono (dados/números).
    wp_enqueue_style(
        'meu-tema-fonts',
        'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'meu-tema-style',
        get_stylesheet_uri(),
        array( 'meu-tema-fonts' ),
        wp_get_theme()->get( 'Version' )
    );

    // CSS da página 404 só é carregado quando a página atual for, de fato, uma 404.
    // Aponta pra versão minificada (.min.css) — menor pro visitante baixar.
    // O error-404.css normal continua existindo na pasta só como cópia de edição.
    if ( is_404() ) {
        wp_enqueue_style(
            'meu-tema-error-404',
            get_template_directory_uri() . '/assets/css/error-404.min.css',
            array( 'meu-tema-style' ), // garante que as variáveis do :root já existam
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
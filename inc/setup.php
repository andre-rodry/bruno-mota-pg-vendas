<?php
/**
 * inc/setup.php
 * Configurações básicas do tema: title-tag, thumbnails, logo, menus, sidebar.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function meu_tema_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );

    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 60,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    register_nav_menus( array(
        'primary' => __( 'Menu Principal', 'meu-tema' ),
        'footer'  => __( 'Menu do Rodapé', 'meu-tema' ),
    ) );
}
add_action( 'after_setup_theme', 'meu_tema_setup' );

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
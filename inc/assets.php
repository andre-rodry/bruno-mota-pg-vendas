<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function andrewp_enqueue_assets() {
    wp_enqueue_style( 'andrewp-style', get_stylesheet_uri(), array(), '1.0' );
    wp_enqueue_style( 'andrewp-global', get_template_directory_uri() . '/assets/css/global.css', array(), '1.0' );
    wp_enqueue_style( 'andrewp-loader-css', get_template_directory_uri() . '/assets/css/loader.css', array(), '1.0' );
    wp_enqueue_style( 'andrewp-reveal-scroll-css', get_template_directory_uri() . '/assets/css/reveal-scroll.css', array(), '1.0' );

    if ( is_404() ) {
        wp_enqueue_style( 'andrewp-error-404-css', get_template_directory_uri() . '/error-404/error-404.css', array(), '1.0' );
    }

    if ( is_front_page() ) {
        wp_enqueue_style( 'andrewp-page-hero-css', get_template_directory_uri() . '/home/page-hero.css', array( 'andrewp-global' ), '1.0' );
    }

    wp_enqueue_script( 'andrewp-loader-js', get_template_directory_uri() . '/assets/js/loader.js', array(), '1.0', true );
    wp_enqueue_script( 'andrewp-reveal-scroll-js', get_template_directory_uri() . '/assets/js/reveal-scroll.js', array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'andrewp_enqueue_assets' );
<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function andrewp_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

    register_nav_menus( array(
        'primary' => __( 'Menu Principal', 'andrewp' ),
    ) );
}
add_action( 'after_setup_theme', 'andrewp_theme_setup' );

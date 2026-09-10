<?php
/**
 * functions.php
 * Ponto de entrada do tema — carrega tudo de inc/.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/tracker.php';
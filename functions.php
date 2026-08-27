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
require_once get_template_directory() . '/inc/cpt-trajetoria.php';
require_once get_template_directory() . '/inc/modal-trajetoria.php';
require_once get_template_directory() . '/inc/ajax-trajetoria.php';
require_once get_template_directory() . '/inc/cpt-publicacoes.php';
require_once get_template_directory() . '/inc/modal-publicacao.php';
require_once get_template_directory() . '/inc/ajax-publicacoes.php';
require_once get_template_directory() . '/inc/cpt-entrevistas.php';
require_once get_template_directory() . '/inc/ajax-entrevistas.php';
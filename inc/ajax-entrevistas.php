<?php
/**
 * inc/ajax-entrevistas.php
 *
 * Handler AJAX para os filtros da página de listagem de mídia
 * (midia/content-lista-midia.php) e para o botão "Carregar mais".
 *
 * Reaproveita andrewp_montar_query_entrevistas() e
 * andrewp_render_card_entrevista() já definidas em inc/cpt-entrevistas.php.
 *
 * Inclua em functions.php (depois de cpt-entrevistas.php):
 *   require_once get_template_directory() . '/inc/ajax-entrevistas.php';
 */

if (!defined('ABSPATH')) exit;

function andrewp_ajax_filtrar_entrevistas() {
    check_ajax_referer('andrewp_entrevistas_nonce', 'nonce');

    $tipo    = isset($_POST['tipo'])    ? sanitize_title(wp_unslash($_POST['tipo']))    : 'todas';
    $canal   = isset($_POST['canal'])   ? sanitize_title(wp_unslash($_POST['canal']))   : 'todos';
    $ano     = isset($_POST['ano'])     ? sanitize_text_field(wp_unslash($_POST['ano'])): 'todas';
    $orderby = isset($_POST['orderby']) ? sanitize_text_field(wp_unslash($_POST['orderby'])) : 'recentes';
    $paged   = isset($_POST['paged'])   ? max(1, (int) $_POST['paged']) : 1;

    if (!function_exists('andrewp_montar_query_entrevistas') || !function_exists('andrewp_render_card_entrevista')) {
        wp_send_json_error(['message' => 'CPT de entrevistas não carregado.'], 500);
    }

    $query = andrewp_montar_query_entrevistas([
        'tipo'    => $tipo,
        'canal'   => $canal,
        'ano'     => $ano,
        'orderby' => $orderby,
        'paged'   => $paged,
    ]);

    $html = '';
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $html .= andrewp_render_card_entrevista(get_post());
        }
        wp_reset_postdata();
    }

    wp_send_json_success([
        'html'        => $html,
        'has_more'    => $paged < (int) $query->max_num_pages,
        'next_page'   => $paged + 1,
        'found_posts' => (int) $query->found_posts,
    ]);
}
add_action('wp_ajax_andrewp_filtrar_entrevistas', 'andrewp_ajax_filtrar_entrevistas');
add_action('wp_ajax_nopriv_andrewp_filtrar_entrevistas', 'andrewp_ajax_filtrar_entrevistas');
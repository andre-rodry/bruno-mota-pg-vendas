<?php
/**
 * inc/cpt-entrevistas.php
 *
 * CPT: Entrevistas (TV / Rádio / Podcasts / Imprensa)
 * Nome "entrevistas" porque "mídia" já existe como item no menu do WP admin.
 *
 * Inclua em functions.php:
 *   require_once get_template_directory() . '/inc/cpt-entrevistas.php';
 */

if (!defined('ABSPATH')) exit;

/* =========================================================
   1) CUSTOM POST TYPE
   ========================================================= */
function andrewp_cpt_entrevistas() {
    $labels = [
        'name'               => 'Entrevistas',
        'singular_name'      => 'Entrevista',
        'menu_name'          => 'Entrevistas',
        'add_new'            => 'Adicionar nova',
        'add_new_item'       => 'Adicionar nova entrevista',
        'edit_item'          => 'Editar entrevista',
        'new_item'           => 'Nova entrevista',
        'view_item'          => 'Ver entrevista',
        'search_items'       => 'Buscar entrevistas',
        'not_found'          => 'Nenhuma entrevista encontrada',
        'not_found_in_trash' => 'Nenhuma entrevista na lixeira',
    ];

    register_post_type('entrevista', [
        'labels'        => $labels,
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-microphone',
        'menu_position' => 21,
        'supports'      => ['title', 'editor', 'excerpt', 'thumbnail'],
        'has_archive'   => false,
        'rewrite'       => ['slug' => 'entrevistas'],
        'show_in_rest'  => true,
    ]);
}
add_action('init', 'andrewp_cpt_entrevistas');

/* =========================================================
   2) TAXONOMIA: Tipo (aba de cima -> TV / Rádio / Podcasts / Imprensa)
   ========================================================= */
function andrewp_tax_tipo_entrevista() {
    register_taxonomy('tipo_entrevista', 'entrevista', [
        'labels' => [
            'name'          => 'Tipos',
            'singular_name' => 'Tipo',
        ],
        'hierarchical'      => true,
        'public'            => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'tipo-entrevista'],
    ]);
}
add_action('init', 'andrewp_tax_tipo_entrevista');

/* =========================================================
   3) TAXONOMIA: Canal (sidebar -> Globo, SBT, TV Aratu...)
      O slug do termo = a classe CSS (.lm-card__logo--{slug})
   ========================================================= */
function andrewp_tax_canal_entrevista() {
    register_taxonomy('canal_entrevista', 'entrevista', [
        'labels' => [
            'name'          => 'Canais',
            'singular_name' => 'Canal',
        ],
        'hierarchical'      => true,
        'public'            => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'canal-entrevista'],
    ]);
}
add_action('init', 'andrewp_tax_canal_entrevista');

/* =========================================================
   4) Cria os termos padrão automaticamente (roda 1x só)
   ========================================================= */
function andrewp_criar_termos_padrao_entrevistas() {
    // v5: só bumpei a versão pra forçar essa sincronização a rodar de novo,
    // porque "Band" mudou pra "TV Band" DEPOIS que a v4 já tinha rodado
    // (e a v4 não roda 2x sozinha).
    if (get_option('andrewp_termos_entrevistas_criados_v5')) return;

    $tipos = ['tv' => 'TV', 'radio' => 'Rádio', 'podcasts' => 'Podcasts', 'imprensa' => 'Imprensa'];
    foreach ($tipos as $slug => $nome) {
        if (!term_exists($slug, 'tipo_entrevista')) {
            wp_insert_term($nome, 'tipo_entrevista', ['slug' => $slug]);
        }
    }

    // Esta é a lista final e única de canais. Slug precisa bater com o CSS
    // (.lm-card__logo--globo etc.). Qualquer canal fora desta lista será apagado.
    $canais = [
        'globo'                        => 'TV Globo',
        'sbt'                          => 'SBT',
        'tv-aratu'                     => 'TV Aratu',
        'band'                         => 'TV Band',
        'tv-resistencia-contemporanea' => 'TV Resistência Contemporânea',
        'batv'                         => 'BATV',
        'tve-bahia'                    => 'TVE Bahia',
        'radio-sociedade-news'         => 'Rádio Sociedade News',
    ];

    // 1) e 2): cria ou renomeia
    foreach ($canais as $slug => $nome) {
        $termo = term_exists($slug, 'canal_entrevista');
        if (!$termo) {
            wp_insert_term($nome, 'canal_entrevista', ['slug' => $slug]);
        } else {
            $termo_atual = get_term($termo['term_id'], 'canal_entrevista');
            if ($termo_atual && $termo_atual->name !== $nome) {
                wp_update_term($termo['term_id'], 'canal_entrevista', ['name' => $nome]);
            }
        }
    }

    // 3): apaga qualquer canal que não esteja na lista acima
    $slugs_permitidos = array_keys($canais);
    $termos_existentes = get_terms([
        'taxonomy'   => 'canal_entrevista',
        'hide_empty' => false,
    ]);
    if (!is_wp_error($termos_existentes)) {
        foreach ($termos_existentes as $termo_existente) {
            if (!in_array($termo_existente->slug, $slugs_permitidos, true)) {
                wp_delete_term($termo_existente->term_id, 'canal_entrevista');
            }
        }
    }

    update_option('andrewp_termos_entrevistas_criados_v5', 1);
}
add_action('init', 'andrewp_criar_termos_padrao_entrevistas', 20);

/* =========================================================
   5) META BOX: destaque / duração / link / em destaque
   ========================================================= */
function andrewp_metabox_entrevista() {
    add_meta_box(
        'andrewp_entrevista_detalhes',
        'Detalhes da entrevista',
        'andrewp_metabox_entrevista_html',
        'entrevista',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'andrewp_metabox_entrevista');

function andrewp_metabox_entrevista_html($post) {
    wp_nonce_field('andrewp_entrevista_save', 'andrewp_entrevista_nonce');

    $destaque      = get_post_meta($post->ID, '_destaque', true);
    $duracao       = get_post_meta($post->ID, '_duracao', true);
    $link_assistir = get_post_meta($post->ID, '_link_assistir', true);
    $em_destaque   = get_post_meta($post->ID, '_em_destaque', true);
    ?>
    <p>
        <label for="andrewp_destaque"><strong>Destaque (linha em dourado)</strong></label><br>
        <input type="text" id="andrewp_destaque" name="andrewp_destaque"
               value="<?php echo esc_attr($destaque); ?>" style="width:100%;"
               placeholder="Ex: Perspectivas econômicas para 2025">
    </p>
    <p>
        <label for="andrewp_duracao"><strong>Duração</strong></label><br>
        <input type="text" id="andrewp_duracao" name="andrewp_duracao"
               value="<?php echo esc_attr($duracao); ?>" placeholder="Ex: 32 min">
    </p>
    <p>
        <label for="andrewp_link_assistir"><strong>Link para assistir/ouvir</strong></label><br>
        <input type="url" id="andrewp_link_assistir" name="andrewp_link_assistir"
               value="<?php echo esc_attr($link_assistir); ?>" style="width:100%;"
               placeholder="https://...">
    </p>
    <p>
        <label>
            <input type="checkbox" name="andrewp_em_destaque" value="1" <?php checked($em_destaque, '1'); ?>>
            <strong>Mostrar no bloco "EM DESTAQUE" da sidebar</strong>
        </label>
    </p>
    <p style="color:#666;">
        Use o <em>resumo</em> (excerpt, na coluna direita do editor) como a descrição do card.
        Canal e Tipo (TV/Rádio/Podcasts/Imprensa) ficam nas caixas de taxonomia à direita.
        A imagem destacada (featured image) é usada na thumb do bloco "EM DESTAQUE".
    </p>
    <?php
}

function andrewp_salvar_metabox_entrevista($post_id) {
    if (!isset($_POST['andrewp_entrevista_nonce']) ||
        !wp_verify_nonce($_POST['andrewp_entrevista_nonce'], 'andrewp_entrevista_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $campos = [
        'andrewp_destaque'      => '_destaque',
        'andrewp_duracao'       => '_duracao',
        'andrewp_link_assistir' => '_link_assistir',
    ];
    foreach ($campos as $campo => $meta_key) {
        if (isset($_POST[$campo])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$campo]));
        }
    }

    update_post_meta($post_id, '_em_destaque', isset($_POST['andrewp_em_destaque']) ? '1' : '0');
}
add_action('save_post_entrevista', 'andrewp_salvar_metabox_entrevista');

/* =========================================================
   6) HELPERS: data formatada, render do card, query com filtros
   ========================================================= */
function andrewp_formatar_data_ptbr($post_id) {
    $meses = [
        '01' => 'janeiro', '02' => 'fevereiro', '03' => 'março', '04' => 'abril',
        '05' => 'maio', '06' => 'junho', '07' => 'julho', '08' => 'agosto',
        '09' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro',
    ];
    $d = get_post_time('d', false, $post_id);
    $m = get_post_time('m', false, $post_id);
    $y = get_post_time('Y', false, $post_id);
    return $d . ' de ' . $meses[$m] . ' de ' . $y;
}

function andrewp_render_card_entrevista($post) {
    $post_id = $post->ID;

    $canal_terms = get_the_terms($post_id, 'canal_entrevista');
    $canal_nome  = ($canal_terms && !is_wp_error($canal_terms)) ? $canal_terms[0]->name : '';
    // Fallback só entra em ação se uma entrevista for publicada sem canal
    // selecionado (não corresponde a nenhum termo real da taxonomia).
    $canal_slug  = ($canal_terms && !is_wp_error($canal_terms)) ? $canal_terms[0]->slug : 'sem-canal';

    $destaque       = get_post_meta($post_id, '_destaque', true);
    $duracao        = get_post_meta($post_id, '_duracao', true);
    $link_assistir  = get_post_meta($post_id, '_link_assistir', true);
    $descricao      = get_the_excerpt($post);
    $data_formatada = andrewp_formatar_data_ptbr($post_id);

    ob_start();
    ?>
    <li class="lm-card">
        <div class="lm-card__logo lm-card__logo--<?php echo esc_attr($canal_slug); ?>">
            <?php echo esc_html($canal_nome); ?>
        </div>

        <div class="lm-card__info">
            <h3 class="lm-card__titulo"><?php echo esc_html(get_the_title($post)); ?></h3>
            <?php if ($destaque) : ?>
                <p class="lm-card__destaque"><?php echo esc_html($destaque); ?></p>
            <?php endif; ?>
            <p class="lm-card__descricao"><?php echo esc_html($descricao); ?></p>
        </div>

        <div class="lm-card__meta">
            <span class="lm-meta__linha">
                <span class="lm-icon-calendar" aria-hidden="true"></span>
                <?php echo esc_html($data_formatada); ?>
            </span>
            <?php if ($duracao) : ?>
                <span class="lm-meta__linha">
                    <span class="lm-icon-clock" aria-hidden="true"></span>
                    <?php echo esc_html($duracao); ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="lm-card__acao">
            <a href="<?php echo esc_url($link_assistir ?: '#'); ?>" class="lm-btn-play" target="_blank" rel="noopener">
                <span class="lm-icon-play" aria-hidden="true"></span>
                ASSISTIR
            </a>
        </div>
    </li>
    <?php
    return ob_get_clean();
}

/**
 * Retorna os anos (desc) que possuem entrevistas publicadas.
 */
function andrewp_get_anos_entrevistas() {
    global $wpdb;
    $anos = $wpdb->get_col("
        SELECT DISTINCT YEAR(post_date) FROM {$wpdb->posts}
        WHERE post_type = 'entrevista' AND post_status = 'publish'
        ORDER BY post_date DESC
    ");
    return array_map('intval', $anos);
}

/**
 * Monta a WP_Query com os filtros vindos da UI (tabs, canal, ano, ordenação).
 */
function andrewp_montar_query_entrevistas($args = []) {
    $defaults = [
        'tipo'       => 'todas',
        'canal'      => 'todos',
        'ano'        => 'todas',   // 'todas' | ano numérico (string) | 'antigas'
        'orderby'    => 'recentes', // 'recentes' | 'antigas'
        'paged'      => 1,
        'por_pagina' => 4,
    ];
    $args = wp_parse_args($args, $defaults);

    $query_args = [
        'post_type'      => 'entrevista',
        'post_status'    => 'publish',
        'posts_per_page' => (int) $args['por_pagina'],
        'paged'          => max(1, (int) $args['paged']),
        'orderby'        => 'date',
        'order'          => $args['orderby'] === 'antigas' ? 'ASC' : 'DESC',
    ];

    $tax_query = [];
    if (!empty($args['tipo']) && $args['tipo'] !== 'todas') {
        $tax_query[] = [
            'taxonomy' => 'tipo_entrevista',
            'field'    => 'slug',
            'terms'    => $args['tipo'],
        ];
    }
    if (!empty($args['canal']) && $args['canal'] !== 'todos') {
        $tax_query[] = [
            'taxonomy' => 'canal_entrevista',
            'field'    => 'slug',
            'terms'    => $args['canal'],
        ];
    }
    if ($tax_query) {
        $query_args['tax_query'] = $tax_query;
    }

    if (!empty($args['ano']) && $args['ano'] !== 'todas') {
        if ($args['ano'] === 'antigas') {
            $anos_recentes = array_slice(andrewp_get_anos_entrevistas(), 0, 3);
            if ($anos_recentes) {
                $query_args['date_query'] = [
                    ['column' => 'post_date', 'before' => (min($anos_recentes) . '-01-01')],
                ];
            }
        } else {
            $query_args['date_query'] = [
                ['year' => (int) $args['ano']],
            ];
        }
    }

    return new WP_Query($query_args);
}
<?php
/**
 * content-lista-midia.php
 * Conteúdo da página de listagem de mídia (TV / Rádio / Podcasts / Imprensa).
 * Dados reais via CPT "entrevista" (inc/cpt-entrevistas.php).
 * Filtros (tipo, ano, canal, ordenação) e "carregar mais" funcionam via
 * AJAX, sem recarregar a página (ver midia/page-listas-midia.js).
 */

if (!defined('ABSPATH')) exit;

/* ---------- Estado inicial (permite abrir a página já filtrada via URL) ---------- */
$tipo_atual    = isset($_GET['tipo'])    ? sanitize_title(wp_unslash($_GET['tipo']))     : 'todas';
$canal_atual   = isset($_GET['canal'])   ? sanitize_title(wp_unslash($_GET['canal']))    : 'todos';
$ano_atual     = isset($_GET['ano'])     ? sanitize_text_field(wp_unslash($_GET['ano'])) : 'todas';
$orderby_atual = isset($_GET['orderby']) ? sanitize_text_field(wp_unslash($_GET['orderby'])) : 'recentes';

$por_pagina = 4;

/* ---------- Conteúdo do hero por tipo (trocado via JS ao clicar nas abas) ---------- */
$hero_por_tipo = [
    'todas' => [
        'icone'     => 'camera',
        'titulo'    => 'Mídia',
        'subtitulo' => 'Entrevistas e participações',
        'desc'      => 'Participações em TV, rádio, podcasts e imprensa com análises sobre economia, política e desenvolvimento regional.',
    ],
    'tv' => [
        'icone'     => 'tv',
        'titulo'    => 'TV',
        'subtitulo' => 'Entrevistas e participações',
        'desc'      => 'Assista às participações em canais de TV, análises e comentários sobre economia, política e desenvolvimento regional.',
    ],
    'radio' => [
        'icone'     => 'radio',
        'titulo'    => 'Rádio',
        'subtitulo' => 'Entrevistas e participações',
        'desc'      => 'Ouça as participações em programas de rádio, com análises sobre economia, política e desenvolvimento regional.',
    ],
    'podcasts' => [
        'icone'     => 'podcast',
        'titulo'    => 'Podcasts',
        'subtitulo' => 'Entrevistas e participações',
        'desc'      => 'Confira as participações em podcasts, com discussões aprofundadas sobre economia, política e desenvolvimento regional.',
    ],
    'imprensa' => [
        'icone'     => 'imprensa',
        'titulo'    => 'Imprensa',
        'subtitulo' => 'Entrevistas e participações',
        'desc'      => 'Veja citações e matérias na imprensa escrita sobre economia, política e desenvolvimento regional.',
    ],
];
$hero_atual = isset($hero_por_tipo[$tipo_atual]) ? $hero_por_tipo[$tipo_atual] : $hero_por_tipo['todas'];

/* ---------- Abas de tipo (TODAS + taxonomia tipo_entrevista) ---------- */
$ordem_tipos = ['tv', 'radio', 'podcasts', 'imprensa'];
$tipos_terms = get_terms([
    'taxonomy'   => 'tipo_entrevista',
    'hide_empty' => false,
]);
if (is_wp_error($tipos_terms)) {
    $tipos_terms = [];
}
usort($tipos_terms, function ($a, $b) use ($ordem_tipos) {
    $pos_a = array_search($a->slug, $ordem_tipos);
    $pos_b = array_search($b->slug, $ordem_tipos);
    $pos_a = $pos_a === false ? 999 : $pos_a;
    $pos_b = $pos_b === false ? 999 : $pos_b;
    return $pos_a <=> $pos_b;
});

/* ---------- Anos disponíveis (abas da barra de filtro) ---------- */
$anos_disponiveis = function_exists('andrewp_get_anos_entrevistas') ? andrewp_get_anos_entrevistas() : [];

/* ---------- Canais (sidebar) ---------- */
$canais_terms = get_terms([
    'taxonomy'   => 'canal_entrevista',
    'hide_empty' => false,
]);
if (is_wp_error($canais_terms)) {
    $canais_terms = [];
}

/* ---------- Query inicial (1ª página já renderizada no servidor) ---------- */
$query_inicial = function_exists('andrewp_montar_query_entrevistas')
    ? andrewp_montar_query_entrevistas([
        'tipo'       => $tipo_atual,
        'canal'      => $canal_atual,
        'ano'        => $ano_atual,
        'orderby'    => $orderby_atual,
        'paged'      => 1,
        'por_pagina' => $por_pagina,
    ])
    : new WP_Query(['post_type' => 'entrevista', 'posts_per_page' => 0]);

$tem_mais_paginas = $query_inicial->max_num_pages > 1;

/* ---------- Entrevista em destaque (sidebar) ---------- */
$destaque_query = new WP_Query([
    'post_type'      => 'entrevista',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'meta_key'       => '_em_destaque',
    'meta_value'     => '1',
]);
if (!$destaque_query->have_posts()) {
    $destaque_query = new WP_Query([
        'post_type'      => 'entrevista',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
}
$post_destaque = $destaque_query->have_posts() ? $destaque_query->posts[0] : null;
?>

<div class="lista-midia"
     data-tipo="<?php echo esc_attr($tipo_atual); ?>"
     data-canal="<?php echo esc_attr($canal_atual); ?>"
     data-ano="<?php echo esc_attr($ano_atual); ?>"
     data-orderby="<?php echo esc_attr($orderby_atual); ?>"
     data-next-page="<?php echo $tem_mais_paginas ? 2 : 1; ?>"
     data-has-more="<?php echo $tem_mais_paginas ? 'true' : 'false'; ?>">
<div class="lm-page">

    <!-- ===================== NAVEGAÇÃO SUPERIOR ===================== -->
    <div class="lm-topnav">
        <nav class="lm-topnav__tabs">
            <a href="#" class="lm-topnav__tab <?php echo $tipo_atual === 'todas' ? 'is-active' : ''; ?>"
               data-tipo="todas"
               data-hero-icon="<?php echo esc_attr($hero_por_tipo['todas']['icone']); ?>"
               data-hero-title="<?php echo esc_attr($hero_por_tipo['todas']['titulo']); ?>"
               data-hero-subtitle="<?php echo esc_attr($hero_por_tipo['todas']['subtitulo']); ?>"
               data-hero-desc="<?php echo esc_attr($hero_por_tipo['todas']['desc']); ?>">
                <span class="lm-icon-camera" aria-hidden="true"></span>
                TODAS
            </a>
            <?php foreach ($tipos_terms as $termo) :
                $hero_termo = isset($hero_por_tipo[$termo->slug]) ? $hero_por_tipo[$termo->slug] : $hero_por_tipo['todas'];
                ?>
                <a href="#" class="lm-topnav__tab <?php echo $tipo_atual === $termo->slug ? 'is-active' : ''; ?>"
                   data-tipo="<?php echo esc_attr($termo->slug); ?>"
                   data-hero-icon="<?php echo esc_attr($hero_termo['icone']); ?>"
                   data-hero-title="<?php echo esc_attr($hero_termo['titulo']); ?>"
                   data-hero-subtitle="<?php echo esc_attr($hero_termo['subtitulo']); ?>"
                   data-hero-desc="<?php echo esc_attr($hero_termo['desc']); ?>">
                    <span class="lm-icon-<?php echo esc_attr($hero_termo['icone']); ?>" aria-hidden="true"></span>
                    <?php echo esc_html(mb_strtoupper($termo->name)); ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="lm-topnav__sort">
            <span class="lm-sort__label">ORDENAR POR</span>
            <div class="lm-select">
                <span><?php echo $orderby_atual === 'antigas' ? 'Mais antigas' : 'Mais recentes'; ?></span>
                <span class="lm-select__arrow" aria-hidden="true">&#9662;</span>
                <div class="lm-select__menu">
                    <div class="lm-select__option <?php echo $orderby_atual !== 'antigas' ? 'is-active' : ''; ?>" data-orderby="recentes">Mais recentes</div>
                    <div class="lm-select__option <?php echo $orderby_atual === 'antigas' ? 'is-active' : ''; ?>" data-orderby="antigas">Mais antigas</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== HERO ===================== -->
    <div class="lm-hero">
        <div class="lm-hero__bg" aria-hidden="true">
            <img
                src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/midia/midia-hero-bg.webp'); ?>"
                alt=""
                class="lm-hero__img"
            >
        </div>
        <div class="lm-hero__content">
            <h1 class="lm-hero__title">
                <span class="lm-icon-<?php echo esc_attr($hero_atual['icone']); ?> lm-icon-tv--lg" aria-hidden="true"></span>
                <?php echo esc_html($hero_atual['titulo']); ?>
            </h1>
            <h2 class="lm-hero__subtitle"><?php echo esc_html($hero_atual['subtitulo']); ?></h2>
            <p class="lm-hero__desc"><?php echo esc_html($hero_atual['desc']); ?></p>
        </div>
    </div>

    <!-- ===================== CORPO: LISTA + SIDEBAR ===================== -->
    <div class="lm-body">

        <!-- ---------- COLUNA PRINCIPAL ---------- -->
        <div class="lm-main">

            <div class="lm-filterbar">
                <div class="lm-yeartabs">
                    <a href="#" class="lm-yeartabs__tab <?php echo $ano_atual === 'todas' ? 'is-active' : ''; ?>" data-ano="todas">TODAS</a>
                    <?php foreach ($anos_disponiveis as $ano) : ?>
                        <a href="#" class="lm-yeartabs__tab <?php echo $ano_atual === (string) $ano ? 'is-active' : ''; ?>" data-ano="<?php echo esc_attr($ano); ?>">
                            <?php echo esc_html($ano); ?>
                        </a>
                    <?php endforeach; ?>
                    <a href="#" class="lm-yeartabs__tab <?php echo $ano_atual === 'antigas' ? 'is-active' : ''; ?>" data-ano="antigas">MAIS ANTIGAS</a>
                </div>

                <div class="lm-filterbar__sort">
                    <span class="lm-sort__label">ORDENAR POR</span>
                    <div class="lm-select">
                        <span><?php echo $orderby_atual === 'antigas' ? 'Mais antigas' : 'Mais recentes'; ?></span>
                        <span class="lm-select__arrow" aria-hidden="true">&#9662;</span>
                        <div class="lm-select__menu">
                            <div class="lm-select__option <?php echo $orderby_atual !== 'antigas' ? 'is-active' : ''; ?>" data-orderby="recentes">Mais recentes</div>
                            <div class="lm-select__option <?php echo $orderby_atual === 'antigas' ? 'is-active' : ''; ?>" data-orderby="antigas">Mais antigas</div>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="lm-list">
                <?php if ($query_inicial->have_posts()) : ?>
                    <?php while ($query_inicial->have_posts()) : $query_inicial->the_post(); ?>
                        <?php echo andrewp_render_card_entrevista(get_post()); ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php else : ?>
                    <li class="lm-empty">Nenhuma entrevista encontrada para esse filtro.</li>
                <?php endif; ?>
            </ul>

            <div class="lm-loadmore" <?php echo $tem_mais_paginas ? '' : 'style="display:none;"'; ?>>
                <a href="#" class="lm-btn-outline">
                    CARREGAR MAIS
                    <span class="lm-icon-loading" aria-hidden="true"></span>
                </a>
            </div>

        </div>

        <!-- ---------- SIDEBAR ---------- -->
        <aside class="lm-sidebar">

            <div class="lm-sidebar__box">
                <h4 class="lm-sidebar__title">FILTRAR POR CANAL</h4>
                <ul class="lm-radiolist">
                    <li class="lm-radiolist__item" data-canal="todos">
                        <label>
                            <span class="lm-radio <?php echo $canal_atual === 'todos' ? 'is-checked' : ''; ?>" aria-hidden="true"></span>
                            Todos os canais
                        </label>
                    </li>
                    <?php foreach ($canais_terms as $canal) : ?>
                        <li class="lm-radiolist__item" data-canal="<?php echo esc_attr($canal->slug); ?>">
                            <label>
                                <span class="lm-radio <?php echo $canal_atual === $canal->slug ? 'is-checked' : ''; ?>" aria-hidden="true"></span>
                                <?php echo esc_html($canal->name); ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php if ($post_destaque) :
                $destaque_titulo   = get_post_meta($post_destaque->ID, '_destaque', true) ?: get_the_title($post_destaque);
                $destaque_canal_tm = get_the_terms($post_destaque->ID, 'canal_entrevista');
                $destaque_canal    = ($destaque_canal_tm && !is_wp_error($destaque_canal_tm)) ? $destaque_canal_tm[0]->name : get_the_title($post_destaque);
                $destaque_link     = get_post_meta($post_destaque->ID, '_link_assistir', true) ?: get_permalink($post_destaque);
                $destaque_thumb    = get_the_post_thumbnail_url($post_destaque, 'medium') ?: (get_template_directory_uri() . '/assets/img/midia/midia-hero-bg.webp');
                ?>
                <div class="lm-sidebar__box lm-destaque">
                    <h4 class="lm-sidebar__title">
                        EM <span class="lm-destaque__accent">DESTAQUE</span>
                    </h4>
                    <a class="lm-destaque__card" href="<?php echo esc_url($destaque_link); ?>" target="_blank" rel="noopener">
                        <div class="lm-destaque__thumb">
                            <img src="<?php echo esc_url($destaque_thumb); ?>" alt="" class="lm-destaque__img">
                            <span class="lm-destaque__play" aria-hidden="true">
                                <span class="lm-icon-play" aria-hidden="true"></span>
                            </span>
                        </div>
                        <p class="lm-destaque__titulo"><?php echo esc_html($destaque_titulo); ?></p>
                        <p class="lm-destaque__canal"><?php echo esc_html($destaque_canal); ?></p>
                    </a>
                </div>
            <?php endif; ?>

        </aside>

    </div>

</div>
</div>
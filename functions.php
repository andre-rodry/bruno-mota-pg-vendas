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

    // CSS do header: carrega em TODAS as páginas, logo depois do style.css principal.
    // Usa filemtime() em vez da versão do tema: assim, toda vez que você editar
    // o header.css, o navegador é obrigado a baixar a versão nova (sem cache antigo).
    wp_enqueue_style(
        'meu-tema-header',
        get_template_directory_uri() . '/assets/css/header.css',
        array( 'meu-tema-style' ), // garante que as variáveis do :root já existam
        filemtime( get_template_directory() . '/assets/css/header.css' )
    );

    // JS do header: controla o efeito de scroll e o menu mobile.
    // in_footer = true: carrega perto do </body>, sem travar a renderização da página.
    wp_enqueue_script(
        'meu-tema-header',
        get_template_directory_uri() . '/assets/js/header.js',
        array(), // sem dependências (jQuery não é necessário)
        filemtime( get_template_directory() . '/assets/js/header.js' ),
        true
    );

    // Font Awesome (ícones das redes sociais) — usado no header e no footer,
    // por isso carrega em TODAS as páginas, fora do bloco is_front_page().
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );

    // ---- LOADER GLOBAL ----
    // Vive no header.php e aparece em TODAS as páginas (a decisão de mostrar
    // ou não — só em F5/refresh — é feita via JS, inline no header.php).
    // Por isso o CSS carrega global, sem condicional is_front_page()/is_page().
    wp_enqueue_style(
        'andrewp-loader',
        get_template_directory_uri() . '/assets/css/loader.css',
        array( 'meu-tema-fonts', 'meu-tema-style' ),
        filemtime( get_template_directory() . '/assets/css/loader.css' )
    );

    // CSS do footer: carrega em TODAS as páginas, já que o footer aparece
    // no site inteiro (não só na home).
    wp_enqueue_style(
        'andrewp-footer',
        get_template_directory_uri() . '/assets/css/footer.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/assets/css/footer.css' )
    );

    // ---- ANIMAÇÃO DE SCROLL (reveal-scroll) ----
    // CSS/JS nativo, sem biblioteca externa (sem ScrollReveal, sem CDN de terceiros).
    // Usa IntersectionObserver do próprio navegador. Carrega em TODAS as páginas,
    // já que a classe "reveal" pode ser usada em qualquer seção/template do site.
    wp_enqueue_style(
        'meu-tema-reveal-scroll',
        get_template_directory_uri() . '/assets/css/reveal-scroll.css',
        array( 'meu-tema-style' ),
        filemtime( get_template_directory() . '/assets/css/reveal-scroll.css' )
    );

    wp_enqueue_script(
        'meu-tema-reveal-scroll',
        get_template_directory_uri() . '/assets/js/reveal-scroll.js',
        array(), // sem dependências (JS puro)
        filemtime( get_template_directory() . '/assets/js/reveal-scroll.js' ),
        true // carrega no rodapé
    );

    // ---- SEÇÕES DA HOME ----
    // Só carrega o CSS/JS dessas seções quando a página atual for a home,
    // já que elas só são usadas no front-page.php.
    //
    // IMPORTANTE: tanto o CSS quanto o JS de todas as seções (banner,
    // último artigo, stats, about, mídia, instituições, galeria,
    // publicações) foram CONSOLIDADOS em um único arquivo cada:
    //   /assets/css/home.css
    //   /assets/js/home.js
    // Os arquivos separados (banner.css/js, latest-article.css, stats.css,
    // about.css, media.css/js, institutions.css, gallery.css/js,
    // publications.css/js) não existem mais no disco — por isso os
    // wp_enqueue_style()/wp_enqueue_script() individuais de cada um foram
    // substituídos pelas duas chamadas únicas abaixo.
    if ( is_front_page() ) {

        // ---- CSS consolidado de todas as seções da home ----
        wp_enqueue_style(
            'meu-tema-home',
            get_template_directory_uri() . '/assets/css/home.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/assets/css/home.css' )
        );

        // ---- JS consolidado de todas as seções da home ----
        // (banner, participações na mídia, galeria de momentos e
        // publicações/artigos — tudo dentro de home.js, cada bloco
        // mantendo seu próprio IIFE original)
        wp_enqueue_script(
            'meu-tema-home',
            get_template_directory_uri() . '/assets/js/home.js',
            array(), // sem dependências
            filemtime( get_template_directory() . '/assets/js/home.js' ),
            true
        );

        // Passa a URL da REST API do site ATUAL para o JS (evita hardcode de domínio,
        // essencial porque o WordPress está instalado numa subpasta: /andre-wp/)
        // Precisa ficar vinculado ao handle 'meu-tema-home' agora, já que o
        // bloco de Publicações passou a viver dentro de home.js.
        wp_localize_script( 'meu-tema-home', 'publicationsData', array(
            'restUrl' => esc_url_raw( rest_url( 'wp/v2/' ) ),
        ) );
    }

   // ---- PÁGINA SOBRE ----
    // Carrega o CSS da página "Sobre" (template-parts/content-sobre.php)
    // só quando a página atual for a Página cujo slug é "sobre".
    // is_front_page() não cobre esse caso porque /sobre/ é uma página separada,
    // não a home — por isso esse bloco precisa existir independente do de cima.
    if ( is_page( 'sobre' ) ) {
        wp_enqueue_style(
            'andrewp-page-sobre',
            get_template_directory_uri() . '/assets/css/page-sobre.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/assets/css/page-sobre.css' )
        );

        // Header só aparece ao rolar a página (só nesta página, "Sobre")
        wp_enqueue_script(
            'andrewp-header-scroll',
            get_template_directory_uri() . '/assets/js/header-scroll.js',
            array( 'meu-tema-header' ), // carrega DEPOIS do header.js
            filemtime( get_template_directory() . '/assets/js/header-scroll.js' ),
            true
        );
    }

    // ---- PÁGINA ATUAÇÃO ----
    // Carrega o CSS da página "Atuação" (page-atuacao.php, na raiz do tema).
    // Esse arquivo é pego automaticamente pela hierarquia de templates do
    // WordPress (page-{slug}.php), igual ao page-sobre.php — por isso o
    // check correto é is_page('atuacao'), e não is_page_template(), que só
    // funciona quando o modelo é selecionado manualmente via Template Name.
    if ( is_page( 'atuacao' ) ) {
        wp_enqueue_style(
            'andrewp-atuacao',
            get_template_directory_uri() . '/assets/css/page-atuacao.css',
            array( 'meu-tema-style' ),
            filemtime( get_template_directory() . '/assets/css/page-atuacao.css' )
        );

        // Header só aparece ao rolar a página (também na página "Atuação")
    wp_enqueue_script(
        'andrewp-header-scroll',
        get_template_directory_uri() . '/assets/js/header-scroll.js',
        array( 'meu-tema-header' ),
        filemtime( get_template_directory() . '/assets/js/header-scroll.js' ),
        true
    );
    }

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
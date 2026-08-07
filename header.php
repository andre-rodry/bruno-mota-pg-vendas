<?php
/**
 * header.php
 * Cabeçalho do site — logo, menu principal e botão de contato.
 * Estilos em assets/css/header.css e interatividade em assets/js/header.js
 *
 * O loader de entrada (#bm-loader) fica aqui, global (todas as páginas),
 * mas só é exibido quando a página foi carregada por um F5/refresh —
 * nunca quando o usuário navega clicando em um link do site.
 * Detecção via Navigation Timing API (window.performance).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- LOADER GLOBAL — só aparece quando a página é recarregada (F5), não ao navegar -->
<div id="bm-loader" style="display:none;">
    <div class="bm-loader-inner">
        <span class="bm-loader-logo">BM</span>
        <div class="bm-loader-sub">Bruno Mota · Economista</div>
        <div class="bm-loader-bar"></div>
    </div>
</div>
<script>
(function () {
    'use strict';

    var loader = document.getElementById('bm-loader');
    if (!loader) return;

    function getNavType() {
        try {
            if ( window.performance && typeof window.performance.getEntriesByType === 'function' ) {
                var entries = window.performance.getEntriesByType('navigation');
                if ( entries && entries.length && entries[0].type ) {
                    return entries[0].type; // 'navigate' | 'reload' | 'back_forward' | 'prerender'
                }
            }
            // Fallback para navegadores mais antigos (API deprecated, mas ainda suportada)
            if ( window.performance && window.performance.navigation ) {
                var t = window.performance.navigation.type;
                if ( t === 1 ) return 'reload';
                if ( t === 2 ) return 'back_forward';
                return 'navigate';
            }
        } catch (e) {}
        return 'navigate';
    }

    function isEnteringSite() {
        try {
            if ( ! document.referrer ) {
                return true; // sem referrer: URL digitada, favorito, aba nova, app externo
            }
            var refHost = new URL( document.referrer ).hostname;
            return refHost !== window.location.hostname; // veio de outro domínio (Google, link externo etc.)
        } catch (e) {
            return true;
        }
    }

    var navType = getNavType();
    var isReload = navType === 'reload';

    // Mostra o loader se: foi um F5/refresh, OU se a pessoa está entrando
    // no site agora (não veio navegando de outra página do próprio site).
    var shouldShow = isReload || ( navType === 'navigate' && isEnteringSite() );

    if ( ! shouldShow ) {
        // Navegação normal dentro do site (clicou num link interno) — não mostra.
        return;
    }

    // É um refresh de verdade — mostra o loader.
    loader.style.display = '';
    document.body.classList.add('bm-loading');

    function hideLoader() {
        loader.classList.add('is-hidden');
        document.body.classList.remove('bm-loading');
    }

    window.addEventListener('load', function () {
        setTimeout(hideLoader, 1400);
    });

    // Fallback: força esconder após 2.2s, caso o `load` demore demais
    setTimeout(function () {
        if (!loader.classList.contains('is-hidden')) {
            hideLoader();
        }
    }, 2200);
})();
</script>

<header id="site-header" class="site-header">
    <div class="site-header__inner">

        <!-- LOGO -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo" aria-label="Bruno Mota - Página inicial">
            <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <span class="site-header__logo-mark">BM</span>
                <span class="site-header__logo-divider"></span>
                <span class="site-header__logo-text">
                    <span class="site-header__logo-name">Bruno Mota</span>
                    <span class="site-header__logo-sub">Economista</span>
                </span>
            <?php endif; ?>
        </a>

        <!-- MENU PRINCIPAL (desktop) -->
        <nav class="site-header__nav" aria-label="Menu principal">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'site-header__menu',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                ) );
            } else {
                ?>
                <ul class="site-header__menu">
                    <li class="current-menu-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/sobre/' ) ); ?>">Sobre</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/atuacao/' ) ); ?>">Atuação</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/conquistas/' ) ); ?>">Conquistas</a></li>
                    <li><a href="#publicacoes">Publicações</a></li>
                    <li><a href="#midia">Mídia</a></li>
                    <li><a href="#contato">Contato</a></li>
                </ul>
                <?php
            }
            ?>
        </nav>

        <!-- BOTÃO CTA (desktop) -->
        <a href="https://wa.me/55SEUNUMEROAQUI" target="_blank" rel="noopener" class="site-header__cta">
            <svg class="site-header__cta-icon" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path fill="currentColor" d="M16.004 3C9.377 3 4 8.373 4 15c0 2.34.63 4.53 1.72 6.42L4 29l7.77-1.68A11.9 11.9 0 0 0 16.004 27C22.63 27 28 21.627 28 15S22.63 3 16.004 3Zm0 21.7a9.63 9.63 0 0 1-4.93-1.35l-.353-.21-4.61 1 1.02-4.5-.23-.36A9.64 9.64 0 1 1 25.64 15a9.65 9.65 0 0 1-9.636 9.7Zm5.3-7.25c-.29-.145-1.71-.845-1.976-.94-.265-.097-.458-.145-.65.145-.19.29-.746.94-.915 1.133-.168.194-.336.218-.626.073-.29-.145-1.223-.451-2.33-1.437-.86-.767-1.44-1.715-1.61-2.005-.168-.29-.018-.447.127-.591.13-.13.29-.338.435-.508.145-.17.193-.29.29-.483.096-.194.048-.363-.024-.508-.073-.145-.65-1.567-.892-2.146-.235-.564-.474-.487-.65-.496l-.554-.01c-.194 0-.508.073-.774.363-.265.29-1.014.99-1.014 2.415 0 1.425 1.038 2.803 1.183 2.997.145.194 2.043 3.12 4.95 4.376.692.298 1.232.476 1.653.61.694.221 1.325.19 1.824.115.556-.083 1.71-.699 1.951-1.373.242-.674.242-1.252.169-1.373-.072-.121-.265-.194-.554-.34Z"/>
            </svg>
            <span>Fale comigo</span>
        </a>

        <!-- BOTÃO HAMBURGUER (mobile) -->
        <button type="button" class="site-header__toggle" aria-expanded="false" aria-controls="site-header-mobile" aria-label="Abrir menu">
            <span class="site-header__toggle-bar"></span>
            <span class="site-header__toggle-bar"></span>
            <span class="site-header__toggle-bar"></span>
        </button>
    </div>

    <!-- MENU MOBILE -->
    <div id="site-header-mobile" class="site-header__mobile">
        <?php
        if ( has_nav_menu( 'primary' ) ) {
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'site-header__mobile-menu',
                'depth'          => 1,
                'fallback_cb'    => false,
            ) );
        } else {
            ?>
            <ul class="site-header__mobile-menu">
                <li class="current-menu-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a></li>
                <li><a href="<?php echo esc_url( home_url( '/sobre/' ) ); ?>">Sobre</a></li>
                <li><a href="<?php echo esc_url( home_url( '/atuacao/' ) ); ?>">Atuação</a></li>
                <li><a href="<?php echo esc_url( home_url( '/conquistas/' ) ); ?>">Conquistas</a></li>
                <li><a href="#publicacoes">Publicações</a></li>
                <li><a href="#midia">Mídia</a></li>
                <li><a href="#contato">Contato</a></li>
            </ul>
            <?php
        }
        ?>
        <a href="https://wa.me/55SEUNUMEROAQUI" target="_blank" rel="noopener" class="site-header__mobile-cta">
            <svg class="site-header__cta-icon" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path fill="currentColor" d="M16.004 3C9.377 3 4 8.373 4 15c0 2.34.63 4.53 1.72 6.42L4 29l7.77-1.68A11.9 11.9 0 0 0 16.004 27C22.63 27 28 21.627 28 15S22.63 3 16.004 3Zm0 21.7a9.63 9.63 0 0 1-4.93-1.35l-.353-.21-4.61 1 1.02-4.5-.23-.36A9.64 9.64 0 1 1 25.64 15a9.65 9.65 0 0 1-9.636 9.7Zm5.3-7.25c-.29-.145-1.71-.845-1.976-.94-.265-.097-.458-.145-.65.145-.19.29-.746.94-.915 1.133-.168.194-.336.218-.626.073-.29-.145-1.223-.451-2.33-1.437-.86-.767-1.44-1.715-1.61-2.005-.168-.29-.018-.447.127-.591.13-.13.29-.338.435-.508.145-.17.193-.29.29-.483.096-.194.048-.363-.024-.508-.073-.145-.65-1.567-.892-2.146-.235-.564-.474-.487-.65-.496l-.554-.01c-.194 0-.508.073-.774.363-.265.29-1.014.99-1.014 2.415 0 1.425 1.038 2.803 1.183 2.997.145.194 2.043 3.12 4.95 4.376.692.298 1.232.476 1.653.61.694.221 1.325.19 1.824.115.556-.083 1.71-.699 1.951-1.373.242-.674.242-1.252.169-1.373-.072-.121-.265-.194-.554-.34Z"/>
            </svg>
            <span>Fale comigo</span>
        </a>
    </div>
</header>

<!-- Espaçador para compensar o header fixo. Atualmente com display:none via
     header.css, porque o header flutua transparente por cima do conteúdo. -->
<div class="site-header__spacer" aria-hidden="true"></div>
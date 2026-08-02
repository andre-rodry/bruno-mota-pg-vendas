/**
 * header.js
 * Interatividade do cabeçalho:
 *  1) Muda a cor de fundo do header ao rolar a página (sem mudar de altura)
 *  2) Abrir/fechar o menu mobile (hamburguer)
 *  3) Fechar o menu mobile ao clicar num link ou ao redimensionar pra desktop
 *  4) Fechar o menu mobile ao pressionar ESC (acessibilidade)
 */
( function () {
    'use strict';

    document.addEventListener( 'DOMContentLoaded', function () {

        var header      = document.getElementById( 'site-header' );
        var toggleBtn   = header ? header.querySelector( '.site-header__toggle' ) : null;
        var mobileMenu  = document.getElementById( 'site-header-mobile' );

        if ( ! header ) {
            return;
        }

        /* ---------- 1) No topo: sempre visível e transparente.
           Depois de passar o banner: aparece durante o scroll, some quando para. ---------- */
        var SCROLL_THRESHOLD = 40; // a partir daqui, sai do modo "sempre visível"
        var HIDE_DELAY       = 600; // ms parado sem rolar até sumir (só depois do threshold)
        var hideTimer        = null;

        function handleScroll() {
            var scrolled = window.scrollY > SCROLL_THRESHOLD;

            header.classList.toggle( 'is-scrolled', scrolled );

            if ( ! scrolled ) {
                // Ainda no topo/banner: cancela qualquer temporizador pendente
                // e mantém o header sempre visível (fixo, transparente).
                clearTimeout( hideTimer );
                header.classList.add( 'is-visible' );
                return;
            }

            // Já passou do banner: aparece enquanto rola, some quando para.
            header.classList.add( 'is-visible' );
            clearTimeout( hideTimer );
            hideTimer = setTimeout( function () {
                if ( mobileMenu && mobileMenu.classList.contains( 'is-open' ) ) {
                    return;
                }
                header.classList.remove( 'is-visible' );
            }, HIDE_DELAY );
        }

        // Roda uma vez ao carregar: se a página já abrir rolada, aplica o
        // estado certo de cara; se abrir no topo, o header já aparece
        // (sempre visível, transparente) sem precisar de scroll nenhum.
        handleScroll();
        window.addEventListener( 'scroll', handleScroll, { passive: true } );

        // Ao passar o mouse sobre o header (menu, botões, etc.), garante que ele
        // não suma no meio da interação — só volta a contar pra sumir quando
        // o mouse sai de cima dele.
        header.addEventListener( 'mouseenter', function () {
            clearTimeout( hideTimer );
            header.classList.add( 'is-visible' );
        } );

        header.addEventListener( 'mouseleave', function () {
            if ( window.scrollY <= SCROLL_THRESHOLD ) {
                return; // ainda no topo: continua sempre visível
            }
            clearTimeout( hideTimer );
            hideTimer = setTimeout( function () {
                if ( mobileMenu && mobileMenu.classList.contains( 'is-open' ) ) {
                    return;
                }
                header.classList.remove( 'is-visible' );
            }, HIDE_DELAY );
        } );

        /* ---------- 2) Abrir / fechar menu mobile ---------- */
        if ( toggleBtn && mobileMenu ) {

            function openMenu() {
                mobileMenu.classList.add( 'is-open' );
                header.classList.add( 'is-visible' ); // mantém visível com o menu aberto
                clearTimeout( hideTimer );
                toggleBtn.setAttribute( 'aria-expanded', 'true' );
                toggleBtn.setAttribute( 'aria-label', 'Fechar menu' );
                document.body.style.overflow = 'hidden'; // trava o scroll do fundo
            }

            function closeMenu() {
                mobileMenu.classList.remove( 'is-open' );
                toggleBtn.setAttribute( 'aria-expanded', 'false' );
                toggleBtn.setAttribute( 'aria-label', 'Abrir menu' );
                document.body.style.overflow = '';

                // Só agenda esconder se já tiver passado do banner. No topo, o
                // header deve continuar sempre visível (regra do handleScroll).
                clearTimeout( hideTimer );
                if ( window.scrollY > SCROLL_THRESHOLD ) {
                    hideTimer = setTimeout( function () {
                        header.classList.remove( 'is-visible' );
                    }, HIDE_DELAY );
                }
            }

            function toggleMenu() {
                var isOpen = toggleBtn.getAttribute( 'aria-expanded' ) === 'true';
                if ( isOpen ) {
                    closeMenu();
                } else {
                    openMenu();
                }
            }

            toggleBtn.addEventListener( 'click', toggleMenu );

            /* ---------- 3) Fecha ao clicar em qualquer link do menu mobile ---------- */
            mobileMenu.addEventListener( 'click', function ( event ) {
                if ( event.target.tagName === 'A' ) {
                    closeMenu();
                }
            } );

            /* ---------- 3b) Fecha automaticamente se a tela virar desktop ---------- */
            window.addEventListener( 'resize', function () {
                if ( window.innerWidth > 960 && mobileMenu.classList.contains( 'is-open' ) ) {
                    closeMenu();
                }
            } );

            /* ---------- 4) Fecha com a tecla ESC ---------- */
            document.addEventListener( 'keydown', function ( event ) {
                if ( event.key === 'Escape' ) {
                    closeMenu();
                }
            } );
        }
    } );
} )();
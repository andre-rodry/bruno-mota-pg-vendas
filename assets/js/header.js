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

        /* ---------- 1) No topo: só logo + botão (menu escondido, fundo transparente).
           Ao rolar: menu aparece, fundo fica sólido. O header em si nunca
           desaparece da tela — só o conteúdo do menu muda com 'is-scrolled'. ---------- */
        var SCROLL_THRESHOLD = 40;

        function handleScroll() {
            var scrolled = window.scrollY > SCROLL_THRESHOLD;
            header.classList.toggle( 'is-scrolled', scrolled );
        }

        // Roda uma vez ao carregar, pra já aplicar o estado certo
        // (caso a página abra rolada) e depois fica ouvindo o scroll.
        handleScroll();
        window.addEventListener( 'scroll', handleScroll, { passive: true } );

        /* ---------- 2) Abrir / fechar menu mobile ---------- */
        if ( toggleBtn && mobileMenu ) {

            function openMenu() {
                mobileMenu.classList.add( 'is-open' );
                toggleBtn.setAttribute( 'aria-expanded', 'true' );
                toggleBtn.setAttribute( 'aria-label', 'Fechar menu' );
                document.body.style.overflow = 'hidden'; // trava o scroll do fundo
            }

            function closeMenu() {
                mobileMenu.classList.remove( 'is-open' );
                toggleBtn.setAttribute( 'aria-expanded', 'false' );
                toggleBtn.setAttribute( 'aria-label', 'Abrir menu' );
                document.body.style.overflow = '';
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
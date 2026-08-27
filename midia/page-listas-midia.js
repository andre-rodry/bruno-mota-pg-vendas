/**
 * page-listas-midia.js
 * Filtros (tipo, ano, canal, ordenação) e "carregar mais" da página de
 * mídia, via AJAX, sem recarregar a página.
 * Depende de window.andrewpEntrevistas (ajaxUrl + nonce), definido em
 * inc/enqueue-entrevistas.php via wp_localize_script.
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var root = document.querySelector('.lista-midia');
        if (!root || typeof window.andrewpEntrevistas === 'undefined') return;

        var state = {
            tipo: root.dataset.tipo || 'todas',
            canal: root.dataset.canal || 'todos',
            ano: root.dataset.ano || 'todas',
            orderby: root.dataset.orderby || 'recentes',
            paged: parseInt(root.dataset.nextPage, 10) || 2,
        };

        var listEl = root.querySelector('.lm-list');
        var loadMoreWrap = root.querySelector('.lm-loadmore');
        var loadMoreBtn = loadMoreWrap ? loadMoreWrap.querySelector('.lm-btn-outline') : null;

        if (loadMoreWrap && root.dataset.hasMore === 'false') {
            loadMoreWrap.style.display = 'none';
        }

        function setLoading(isLoading) {
            root.classList.toggle('is-loading', isLoading);
            if (loadMoreBtn) loadMoreBtn.classList.toggle('is-loading', isLoading);
        }

        function fetchEntrevistas(reset) {
            setLoading(true);

            var body = new URLSearchParams({
                action: 'andrewp_filtrar_entrevistas',
                nonce: window.andrewpEntrevistas.nonce,
                tipo: state.tipo,
                canal: state.canal,
                ano: state.ano,
                orderby: state.orderby,
                paged: reset ? 1 : state.paged,
            });

            fetch(window.andrewpEntrevistas.ajaxUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: body.toString(),
            })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    if (!res || !res.success) throw new Error('resposta inválida');
                    var data = res.data;

                    if (reset) {
                        listEl.innerHTML = data.html || '<li class="lm-empty">Nenhuma entrevista encontrada para esse filtro.</li>';
                    } else if (data.html) {
                        listEl.insertAdjacentHTML('beforeend', data.html);
                    }

                    if (loadMoreWrap) {
                        loadMoreWrap.style.display = data.has_more ? '' : 'none';
                    }
                    state.paged = data.next_page;
                })
                .catch(function () {
                    if (reset) {
                        listEl.innerHTML = '<li class="lm-empty">Não foi possível carregar as entrevistas agora.</li>';
                    }
                })
                .finally(function () {
                    setLoading(false);
                });
        }

        function resetAndFetch() {
            state.paged = 1;
            fetchEntrevistas(true);
        }

        /* ---------- Abas de tipo (TODAS / TV / RÁDIO / PODCASTS / IMPRENSA) ---------- */
        var tipoTabs = root.querySelectorAll('.lm-topnav__tab');
        tipoTabs.forEach(function (tab) {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                if (tab.classList.contains('is-active')) return;

                tipoTabs.forEach(function (t) { t.classList.remove('is-active'); });
                tab.classList.add('is-active');
                state.tipo = tab.dataset.tipo || 'todas';

                var titleEl = root.querySelector('.lm-hero__title');
                var subtitleEl = root.querySelector('.lm-hero__subtitle');
                var descEl = root.querySelector('.lm-hero__desc');
                var iconEl = titleEl ? titleEl.querySelector('[class*="lm-icon-"]') : null;

                if (iconEl && tab.dataset.heroIcon) {
                    iconEl.className = 'lm-icon-' + tab.dataset.heroIcon + ' lm-icon-tv--lg';
                }
                if (titleEl && tab.dataset.heroTitle) {
                    titleEl.lastChild.textContent = ' ' + tab.dataset.heroTitle;
                }
                if (subtitleEl && tab.dataset.heroSubtitle) subtitleEl.textContent = tab.dataset.heroSubtitle;
                if (descEl && tab.dataset.heroDesc) descEl.textContent = tab.dataset.heroDesc;

                resetAndFetch();
            });
        });

        /* ---------- Abas de ano ---------- */
        var yearTabs = root.querySelectorAll('.lm-yeartabs__tab');
        yearTabs.forEach(function (tab) {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                if (tab.classList.contains('is-active')) return;

                yearTabs.forEach(function (t) { t.classList.remove('is-active'); });
                tab.classList.add('is-active');
                state.ano = tab.dataset.ano || 'todas';
                resetAndFetch();
            });
        });

        /* ---------- Filtro por canal (sidebar) ---------- */
        var canalItems = root.querySelectorAll('.lm-radiolist__item');
        canalItems.forEach(function (item) {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                var canal = item.dataset.canal || 'todos';
                if (canal === state.canal) return;

                canalItems.forEach(function (i) {
                    var radio = i.querySelector('.lm-radio');
                    if (radio) radio.classList.remove('is-checked');
                });
                var radioAtual = item.querySelector('.lm-radio');
                if (radioAtual) radioAtual.classList.add('is-checked');

                state.canal = canal;
                resetAndFetch();
            });
        });

        /* ---------- Dropdowns de ordenação (topo + barra de filtro) ---------- */
        var sortDropdowns = root.querySelectorAll('.lm-select');
        sortDropdowns.forEach(function (dropdown) {
            dropdown.addEventListener('click', function (e) {
                e.stopPropagation();
                sortDropdowns.forEach(function (d) {
                    if (d !== dropdown) d.classList.remove('is-open');
                });
                dropdown.classList.toggle('is-open');
            });

            var menu = dropdown.querySelector('.lm-select__menu');
            if (!menu) return;

            menu.querySelectorAll('[data-orderby]').forEach(function (opt) {
                opt.addEventListener('click', function (e) {
                    e.stopPropagation();
                    var orderby = opt.dataset.orderby;
                    var texto = opt.textContent.trim();

                    sortDropdowns.forEach(function (d) {
                        var label = d.querySelector('span');
                        if (label) label.textContent = texto;
                        d.classList.remove('is-open');
                        d.querySelectorAll('.lm-select__option').forEach(function (o) {
                            o.classList.toggle('is-active', o.dataset.orderby === orderby);
                        });
                    });

                    if (orderby === state.orderby) return;
                    state.orderby = orderby;
                    resetAndFetch();
                });
            });
        });

        document.addEventListener('click', function () {
            sortDropdowns.forEach(function (d) { d.classList.remove('is-open'); });
        });

        /* ---------- Carregar mais ---------- */
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (loadMoreBtn.classList.contains('is-loading')) return;
                fetchEntrevistas(false);
            });
        }
    });
})();
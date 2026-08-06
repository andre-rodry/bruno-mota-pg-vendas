/* =========================================================
   Loader Global — Bruno Mota
   ========================================================= */
(function () {
    'use strict';

    var loader = document.getElementById('bm-loader');
    if (!loader) return;

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
/* =========================================================
   page-faq-contato.js
   Anima a abertura/fechamento dos <details> do FAQ para ficar
   suave, em vez do "salto" padrão do navegador.
   Não depende de nenhuma lib — usa a Web Animations API.
   ========================================================= */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var items = document.querySelectorAll('.faq-item');

        items.forEach(function (item) {
            var summary = item.querySelector('.faq-pergunta');
            var content = item.querySelector('.faq-resposta');
            var animation = null;
            var isClosing = false;
            var isExpanding = false;

            summary.addEventListener('click', function (e) {
                e.preventDefault();

                item.style.overflow = 'hidden';

                if (isClosing || !item.open) {
                    open();
                } else if (isExpanding || item.open) {
                    close();
                }
            });

            function open() {
                item.style.height = item.offsetHeight + 'px';
                item.open = true;
                window.requestAnimationFrame(expand);
            }

            function expand() {
                isExpanding = true;
                var startHeight = item.offsetHeight;
                var endHeight = summary.offsetHeight + content.offsetHeight;

                runAnimation(startHeight, endHeight, true);
            }

            function close() {
                isClosing = true;
                var startHeight = item.offsetHeight;
                var endHeight = summary.offsetHeight;

                runAnimation(startHeight, endHeight, false);
            }

            function runAnimation(startHeight, endHeight, willBeOpen) {
                if (animation) {
                    animation.cancel();
                }

                animation = item.animate(
                    { height: [startHeight + 'px', endHeight + 'px'] },
                    { duration: 260, easing: 'cubic-bezier(.4, 0, .2, 1)' }
                );

                animation.onfinish = function () {
                    onAnimationFinish(willBeOpen);
                };
                animation.oncancel = function () {
                    isClosing = false;
                    isExpanding = false;
                };
            }

            function onAnimationFinish(open) {
                item.open = open;
                animation = null;
                isClosing = false;
                isExpanding = false;
                item.style.height = '';
                item.style.overflow = '';
            }
        });
    });
})();
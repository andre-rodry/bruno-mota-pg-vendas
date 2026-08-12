/**
 * contato/page-faq-contato.js
 * Accordion do FAQ da página de contato.
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var questions = document.querySelectorAll('.contato-faq__question');

        questions.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var item = btn.closest('.contato-faq__item');
                var answer = item.querySelector('.contato-faq__answer');
                var isOpen = btn.getAttribute('aria-expanded') === 'true';

                btn.setAttribute('aria-expanded', String(!isOpen));

                if (isOpen) {
                    answer.style.maxHeight = null;
                } else {
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                }
            });
        });
    });
})();
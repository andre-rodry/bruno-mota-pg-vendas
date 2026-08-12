/**
 * contato/page-form-contato.js
 * Envio do formulário de contato via admin-ajax.php.
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('contato-form');
        if (!form) return;

        var feedback = form.querySelector('.contato-form__feedback');
        var submitBtn = form.querySelector('.contato-form__submit');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            feedback.textContent = '';
            feedback.classList.remove('is-success', 'is-error');
            submitBtn.disabled = true;

            var formData = new FormData(form);
            formData.append('action', 'andrewp_enviar_contato');
            formData.append('nonce', form.querySelector('#contato_nonce').value);

            fetch(andrewpContato.ajaxUrl, {
                method: 'POST',
                credentials: 'same-origin',
                body: formData,
            })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    submitBtn.disabled = false;

                    if (data.success) {
                        feedback.textContent = data.data.message || 'Mensagem enviada com sucesso!';
                        feedback.classList.add('is-success');
                        form.reset();
                    } else {
                        feedback.textContent = (data.data && data.data.message) || 'Erro ao enviar. Tente novamente.';
                        feedback.classList.add('is-error');
                    }
                })
                .catch(function () {
                    submitBtn.disabled = false;
                    feedback.textContent = 'Erro de conexão. Tente novamente.';
                    feedback.classList.add('is-error');
                });
        });
    });
})();
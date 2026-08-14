/* =========================================================
   page-form-contato.js
   Validação client-side + envio via fetch/AJAX para ajax-contato.php
   ========================================================= */

(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('form-contato');
        if (!form) return;

        var feedbackEl = document.getElementById('form-feedback');
        var submitBtn = form.querySelector('.btn-enviar');

        var ENDPOINT = form.getAttribute('action') || 'ajax-contato.php';

        var rules = {
            nome: {
                required: true,
                validate: function (v) { return v.trim().length >= 2; },
                message: 'Informe seu nome completo.'
            },
            email: {
                required: true,
                validate: function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()); },
                message: 'Informe um e-mail válido.'
            },
            telefone: {
                required: true,
                validate: function (v) { return v.replace(/\D/g, '').length >= 10; },
                message: 'Informe um telefone/WhatsApp válido.'
            },
            assunto: {
                required: false
            },
            mensagem: {
                required: true,
                validate: function (v) { return v.trim().length >= 10; },
                message: 'Escreva uma mensagem com pelo menos 10 caracteres.'
            }
        };

        // Máscara simples de telefone
        var telInput = form.querySelector('#telefone');
        if (telInput) {
            telInput.addEventListener('input', function () {
                var digits = telInput.value.replace(/\D/g, '').slice(0, 11);
                var out = digits;
                if (digits.length > 10) {
                    out = digits.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
                } else if (digits.length > 6) {
                    out = digits.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                } else if (digits.length > 2) {
                    out = digits.replace(/(\d{2})(\d{0,5})/, '($1) $2');
                } else if (digits.length > 0) {
                    out = digits.replace(/(\d{0,2})/, '($1');
                }
                telInput.value = out;
            });
        }

        function setFieldError(field, message) {
            var input = form.querySelector('[name="' + field + '"]');
            var errorEl = form.querySelector('[data-error-for="' + field + '"]');
            if (input) input.classList.toggle('is-invalid', !!message);
            if (errorEl) {
                errorEl.textContent = message || '';
                errorEl.classList.toggle('is-visible', !!message);
            }
        }

        function clearErrors() {
            Object.keys(rules).forEach(function (field) {
                setFieldError(field, '');
            });
        }

        function validateForm(data) {
            var valid = true;
            var firstInvalid = null;

            Object.keys(rules).forEach(function (field) {
                var rule = rules[field];
                var value = data[field] || '';

                if (rule.required && value.trim() === '') {
                    setFieldError(field, 'Este campo é obrigatório.');
                    valid = false;
                    firstInvalid = firstInvalid || field;
                    return;
                }

                if (rule.validate && value.trim() !== '' && !rule.validate(value)) {
                    setFieldError(field, rule.message);
                    valid = false;
                    firstInvalid = firstInvalid || field;
                }
            });

            if (firstInvalid) {
                var el = form.querySelector('[name="' + firstInvalid + '"]');
                if (el) el.focus();
            }

            return valid;
        }

        function showFeedback(type, message) {
            if (!feedbackEl) return;
            feedbackEl.textContent = message;
            feedbackEl.className = 'form-feedback is-visible is-' + type;
        }

        function hideFeedback() {
            if (!feedbackEl) return;
            feedbackEl.className = 'form-feedback';
            feedbackEl.textContent = '';
        }

        function setLoading(isLoading) {
            if (!submitBtn) return;
            submitBtn.disabled = isLoading;
            submitBtn.classList.toggle('is-loading', isLoading);
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            hideFeedback();
            clearErrors();

            var formData = new FormData(form);
            var data = {};
            formData.forEach(function (value, key) { data[key] = value; });

            // Honeypot: se preenchido, é bot — aborta silenciosamente
            if (data.website) {
                showFeedback('success', 'Mensagem enviada com sucesso!');
                form.reset();
                return;
            }

            if (!validateForm(data)) {
                showFeedback('error', 'Verifique os campos destacados e tente novamente.');
                return;
            }

            setLoading(true);

            fetch(ENDPOINT, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            })
                .then(function (response) {
                    return response.json().catch(function () {
                        throw new Error('Resposta inválida do servidor.');
                    });
                })
                .then(function (result) {
                    setLoading(false);

                    if (result && result.success) {
                        showFeedback('success', result.message || 'Mensagem enviada com sucesso! Em breve entrarei em contato.');
                        form.reset();
                    } else {
                        if (result && result.errors) {
                            Object.keys(result.errors).forEach(function (field) {
                                setFieldError(field, result.errors[field]);
                            });
                        }
                        showFeedback('error', (result && result.message) || 'Não foi possível enviar sua mensagem. Tente novamente.');
                    }
                })
                .catch(function () {
                    setLoading(false);
                    showFeedback('error', 'Erro de conexão. Verifique sua internet e tente novamente.');
                });
        });
    });
})();
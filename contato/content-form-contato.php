<?php
/**
 * contato/content-form-contato.php
 * Section 2 — Formulário de mensagem, enviado via AJAX (admin-ajax.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<section class="contato-form" id="form-contato">
    <div class="contato-form__inner">

        <div class="contato-form__intro">
            <span class="contato-form__eyebrow">Envie sua mensagem</span>
            <h2 class="contato-form__title">
                Estou pronto para<br>te ouvir.
            </h2>
            <div class="contato-form__divider"></div>
            <p class="contato-form__text">
                Preencha o formulário ao lado com sua mensagem.
                Assim que possível, entrarei em contato.
            </p>
        </div>

        <form class="contato-form__form" id="contato-form" novalidate>
            <?php wp_nonce_field( 'andrewp_contato_nonce', 'contato_nonce' ); ?>

            <div class="contato-form__row">
                <div class="contato-form__field">
                    <input type="text" id="contato-nome" name="nome" placeholder="Seu nome" required>
                </div>
                <div class="contato-form__field">
                    <input type="email" id="contato-email" name="email" placeholder="Seu e-mail" required>
                </div>
            </div>

            <div class="contato-form__row">
                <div class="contato-form__field">
                    <input type="tel" id="contato-telefone" name="telefone" placeholder="Telefone / WhatsApp">
                </div>
                <div class="contato-form__field">
                    <input type="text" id="contato-assunto" name="assunto" placeholder="Assunto">
                </div>
            </div>

            <div class="contato-form__row contato-form__row--full">
                <div class="contato-form__field">
                    <textarea id="contato-mensagem" name="mensagem" rows="5" placeholder="Sua mensagem" required></textarea>
                </div>
            </div>

            <button type="submit" class="contato-form__submit">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                <span>Enviar mensagem</span>
            </button>

            <p class="contato-form__feedback" role="status" aria-live="polite"></p>
        </form>

    </div>
</section>
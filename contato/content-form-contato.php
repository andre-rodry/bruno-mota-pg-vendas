<?php
/**
 * content-form-contato.php
 * Partial: seção de contato "Estou pronto para te ouvir."
 *
 * Gera um token simples (CSRF) guardado em sessão e validado em ajax-contato.php.
 * Inclua este arquivo onde a seção de contato deve aparecer:
 *   <?php include 'content-form-contato.php'; ?>
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Token CSRF simples
if (empty($_SESSION['contato_token'])) {
    $_SESSION['contato_token'] = bin2hex(random_bytes(32));
}
$contato_token = $_SESSION['contato_token'];
?>

<section class="contato-section" id="contato">
    <div class="contato-container">

        <div class="contato-info">
            <span class="contato-eyebrow">ENVIE SUA MENSAGEM</span>
            <h2 class="contato-titulo">Estou pronto para<br>te ouvir.</h2>
            <div class="contato-divisor" aria-hidden="true"></div>
            <p class="contato-texto">
                Preencha o formulário ao lado com sua mensagem.
                Assim que possível, entrarei em contato.
            </p>
        </div>

        <div class="contato-form-wrapper">
            <form id="form-contato" class="contato-form" method="post" action="ajax-contato.php" novalidate>

                <div class="form-row">
                    <div class="form-group">
                        <input type="text" id="nome" name="nome" class="form-input" placeholder="Seu nome" autocomplete="name" required>
                        <span class="form-error" data-error-for="nome"></span>
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-input" placeholder="Seu e-mail" autocomplete="email" required>
                        <span class="form-error" data-error-for="email"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <input type="tel" id="telefone" name="telefone" class="form-input" placeholder="Telefone / WhatsApp" autocomplete="tel" required>
                        <span class="form-error" data-error-for="telefone"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" id="assunto" name="assunto" class="form-input" placeholder="Assunto">
                        <span class="form-error" data-error-for="assunto"></span>
                    </div>
                </div>

                <div class="form-group form-group-full">
                    <textarea id="mensagem" name="mensagem" class="form-input form-textarea" rows="5" placeholder="Sua mensagem" required></textarea>
                    <span class="form-error" data-error-for="mensagem"></span>
                </div>

                <!-- Honeypot anti-spam (mantido escondido via CSS) -->
                <div class="hp-wrapper" aria-hidden="true">
                    <label for="website">Não preencha este campo</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <input type="hidden" name="contato_token" value="<?php echo htmlspecialchars($contato_token, ENT_QUOTES, 'UTF-8'); ?>">

                <button type="submit" class="btn-enviar">
                    <svg class="btn-enviar-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M21.5 2.5L2.5 10.3L10.6 13.4L13.7 21.5L21.5 2.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" stroke-linecap="round"/>
                        <path d="M21.5 2.5L10.6 13.4" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" stroke-linecap="round"/>
                    </svg>
                    <span class="btn-enviar-texto">ENVIAR MENSAGEM</span>
                    <span class="btn-enviar-loader" aria-hidden="true"></span>
                </button>

                <div class="form-feedback" id="form-feedback" role="alert" aria-live="polite"></div>
            </form>
        </div>

    </div>
</section>
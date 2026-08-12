<?php
/**
 * contato/content-banner-contato.php
 * Section 1 — Hero de contato: título, infos rápidas e CTA de palestras.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<section class="contato-banner" id="contato">
    <div class="contato-banner__inner">

        <div class="contato-banner__content">
            <span class="contato-banner__eyebrow">Contato</span>

            <h1 class="contato-banner__title">
                Vamos conversar<br>
                <span class="contato-banner__title-accent">sobre o futuro.</span>
            </h1>

            <div class="contato-banner__divider"></div>

            <p class="contato-banner__text">
                Entre em contato para palestras, consultorias, entrevistas
                ou parcerias. Estou à disposição para contribuir com ideias
                e soluções que geram impacto real.
            </p>

            <div class="contato-banner__grid">

                <div class="contato-banner__item">
                    <span class="contato-banner__icon" aria-hidden="true">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <div>
                        <span class="contato-banner__item-label">E-mail</span>
                        <span class="contato-banner__item-value">contato@brunomota.com.br</span>
                    </div>
                </div>

                <div class="contato-banner__item">
                    <span class="contato-banner__icon" aria-hidden="true">
                        <i class="fa-solid fa-phone"></i>
                    </span>
                    <div>
                        <span class="contato-banner__item-label">Telefone</span>
                        <span class="contato-banner__item-value">(71) 99999-9999</span>
                    </div>
                </div>

                <div class="contato-banner__item">
                    <span class="contato-banner__icon" aria-hidden="true">
                        <i class="fa-solid fa-location-dot"></i>
                    </span>
                    <div>
                        <span class="contato-banner__item-label">Localização</span>
                        <span class="contato-banner__item-value">Salvador, Bahia - Brasil</span>
                    </div>
                </div>

                <div class="contato-banner__item">
                    <span class="contato-banner__icon" aria-hidden="true">
                        <i class="fa-regular fa-clock"></i>
                    </span>
                    <div>
                        <span class="contato-banner__item-label">Tempo de resposta</span>
                        <span class="contato-banner__item-value">Retorno em até 24h úteis</span>
                    </div>
                </div>

            </div>

            <div class="contato-banner__cta-box">
                <span class="contato-banner__cta-icon" aria-hidden="true">
                    <i class="fa-regular fa-calendar"></i>
                </span>
                <div class="contato-banner__cta-text">
                    <strong>Palestras e eventos</strong>
                    <span>Para convites, palestras e eventos, fale diretamente comigo.</span>
                    <a href="#form-contato" class="contato-banner__cta-link">
                        Quero convidar o Bruno <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="contato-banner__media">
            <img
                src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/bruno-mota-economista-contato.webp' ); ?>"
                alt="Bruno Mota, economista"
                class="contato-banner__img"
                loading="eager"
            >
        </div>

    </div>
</section>
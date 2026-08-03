<?php
/**
 * template-parts/about.php
 * Seção "Quem é Bruno Mota" — foto à esquerda, texto de apresentação à direita.
 *
 * Baseado no bloco originalmente feito para Elementor (namespace .bml-sobre-mota),
 * adaptado para rodar como template-part normal do tema.
 */

$about_img = 'https://i.ibb.co/mFNCDYM3/6ea39959-81fd-481f-aa97-48ccaa054e45.png';
?>

<div class="bml-sobre-mota">

    <section class="bml-about">
        <div class="bml-about-inner">

            <div class="bml-about-photo">
                <img src="<?php echo esc_url( $about_img ); ?>" alt="Bruno Mota">
            </div>

            <div class="bml-about-content">
                <span class="bml-eyebrow">Quem é</span>
                <h2 class="bml-name">Bruno Mota</h2>

                <p>Economista, pesquisador e consultor com atuação destacada em políticas públicas, desenvolvimento econômico e educação financeira.</p>

                <p>Com mais de 20 publicações acadêmicas e presença constante na mídia nacional, Bruno Mota transforma conhecimento técnico em soluções práticas para o desenvolvimento de pessoas, instituições e da sociedade.</p>

                <p>Sua trajetória é marcada pelo compromisso com a educação, a ética e o impacto real na vida das pessoas.</p>

                <a href="<?php echo esc_url( home_url( '/sobre' ) ); ?>" class="bml-cta-button">
                    Saiba mais sobre mim
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 12h16M14 6l6 6-6 6"/>
                    </svg>
                </a>
            </div>

        </div>
    </section>

</div>
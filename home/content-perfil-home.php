<?php
/**
 * content-perfil-home.php
 * Bloco "Quem é Bruno Mota" (perfil) exibido na página inicial.
 *
 * Uso: <?php get_template_part( 'template-parts/content', 'perfil-home' ); ?>
 * CSS correspondente: page-perfil-home.css
 *
 * Imagem local do tema:
 * wp-content/themes/andreWP/assets/img/home/bruno-mota-economista-sobre.webp
 */

$perfil_home_img = get_template_directory_uri() . '/assets/img/home/bruno-mota-economista-sobre.webp';
?>

<div class="perfil-home">

    <section class="perfil-home__section">
        <div class="perfil-home__inner">

            <div class="perfil-home__photo">
                <img src="<?php echo esc_url( $perfil_home_img ); ?>" alt="Bruno Mota">
            </div>

            <div class="perfil-home__content">
                <span class="perfil-home__eyebrow">Quem é</span>
                <h2 class="perfil-home__name">Bruno Mota</h2>

                <p>Economista, pesquisador e consultor com atuação destacada em políticas públicas, desenvolvimento econômico e educação financeira.</p>

                <p>Com mais de 20 publicações acadêmicas e presença constante na mídia nacional, Bruno Mota transforma conhecimento técnico em soluções práticas para o desenvolvimento de pessoas, instituições e da sociedade.</p>

                <p>Sua trajetória é marcada pelo compromisso com a educação, a ética e o impacto real na vida das pessoas.</p>

                <a href="<?php echo esc_url( home_url( '/sobre' ) ); ?>" class="perfil-home__cta">
                    Saiba mais sobre mim
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 12h16M14 6l6 6-6 6"/>
                    </svg>
                </a>
            </div>

        </div>
    </section>

</div>
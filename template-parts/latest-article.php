<?php
/**
 * template-parts/latest-article.php
 * Barra clara com o último artigo publicado (post mais recente do blog).
 */

$ultimo_artigo = get_posts( array(
    'numberposts' => 1,
    'post_status' => 'publish',
) );

// Se não existir nenhum post publicado ainda, a seção não é exibida.
if ( empty( $ultimo_artigo ) ) {
    return;
}

$post = $ultimo_artigo[0];
?>

<section class="latest-article-bar">
    <div class="latest-article-bar__inner">

        <div class="latest-article-bar__label">
            <i class="fa-solid fa-book-open latest-article-bar__icon" aria-hidden="true"></i>
            <span>Último artigo publicado</span>
        </div>

        <div class="latest-article-bar__title">
            <?php echo esc_html( get_the_title( $post ) ); ?>
        </div>

        <a class="latest-article-bar__link" href="<?php echo esc_url( get_permalink( $post ) ); ?>">
            Ler artigo
            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>

    </div>
</section>
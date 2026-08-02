<?php
/**
 * index.php
 * Template "coringa" — o WordPress usa este arquivo quando nenhum
 * template mais específico (single.php, page.php etc.) existe.
 * TODO tema precisa ter um index.php, mesmo que os outros existam.
 */

get_header();
?>

<?php if ( have_posts() ) : ?>

    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>

            <div class="entry-content">
                <?php
                if ( is_singular() ) {
                    the_content();
                } else {
                    the_excerpt();
                }
                ?>
            </div>

        </article>

    <?php endwhile; ?>

    <?php
    // Paginação simples (posts mais antigos / mais recentes).
    the_posts_navigation();
    ?>

<?php else : ?>

    <p><?php esc_html_e( 'Nenhum conteúdo encontrado.', 'meu-tema' ); ?></p>

<?php endif; ?>

<?php
get_footer();

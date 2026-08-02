<?php
/**
 * page.php
 * Template usado especificamente para Páginas (não posts do blog).
 * O WordPress dá prioridade a este arquivo sobre o index.php quando
 * o conteúdo exibido é uma página (ex: "Sobre", "Contato").
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <h1 class="entry-title"><?php the_title(); ?></h1>

        <div class="entry-content">
            <?php the_content(); ?>
        </div>

    </article>

<?php endwhile; ?>

<?php
get_footer();

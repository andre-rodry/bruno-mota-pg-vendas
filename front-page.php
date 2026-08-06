<?php
/**
 * front-page.php
 * Template usado especificamente para a página inicial do site.
 *
 * O loader de entrada agora é global e vive no header.php — aparece em
 * qualquer página quando há um F5/refresh, não só na home.
 */

get_header();
?>

<?php get_template_part( 'template-parts/banner' ); ?>

<main id="main-content">

    <?php get_template_part( 'template-parts/latest-article' ); ?>

    <?php get_template_part( 'template-parts/stats' ); ?>

    <?php get_template_part( 'template-parts/about' ); ?>

    <?php get_template_part( 'template-parts/media' ); ?>

    <?php get_template_part( 'template-parts/institutions' ); ?>

    <?php get_template_part( 'template-parts/gallery' ); ?>

    <?php get_template_part( 'template-parts/publications' ); ?>

    <!-- Aqui entram as próximas seções: atuação, conquistas, publicações, contato -->

</main>

<?php
get_footer();
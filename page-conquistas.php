<?php
/**
 * Template: Conquistas
 *
 * @package andreWP
 */

get_header();
?>

<?php get_template_part( 'template-parts/content-banner', 'conquistas' ); ?>
<?php get_template_part( 'template-parts/content-marquee', 'conquistas' ); ?>
<?php get_template_part( 'template-parts/content-timeline', 'conquistas' ); ?>
<?php get_template_part( 'template-parts/content-grid', 'conquistas' ); ?>
<!-- próximas seções entram aqui, uma get_template_part por vez -->

<?php
get_footer();
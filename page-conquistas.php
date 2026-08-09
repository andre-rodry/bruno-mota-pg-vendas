<?php
/**
 * Template: Conquistas
 *
 * @package andreWP
 */

get_header();
?>

<?php get_template_part( 'conquistas/content-banner', 'conquistas' ); ?>
<?php get_template_part( 'conquistas/content-marquee', 'conquistas' ); ?>
<?php get_template_part( 'conquistas/content-timeline', 'conquistas' ); ?>
<?php get_template_part( 'conquistas/content-grid', 'conquistas' ); ?>
<?php get_template_part( 'conquistas/content-parceiros', 'conquistas' ); ?>
<!-- próximas seções entram aqui, uma get_template_part por vez -->

<?php
get_footer();
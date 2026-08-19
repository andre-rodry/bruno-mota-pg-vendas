<?php
/**
 * Template: Trajetória
 *
 * @package andreWP
 */

get_header();
?>

<?php get_template_part( 'trajetoria/content-banner', 'trajetoria' ); ?>
<?php get_template_part( 'trajetoria/content-numeros', 'trajetoria' ); ?>
<?php get_template_part( 'trajetoria/content-valores', 'trajetoria' ); ?>
<?php get_template_part( 'trajetoria/content-timeline', 'trajetoria' ); ?>
<?php get_template_part( 'trajetoria/content-grid', 'trajetoria' ); ?>
<?php get_template_part( 'trajetoria/content-galeria', 'trajetoria' ); ?>

<?php
get_footer();
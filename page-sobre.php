<?php
/**
 * Template: page-sobre.php
 *
 * O WordPress usa este arquivo automaticamente para a Página cujo slug
 * (endereço) seja "sobre" — ou seja, para seusite.com/sobre/.
 * Não precisa selecionar nenhum template manualmente no admin.
 *
 * O CSS desta página fica em assets/css/pagination-about.css,
 * enfileirado no functions.php só quando is_page( 'sobre' ).
 *
 * @package andreWP
 */

get_header();
?>

<main id="main-content">
	<?php get_template_part( 'template-parts/pagination-about' ); ?>
</main>

<?php
get_footer();
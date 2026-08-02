<?php
/**
 * single.php
 * Template usado para exibir UM post individual do blog
 * (diferente do index.php, que lista vários posts).
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <h1 class="entry-title"><?php the_title(); ?></h1>

        <div class="entry-meta">
            <span class="posted-on">
                <?php echo esc_html( get_the_date() ); ?>
            </span>
            <span class="byline">
                <?php esc_html_e( 'por', 'meu-tema' ); ?>
                <?php the_author(); ?>
            </span>

            <?php if ( has_category() ) : ?>
                <span class="cat-links">
                    <?php esc_html_e( 'em', 'meu-tema' ); ?>
                    <?php the_category( ', ' ); ?>
                </span>
            <?php endif; ?>
        </div>

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail( 'large' ); ?>
            </div>
        <?php endif; ?>

        <div class="entry-content">
            <?php the_content(); ?>
        </div>

        <?php if ( has_tag() ) : ?>
            <div class="tag-links">
                <?php esc_html_e( 'Tags:', 'meu-tema' ); ?>
                <?php the_tags( '', ', ', '' ); ?>
            </div>
        <?php endif; ?>

    </article>

    <?php
    // Navegação entre post anterior e próximo.
    the_post_navigation( array(
        'prev_text' => '&larr; %title',
        'next_text' => '%title &rarr;',
    ) );

    // Carrega a área de comentários (comments.php), se os comentários
    // estiverem abertos ou já existirem comentários no post.
    if ( comments_open() || get_comments_number() ) {
        comments_template();
    }
    ?>

<?php endwhile; ?>

<?php
get_footer();
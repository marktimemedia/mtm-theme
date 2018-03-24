<section class="mtm-component content--page">
    <?php get_template_part( 'templates/page', 'header' ); ?>

    <?php get_template_part( 'templates/no', 'results' ); ?>

    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part( 'templates/content', 'archive' ); ?>
    <?php endwhile; ?>

    <?php if ( $wp_query->max_num_pages > 1 ) : ?>
        <nav class="nav-pager">
            <ul class="pager">
                <li class="pager--previous"><?php next_posts_link( __( '&larr; Older posts', 'spring' ) ); ?></li>
                <li class="pager--next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'spring' ) ); ?></li>
            </ul>
        </nav>
    <?php endif; ?>
<section class="content--page">

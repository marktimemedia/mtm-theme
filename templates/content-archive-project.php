<div class="mtm-component--main">
        <?php get_template_part( 'templates/page', 'header' ); ?>
        <?php mtm_terms_from_taxonomy_links( 'type' ); // output taxonomy ?>
    </div>

        <div class="mtm-component--content mtm-grid--wrapper">

            <?php if ( !have_posts() ) : ?>
                <div class="alert alert-warning">
                    <?php _e( 'Sorry, no results were found.', 'spring' ); ?>
                </div>
            <?php endif; ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php get_template_part( 'mtm-templates/mtm-content', 'grid-view' ); ?>
            <?php endwhile; ?>

            <?php if ( $wp_query->max_num_pages > 1 ) : ?>
                <nav class="nav-pager">
                    <ul class="pager">
                        <li class="pager--previous"><?php next_posts_link( __( '&larr; Older posts', 'spring' ) ); ?></li>
                        <li class="pager--next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'spring' ) ); ?></li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
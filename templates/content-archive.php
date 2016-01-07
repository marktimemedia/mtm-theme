<article <?php post_class( 'archive mtm-list--single' ); ?>>
    <?php 
    $content_size = '-full';

    if ( has_post_thumbnail() ) : 
    $content_size = ''; ?>

        <section class="mtm-list--image">
            <figure class="post--thumbnail mtm-list--image"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ) ?></a></figure>
        </section>

    <?php endif; ?>

    <section class="mtm-list--post-content<?php echo $content_size; ?>">
        <header>
            <h2 class="post--title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php edit_post_link( '(Edit)', ' • ' ); ?></h2>
        </header>
        <?php get_template_part( 'templates/entry-meta' ); ?>
        <div class="post--summary">
            <?php wp_trim_excerpt(''); ?>
        </div>
    </section>
</article>
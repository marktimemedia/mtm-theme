<?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class(); ?>>
        <?php if ( has_post_thumbnail() ) : ?>
            <figure class="post--thumbnail"><?php the_post_thumbnail( 'full' ) ?></figure>
        <?php endif; ?>
        <header >
            <h1 class="post--title"><?php the_title(); ?></h1>
            <?php get_template_part( 'templates/entry-meta' ); ?>       
        </header>
        <div class="post--content">
            <?php the_content(); ?>
        </div>
        <?php wp_link_pages(array( 'before' => '<nav class="nav-pager post--pager">' . __( 'Pages:', 'spring'), 'after' => '</nav>' ) ); ?>

        <?php comments_template( '/templates/comments.php' ); ?>
    </article>
<?php endwhile; ?>

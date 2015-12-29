<article <?php post_class(); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <figure class="post--thumbnail single-project--img"><?php the_post_thumbnail( 'full' ) ?></figure>
    <?php endif; ?>
    <div class="single-project--content">
        <header>
            <h1 class="post--title"><?php the_title(); ?></h1>
            <?php get_template_part( 'templates/post-meta' ); ?>
        </header>

        <div class="post--content">

            <?php if( _get_field( 'mtm_case_study_link' ) ){ ?>
                <a class="single-project--case-study" href="<?php the_field( 'mtm_case_study_link' ); ?>"><?php _e( 'View Case Study', 'spring' ); ?></a>
            <?php } ?>

            <?php the_content(); ?>
        </div>
        <div class="single-project--credits">
            <?php if( _get_field( 'mtm_project_website' ) ){ ?>
                <a class="single-project--website" href="<?php the_field( 'mtm_project_website' ); ?>"><?php the_title(); _e( ' Website', 'spring' ); ?></a>
            <?php }

            if( _get_field( 'mtm_project_credits' ) ){ ?>
                <div class="single-project--attribution">
                    <?php the_field( 'mtm_project_credits' ); ?>
                </div>
            <?php } ?>

        </div>

    </div>
</article>
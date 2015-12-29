<section class="post--byline post--metadata">
    <time class="byline--date published" datetime="<?php echo get_the_time( 'c' ); ?>"><?php the_time( 'F j, Y' ); ?></time>
    &ensp;&#8226;&ensp;
    <section class="post--metadata_categories">
        <?php echo custom_taxonomies_terms_links(); ?>
    </section>
</section>

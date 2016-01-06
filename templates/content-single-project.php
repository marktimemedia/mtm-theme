<?php while ( have_posts() ) : the_post(); ?>
	<a class="go-back" href="<?php echo site_url(); ?>#work"><?php esc_html_e( 'View All Work', 'spring' ) ?></a>  
    <?php get_template_part( 'templates/content', 'single-project-inside' ); ?>
<?php endwhile; ?>

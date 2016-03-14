<?php // Manual Grid

$grid_posts = _get_field( 'mtm_grid_archive_manual' );
$taxonomy = mtm_acf_taxonomy_property( 'manual', 'taxonomy' ); ?>


<div <?php post_class( 'mtm-component--main' ); ?>>
	<h3 class="h1"><?php the_title(); ?><?php edit_post_link( '(Edit)', ' • ' ); ?></h3>
	<?php mtm_get_template_part( 'mtm-content', 'component-page' ); ?>
	<?php if( _get_field( 'mtm_show_taxonomy_links' ) ) {
		mtm_terms_from_taxonomy_links( $taxonomy ); // output taxonomy
	} ?>
</div>


<?php if( $grid_posts ) { ?>

	<div class="mtm-component--content mtm-grid--wrapper">
		<div class="gallery-dynamic-row">
	
			<?php foreach( $grid_posts as $post) { // variable must be called $post (IMPORTANT)
		
				setup_postdata( $post );

				mtm_get_template_part( 'mtm-content', 'grid-view' ); 

			} // end foreach ?>

		</div>
	</div>

	<?php wp_reset_postdata();

} // end grid_posts
<?php // Taxonomy Grid

global $mtm_grid_row_class;

$grid_query = mtm_taxonomy_query( 'grid' );
$taxonomy = mtm_acf_taxonomy_property( 'grid', 'taxonomy' ); 
$terms = mtm_acf_taxonomy_property( 'grid', 'slug' );
$mtm_grid_row_class = mtm_output_row_number();
$mtm_grid_module_class = 1 ;
?>

<div <?php post_class( 'mtm-component--main' ); ?>>
	<?php mtm_get_template_part( 'mtm-content', 'component-page' ); ?>
	<?php if( _get_field( 'mtm_show_taxonomy_links' ) ) {
		mtm_terms_from_taxonomy_links( $taxonomy ); // output taxonomy
	} ?>
</div>

<?php if( $grid_query->have_posts() ) { ?>

	<div class="mtm-component--content mtm-grid--wrapper">
		<div class="gallery-dynamic-row" >

			<?php while( $grid_query->have_posts() ) {
				
				$grid_query->the_post();

				mtm_get_template_part( 'mtm-content', 'grid-view' );
			}

			wp_reset_postdata(); ?>

		</div>
		<div class="expanded-gallery-single"></div>
	</div>

<?php } // end grid_query

if( _get_field( 'mtm_show_view_all_link' ) ) : ?>

	<a class="mtm-view-all-link" href="<?php echo get_site_url() . '/' . $taxonomy . '/'. $terms; ?>"><?php _e( 'View All', 'mtm' ); ?></a>

<?php endif; ?>
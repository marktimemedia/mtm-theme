<?php 
global $mtm_grid_row_class; 

$mtm_grid_row_class = mtm_output_row_number(); 
?>

<div class="mtm-grid--single load-this <?php echo $mtm_grid_row_class; ?>" data-uid="<?php the_ID(); ?>">
	<div class="mtm-grid--single-content">
		<?php the_mtm_post_thumbnail( 'medium_large', 'post--thumbnail mtm-grid--image' ); ?>
		<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
	</div>
</div>
<div class="mtm-grid--single load-this" data-uid="<?php the_ID(); ?>">
	<div class="mtm-grid--single-content">
		<?php the_mtm_post_thumbnail( 'medium_large', 'post--thumbnail mtm-grid--image' ); ?>
		<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
	</div>
</div>
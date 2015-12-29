<article class="mtm-list--single">

	<?php 
	$content_size = '-full';

	if ( has_post_thumbnail() ) : 
	$content_size = ''; ?>

		<section class="mtm-list--image">
		    <figure class="post--thumbnail mtm-list--image"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ) ?></a></figure>
		</section>

	<?php endif; ?>

	<section class="mtm-list--post-content<?php echo $content_size; ?>">
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="post--byline"><?php the_time( 'F j, Y' ); ?></p>
		<p><?php the_excerpt(); ?></p>
	</section>
</article>
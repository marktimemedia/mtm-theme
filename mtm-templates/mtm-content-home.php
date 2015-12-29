<section class="mtm-component mtm-component--home" style="background-image:url('<?php echo esc_url( mtm_acf_image_property( 'mtm_home_background_image', 'url' ) ); ?>')">

	<section class ="content--page">
	
		<h1><?php the_title(); ?></h1>
		<?php
		
		$home_post = get_post( get_the_ID() );
		echo apply_filters( 'the_content', $home_post->post_content );
		?>
		
		<?php if( _get_field( 'mtm_home_button_repeater' ) ) {
	    	mtm_get_template_part( 'mtm-content', 'home-buttons' );
	    } ?>
	    <div class="home-head-container">
			<?php if ( has_post_thumbnail() ) : ?>
	            <a href="#contact"><figure class="post--thumbnail home-head"><?php the_post_thumbnail( 'full' ) ?></figure></a>
	    	<?php endif; ?>
		</div>

	</section>

</section>
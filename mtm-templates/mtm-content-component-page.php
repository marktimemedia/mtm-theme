<?php // Standard Page Content 

$home_post = get_post( get_the_ID() );
echo apply_filters( 'the_content', $home_post->post_content );
?>
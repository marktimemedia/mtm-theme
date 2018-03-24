<?php
/**
 * Custom functions
 */
// Modifies default "Read More" behavior of the Excerpt

function new_excerpt_more( $more ) {
	return '... <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __('Read More', 'your-text-domain') . '</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );


// Modifies default Excerpt length

function custom_excerpt_length( $length ) {
	return 55; // default 55
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );



// Getting posts from taxonomy script
// Reference ajax-taxonomy-mtm.js
function mtm_ajax_filter_get_posts( $taxonomy ) {
 
  // Verify nonce
  if( !isset( $_GET['mtm_nonce'] ) || !wp_verify_nonce( $_GET['mtm_nonce'], 'mtm_nonce' ) )
    die('Nonce is not verified');

  // get taxonomy and term data from term id
  $taxonomy = $_GET['taxonomy'];
  $term_obj = get_term( $taxonomy );
  $term_slug = $term_obj->slug;
  $term_tax = $term_obj->taxonomy;

  // run query from function
  $ajax_query = mtm_page_component_taxonomy_query( $term_tax, $term_slug, 12, 'menu_order' );
 
  if ( $ajax_query->have_posts() ) : 

    while ( $ajax_query->have_posts() ) : $ajax_query->the_post();
    
      // template part
      mtm_get_template_part( 'mtm-content', 'grid-view' );
    
    endwhile;

    wp_reset_postdata();

  endif;
 
  die();
}
 
add_action('wp_ajax_filter_posts', 'mtm_ajax_filter_get_posts');
add_action('wp_ajax_nopriv_filter_posts', 'mtm_ajax_filter_get_posts');


function mtm_ajax_single_post( $postid ) {
  
  // Verify nonce
  if( !isset( $_GET['mtm_nonce'] ) || !wp_verify_nonce( $_GET['mtm_nonce'], 'mtm_nonce' ) )
    die('Nonce is not verified'); 

  // get taxonomy and term data from post id
  $postid = $_GET['postid'];

  $single_post = get_post( intval( $postid ) );

  global $post;
   
   // Assign your post details to $post (& not any other variable name!!!!)
    $post = $single_post;
   
    setup_postdata( $post );
 
      // template part
      get_template_part( 'templates/content', 'single-project-inside' );

    wp_reset_postdata();
 
  die();
}

add_action('wp_ajax_single_post', 'mtm_ajax_single_post');
add_action('wp_ajax_nopriv_single_post', 'mtm_ajax_single_post');
?>
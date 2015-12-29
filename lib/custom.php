<?php
/**
 * Custom functions
 */

//Comment out the following line to enable the admin bar
// add_filter('show_admin_bar', '__return_false');

add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
    $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
    return $html;
}

// Add and Modify Image Sizes
//add_image_size( 'custom_size', 1800, 1800 );

// Gets rid of current_page_parent class mistakenly being applied to Blog pages while on Custom Post Types
// via https://wordpress.org/support/topic/post-type-and-its-children-show-blog-as-the-current_page_parent

function is_blog() {
	global $post;
	$posttype = get_post_type( $post );
	return ( ( $posttype == 'post' ) && ( is_home() || is_single() || is_archive() || is_category() || is_tag() || is_author() ) ) ? true : false;
}

function fix_blog_link_on_cpt( $classes, $item, $args ) {
	if( !is_blog() ) {
		$blog_page_id = intval( get_option('page_for_posts') );
		if( $blog_page_id != 0 && $item->object_id == $blog_page_id )
			unset( $classes[ array_search( 'current_page_parent', $classes ) ] );
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'fix_blog_link_on_cpt', 10, 3 );


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


//Custom Taxonomy Term Links
//From http://codex.wordpress.org/Function_Reference/get_the_terms
// echo custom_taxonomies_terms_links(); in your template file

// get taxonomies terms links
function custom_taxonomies_terms_links(){
  // get post by post id
  $post = get_post( $post->ID );

  // get post type by post
  $post_type = $post->post_type;

  // get post type taxonomies
  $taxonomies = get_object_taxonomies( $post_type, 'objects' );

  $out = array();
  foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

    // get the terms related to post
    $terms = get_the_terms( $post->ID, $taxonomy_slug );

    if ( !empty( $terms ) ) {
      $out[] = '<span class="post--metadata--title">' . $taxonomy->label . ': </span><ul>';
      foreach ( $terms as $term ) {
        $out[] =
          '  <li><a href="'
        .    get_term_link( $term->slug, $taxonomy_slug ) .'" data-id="'. $term->term_id. '">'
        .    $term->name
        . "</a></li>\n";
      }
      $out[] = "</ul>\n";
    }
  }

  return implode( '', $out );
}


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
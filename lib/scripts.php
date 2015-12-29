<?php
/**
 * Enqueue scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/assets/css/main.min.css
 *
 * Enqueue scripts in the following order:
 * 1. jquery via WordPress
 * 2. /theme/assets/js/vendor/modernizr-2.7.0.min.js
 * 3. /theme/assets/js/main.min.js (in footer)
 */
function spring_scripts() {
    wp_enqueue_style('spring_main', get_template_directory_uri() . '/style.css', false);


    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_register_script('modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr-2.7.0.min.js', false, null, false);
    wp_enqueue_script('modernizr');
    wp_enqueue_script('jquery');
    wp_enqueue_script('spring_scripts');
    wp_enqueue_script('spring_app', get_template_directory_uri() . '/assets/js/build/spring-production-no-sidebar.js','', '', true);
    wp_enqueue_script( 'header-mtm', get_template_directory_uri() . '/assets/js/header-mtm.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'smooth-scroll-mtm', get_template_directory_uri() . '/assets/js/smooth-scroll-mtm.js', array( 'jquery' ), false, true );
    wp_register_script( 'ajax-taxonomy-mtm', get_template_directory_uri() . '/assets/js/ajax-taxonomy-mtm.js', false, null, true );
    
    if (is_front_page()) {
        wp_enqueue_script( 'ajax-taxonomy-mtm' );

        wp_localize_script( 'ajax-taxonomy-mtm', 'mtm_vars', array(
            'mtm_nonce' => wp_create_nonce( 'mtm_nonce' ), // Create nonce which we later will use to verify AJAX request
            'mtm_ajax_url' => admin_url( 'admin-ajax.php' ),
          )
      );

    }

}

add_action('wp_enqueue_scripts', 'spring_scripts', 100);



<?php
/**
 * Enqueue child styles.
 */
function child_enqueue_styles() {
	wp_enqueue_style( 'child-theme', get_stylesheet_directory_uri() . '/style.css', array(), 100 );
}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles' ); 

/**
 * Add custom functions here
 */


// Inject the list of categories after the title
add_action( 'tribe_template_before_include:events/v2/list/event/title', function() {
    global $post;
    ?>
    <ul class='tribe-event-categories'>
        <?php echo tribe_get_event_taxonomy( $post->ID ); ?>
    </ul>
    <?php
} );


// Custom excerpt length

add_filter( 'excerpt_length', 'tec_custom_excerpt_length', 999 );

function tec_custom_excerpt_length( $words ) {
	
	$words = 45; // change this value to set the number of words
	
	return $words;

}


// PMPro action redirecting user to home page after logging out rather than to wp-admin page

add_action('wp_logout','auto_redirect_after_logout');
function auto_redirect_after_logout(){
wp_safe_redirect( home_url() );
exit();
}


// Disable comments (from whttps://www.wpbeginner.com/wp-tutorials/how-to-completely-disable-comments-in-wordpress/#completely-disable-comments)

add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
     
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }
 
    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
 
    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});
 
// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
 
// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);
 
// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
 
// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});




/**
 * Hide the Confirm Email and Confirm Password Fields on the checkout page.
 *
 * title: Hide the Confirm Email and Confirm Password Fields
 * layout: snippet
 * collection: checkout
 * category: ui
 *
 * Hide the Confirm Email and Confirm Password Fields on the checkout page.
 * 
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

 add_filter( 'pmpro_checkout_confirm_password', '__return_false' );
 add_filter( 'pmpro_checkout_confirm_email', '__return_false' );
 

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


/*
 * EXAMPLE OF CHANGING ANY TEXT (STRING) IN THE EVENTS CALENDAR
 * See the codex to learn more about WP text domains:
 * http://codex.wordpress.org/Translating_WordPress#Localization_Technology
 * Example Tribe domains: 'tribe-events-calendar', 'tribe-events-calendar-pro'...
 */
 
/**
 * Put your custom text here in a key => value pair
 * Example: 'Text you want to change' => 'This is what it will be changed to'.
 * The text you want to change is the key, and it is case-sensitive.
 * The text you want to change it to is the value.
 * You can freely add or remove key => values, but make sure to separate them with a comma.
 * This example changes the label "Venue" to "Location", "Related Events" to "Similar Events", and "(Now or date) onwards" to "Calendar - you can discard the dynamic portion of the text as well if desired.
*/
function tribe_replace_strings() {
    $custom_text = [
        'Zip Code' => 'Postcode',
        'Venue' => 'Location',
    ];
 
    return $custom_text;
}
 
 
 
function tribe_custom_theme_text ( $translation, $text, $domain ) {
    // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
    if ( ! check_if_tec_domains( $domain ) ) {
        return $translation;
    }
 
    // String replacement.
    $custom_text = tribe_replace_strings();
 
    // If we don't have replacement text in our array, return the original (translated) text.
    if ( empty( $custom_text[$translation] ) ) {
        return $translation;
    }
 
    return $custom_text[$translation];
}
 
 
 
function tribe_custom_theme_text_plurals ( $translation, $single, $plural, $number, $domain ) {
    // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
    if ( ! check_if_tec_domains( $domain ) ) {
        return $translation;
    }
 
    /** If you want to use the number in your logic, this is where you'd do it.
     * Make sure you return as part of this, so you don't call the function at the end and undo your changes!
     */
 
    // If we're not doing any logic up above, just make sure your desired changes are in the $custom_text array above (in the `tribe_custom_theme_text` filter. )
    if ( 1 === $number ) {
        return tribe_custom_theme_text ( $translation, $single, $domain );
    } else {
        return tribe_custom_theme_text ( $translation, $plural, $domain );
    }
}
 
 
 
function tribe_custom_theme_text_with_context ( $translation, $text, $context, $domain ) {
    // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
    if ( ! check_if_tec_domains( $domain ) ) {
        return $translation;
    }
 
    /** If you want to use the context in your logic, this is where you'd do it.
     * Make sure you return as part of this, so you don't call the function at the end and undo your changes!
     * Example (here, we don't want to do anything when the context is "edit", but if it's "view" we want to change it to "Tribe"):
     * if ( 'edit' === strtolower( $context ) ) {
     *    return $translation;
     * } elseif( 'view' === strtolower( $context ) ) {
     *    return "Tribe";
     * }
     *
     * Feel free to use the same logic we use in tribe_custom_theme_text() above for key => value pairs for this logic.
     */
 
    // If we're not doing any logic up above, just make sure your desired changes are in the $custom_text array above (in the `tribe_custom_theme_text` filter. )
    return tribe_custom_theme_text ( $translation, $text, $domain );
}
 
 
 
function tribe_custom_theme_text_plurals_with_context ( $translation, $single, $plural, $number, $context, $domain ) {
    // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
    if ( ! check_if_tec_domains( $domain ) ) {
        return $translation;
    }
 
    /**
     * If you want to use the context in your logic, this is where you'd do it.
     * Make sure you return as part of this, so you don't call the function at the end and undo your changes!
     * Example (here, we don't want to do anything when the context is "edit", but if it's "view" we want to change it to "Tribe"):
     * if ( 'edit' === strtolower( $context ) ) {
     *    return $translation;
     * } elseif( 'view' === strtolower( $context ) ) {
     *    return "cat";
     * }
     *
     * You'd do something as well here for singular/plural. This could get complicated quickly if it has to interact with context as well.
     * Example:
     * if ( 1 === $number ) {
     *    return "cat";
     * } else {
     *    return "cats";
     * }
     * Feel free to use the same logic we use in tribe_custom_theme_text() above for key => value pairs for this logic.
     */
 
    // If we're not doing any logic up above, just make sure your desired changes are in the $custom_text array above (in the `tribe_custom_theme_text` filter. )
    if ( 1 === $number ) {
        return tribe_custom_theme_text ( $translation, $single, $domain );
    } else {
        return tribe_custom_theme_text ( $translation, $plural, $domain );
    }
}
 
function check_if_tec_domains( $domain ) {
    $is_tribe_domain = strpos( $domain, 'tribe-' )      === 0;
    $is_tec_domain   = strpos( $domain, 'the-events-' ) === 0;
    $is_event_domain = strpos( $domain, 'event-' )      === 0;
 
    // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
    if ( ! $is_tribe_domain && ! $is_tec_domain && ! $is_event_domain ) {
        return false;
    }
 
    return true;
}
 
// Base.
add_filter( 'gettext', 'tribe_custom_theme_text', 20, 3 );
// Plural-aware translations.
add_filter( 'ngettext', 'tribe_custom_theme_text_plurals', 20, 5 );
// Translations with context.
add_filter( 'gettext_with_context', 'tribe_custom_theme_text_with_context', 20, 4 );
// Plural-aware translations with context.
add_filter( 'ngettext_with_context', 'tribe_custom_theme_text_plurals_with_context', 20, 6 );
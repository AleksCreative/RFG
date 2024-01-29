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


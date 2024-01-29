<?php
/**
 * The main single item template file.
 *
 * @package kadence
 */

namespace Kadence;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

kadence()->print_styles( 'kadence-content' );
/**
 * Hook for everything, makes for better elementor theming support.
 */
do_action( 'kadence_single' );

?>
<div class="kb-theme-content-width content-container site-container">

 <!-- --------------- Past events custom query---------------------------------- -->

 <?php
     global $post;

     $get_posts = tribe_get_events(array('posts_per_page'=>100, 'eventDisplay'=>'past', 'paged'=>'paged') );

     foreach($get_posts as $post) { setup_postdata($post);
 ?>

<?php if ( has_post_thumbnail() ) { ?> 

 

    <div class="previous-event-list-item">
 
        <div class="previous-event-date-box">
            <div class="past-events-date-box-items">
                <h3><?php echo tribe_get_start_date( $post->ID, false, 'j ' ); ?></h3>
                <p><?php echo tribe_get_start_date( $post->ID, false, 'M Y' ); ?></p>

            </div><!-- past-events-date-box-items -->
        </div><!-- previous-event-date-box -->

        <div class="previous-event-content-box past-events-list-styles"><hr class="past-events">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
             <?php if( get_field('event_subheading') ): ?>
            <h5><?php the_field('event_subheading'); ?></h5>
            <?php endif; ?>
            <?php the_excerpt(); ?>
        </div>

    </div>

    <div class="clear"></div>

 <?php } else { ?>
 
    <div class="previous-event-content-box">
         <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
         <?php the_content(); ?>
    </div>

     <div class="clear"></div>
 
 <?php } ?>
 

 <?php } //endforeach ?>

     

 <?php wp_reset_query(); ?>

<!-- --------------------------------------------------------------------------- -->	

</div><br><br>
<?php

get_footer();

<?php
/**
 * View: List View
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list.php
 *
 * See more documentation about our views templating system.
 *
 * @link    http://evnt.is/1aiy
 *
 * @since   6.1.4 Changing our nonce verification structures.
 *
 * @version 6.2.0
 * @since 6.2.0 Moved the header information into a new components/header.php template.
 *
 * @var array    $events               The array containing the events.
 * @var string   $rest_url             The REST URL.
 * @var string   $rest_method          The HTTP method, either `POST` or `GET`, the View will use to make requests.
 * @var int      $should_manage_url    int containing if it should manage the URL.
 * @var bool     $disable_event_search Boolean on whether to disable the event search.
 * @var string[] $container_classes    Classes used for the container of the view.
 * @var array    $container_data       An additional set of container `data` attributes.
 * @var string   $breakpoint_pointer   String we use as pointer to the current view we are setting up with breakpoints.
 */

$header_classes = [ 'tribe-events-header' ];
if ( empty( $disable_event_search ) ) {
	$header_classes[] = 'tribe-events-header--has-event-search';
}

?>
<div
	<?php tribe_classes( $container_classes ); ?>
	data-js="tribe-events-view"
	data-view-rest-url="<?php echo esc_url( $rest_url ); ?>"
	data-view-rest-method="<?php echo esc_attr( $rest_method ); ?>"
	data-view-manage-url="<?php echo esc_attr( $should_manage_url ); ?>"
	<?php foreach ( $container_data as $key => $value ) : ?>
		data-view-<?php echo esc_attr( $key ) ?>="<?php echo esc_attr( $value ) ?>"
	<?php endforeach; ?>
	<?php if ( ! empty( $breakpoint_pointer ) ) : ?>
		data-view-breakpoint-pointer="<?php echo esc_attr( $breakpoint_pointer ); ?>"
	<?php endif; ?>
>
	<div class="tribe-common-l-container tribe-events-l-container">
		<?php $this->template( 'components/loader', [ 'text' => __( 'Loading...', 'the-events-calendar' ) ] ); ?>

		<?php $this->template( 'components/json-ld-data' ); ?>

		<?php $this->template( 'components/data' ); ?>
<div class="events-hero">
	
	<div class="hero-title"><h1 class="entry-title">Events</h1></div>
	<div class="hero-tagline-entry"><h2 class="post-subheading">Our Zoom-ins on Roman finds and Archaeological Conferences</h2></div>
	<p class="image-credits-general-events">Cintusmus the Copper-smith inscription detail. Image Credit Colchester Museums</p>
</div>
		<?php $this->template( 'components/before' );  ?>

		

	 <?php  $this->template( 'components/filter-bar' );  ?> 
	 
		<div class="tribe-events-calendar-list">
		<br><br><h2>Upcoming events</h2><br>
			<?php foreach ( $events as $event ) : ?>
				<?php $this->setup_postdata( $event ); ?>

				<?php /* $this->template( 'list/month-separator', [ 'event' => $event ] ); */ ?>

				<?php  $this->template( 'list/event', [ 'event' => $event ] );  ?>

			<?php endforeach; ?>
			<?php $this->template( 'list/nav' ); ?>

			<?php /* $this->template( 'components/ical-link' ); */?>


		</div>
		<div class="tribe-previous-events-calendar-list-container">
		<div class="tribe-previous-events-calendar-list">
			<?php $this->template( 'components/after' ); ?>		

			<br><h2>Past events</h2><br>
					

<!-- --------------- Past events custom query---------------------------------- -->

				<?php
					global $post;

					$get_posts = tribe_get_events(array('posts_per_page'=>8, 'eventDisplay'=>'past') );

					foreach($get_posts as $post) { setup_postdata($post);
        		?>
        
			<?php if ( has_post_thumbnail() ) { ?> 
		
				
            
				<div class="previous-event-list-item">
				
					<div class="previous-event-date-box">
						<div class="past-events-date-box-items">
						<h3><?php echo tribe_get_start_date( $post->ID, false, 'j ' ); ?></h3>
						<p><?php echo tribe_get_start_date( $post->ID, false, 'M Y' ); ?></p>

						</div>

					</div>

					<div class="previous-event-content-box"><hr class="past-events"><br>
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

<div class="view-more"><p><a href="<?php site_url(); ?>/past-events/" >View more ></a></p></div>
					
		</div><br><br>
			</div>

		
	</div>
</div>

<?php $this->template( 'components/breakpoints' ); ?>

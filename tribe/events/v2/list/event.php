<?php
/**
 * View: List Event
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

$container_classes = [ 'tribe-common-g-row', 'tribe-events-calendar-list__event-row' ];
$container_classes['tribe-events-calendar-list__event-row--featured'] = $event->featured;

$event_classes = tribe_get_post_class( [ 'tribe-events-calendar-list__event', 'tribe-common-g-row', 'tribe-common-g-row--gutters' ], $event->ID );
?>



<div class="events-list-classes-override">


		<article>
			<?php $this->template( 'list/event/featured-image', [ 'event' => $event ] ); ?>
			<div class="event-list-content-override">

				<header class="tribe-events-calendar-list__event-header">
				
				<?php $this->template( 'list/event/title', [ 'event' => $event ] ); ?>
				<?php if( get_field('event_subheading') ): ?>
   				 <h5><?php the_field('event_subheading'); ?></h5>
				<?php endif; ?>
				</header>

				<?php $this->template( 'list/event/description', [ 'event' => $event ] ); ?>
				<p class="event-list-ticket-price">Ticket: <?php echo esc_html( get_field('event-price') ); ?></p>
				<button class="find-out"><a
		href="<?php echo esc_url( $event->permalink ); ?>"
		title="<?php echo esc_attr( $event->title ); ?>"
		rel="bookmark">
	Find out more</a></button>
			</div>
			
			<div class="event-date-location-box">

				<?php $this->template( 'list/event/date-tag', [ 'event' => $event ] ); ?>
				<?php $this->template( 'list/event/venue', [ 'event' => $event ] ); ?>

			</div>

		</article>
	



</div>

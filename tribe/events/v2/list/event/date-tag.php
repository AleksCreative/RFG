<?php
/**
 * View: List View - Single Event Date Tag
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event/date-tag.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.0.0
 *
 * @var WP_Post            $event        The event post object with properties added by the `tribe_get_event` function.
 * @var \DateTimeInterface $request_date The request date object. This will be "today" if the user did not input any
 *                                       date, or the user input date.
 * @var bool               $is_past      Whether the current display mode is "past" or not.
 *
 * @see tribe_get_event() For the format of the event object.
 */

use Tribe__Date_Utils as Dates;

/*
 * If the request date is after the event start date, show the request date to avoid users from seeing dates "in the
 * past" in relation to the date they requested (or today's date).
 */
$display_date = empty( $is_past ) && ! empty( $request_date )
	? max( $event->dates->start_display, $request_date )
	: $event->dates->start_display;

$event_week_day  = $display_date->format_i18n( 'D' );
$event_day_num   = $display_date->format_i18n( 'j' );
$event_month_name   = $display_date->format_i18n( 'F' );
$event_year   = $display_date->format_i18n( 'Y' );
$event_date_attr = $display_date->format( Dates::DBDATEFORMAT );
?>
<div class="tribe-events-calendar-list__event-date-tag tribe-common-g-col">
	<time class="tribe-events-calendar-list__event-date-tag-datetime" datetime="<?php echo esc_attr( $event_date_attr ); ?>" aria-hidden="true">

		<span class="event-date-day-override">
			<?php echo esc_html( $event_day_num ); ?>
		</span>
		<span class="event-date-month-override">
			<?php echo esc_html( $event_month_name ); ?>
		</span>
		<span class="event-date-year-override">
			<?php echo esc_html( $event_year ); ?>
		</span>
	</time>
</div>

<?php
/**
 * Template part for displaying a post's Hero header
 *
 * @package kadence
 */

namespace Kadence;

$classes   = array();
$classes[] = 'entry-header';
if ( is_singular( get_post_type() ) ) {
	$classes[] = get_post_type() . '-title';
	$classes[] = 'title-align-' . ( kadence()->sub_option( get_post_type() . '_title_align', 'desktop' ) ? kadence()->sub_option( get_post_type() . '_title_align', 'desktop' ) : 'inherit' );
	$classes[] = 'title-tablet-align-' . ( kadence()->sub_option( get_post_type() . '_title_align', 'tablet' ) ? kadence()->sub_option( get_post_type() . '_title_align', 'tablet' ) : 'inherit' );
	$classes[] = 'title-mobile-align-' . ( kadence()->sub_option( get_post_type() . '_title_align', 'mobile' ) ? kadence()->sub_option( get_post_type() . '_title_align', 'mobile' ) : 'inherit' );
}
?>
<section role="banner" class="entry-hero <?php echo esc_attr( get_post_type() ) . '-hero-section'; ?> <?php echo esc_attr( 'entry-hero-layout-' . kadence()->option( get_post_type() . '_title_inner_layout' ) ); ?>">
	<div class="entry-hero-container-inner">
		<div class="hero-section-overlay">
		<p class="image-credits-general"><?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); ?></p>
		</div>
		<div class="hero-container site-container">
			<header class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
				<?php
				/**
				 * Kadence Entry Hero
				 *
				 * Hooked kadence_entry_header 10
				 */
				do_action( 'kadence_entry_hero', get_post_type(), 'above' );
				?><div class="hero-tagline-entry">				<!-- Subheading from ACF -->
				<?php if( get_field('post_subheading') ): ?>
   				 <h2 class="post-subheading"><?php the_field('post_subheading'); ?></h2>
				<?php endif; ?></div>
			</header><!-- .entry-header -->
		</div>
	</div>
</section><!-- .entry-hero -->

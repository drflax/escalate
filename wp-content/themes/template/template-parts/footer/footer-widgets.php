<?php
/**
 * Displays the footer widget area.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
<section class="widgets-section">
	<div class="contener grid-four">
		<div><?php dynamic_sidebar( 'sidebar-1' ); ?></div>
		<div><?php dynamic_sidebar( 'sidebar-2' ); ?></div>
		<div><?php dynamic_sidebar( 'sidebar-3' ); ?></div>
		<div><?php dynamic_sidebar( 'sidebar-4' ); ?></div>
	</div>
</section>

	<?php
endif;

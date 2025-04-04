<?php
/**
 * Template Name: privacy
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage template
 * @since teamplate 1.0
 */

get_header();
?>

<section class="dark-grey-background">
  <div class="contener yellowbuilding padding-140">
	<h1>
		<?php the_title(); ?>
	  </h1>
    <?php the_content(); ?>
  </div>
</section>


<?php get_footer(); ?>
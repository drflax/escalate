<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->

	<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

	<footer id="colophon" class="site-footer">
		<div class="contener">
			<div class="site-info">

				<div class="powered-by">
					<a class="privacy-policy-link" href="<?php echo esc_url( home_url( '/' ) ); ?>privacy-policy/" rel="privacy-policy">Privacy Policy</a> <span>|</span> This site is powered by renewables <span>|</span> Website by <a href="https://agency.revolve.media" target="_blank" title="REVOLVE"><img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/template/assets/images/REVOLVE.svg" class="revolve_logo"></a>
				</div><!-- .powered-by -->

			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

<script>
function checkElementLocation() {
  var $window = $(window);
  var bottom_of_window = $window.scrollTop() + $window.height();

  $(".elem").each(function (i) {
    var $that = $(this);
    var bottom_of_object = $that.position().top + $that.outerHeight();

    //if element is in viewport, add the animate class
    if (bottom_of_window > bottom_of_object) {
      $(this).addClass("fade-in");
    }
  });
}
// if in viewport, show the animation
checkElementLocation();

$(window).on("scroll", function () {
  checkElementLocation();
});
</script>

</body>
</html>

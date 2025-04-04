<?php
/**
 * Template Name: Homepage
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage template
 * @since teamplate 1.0
 */

get_header();
?>

<section class="dark-grey-background home">
  <div class="contener full-height gradienbuilding">
    <h1 class="elem to-fade-in">Accelerating Europe’s Clean Energy Future by Empowering Cities for Efficient Heating and Cooling.</h1>
  </div>
</section>


<section class="blue-background golden">
  <div class="contener greybuilding padding-140">
      <p class="first elem to-fade-in">
        The ESCALATE Project aims to speed up Europe’s shift to clean renewable energy by helping cities across the EU plan for more energy efficient heating and cooling. 
      </p> 
      <p class="second elem to-fade-in">
        The project focuses on towns with over <strong>45,000</strong> people, ensuring they have the tools and knowledge to create local heating and cooling plans that reduce energy use and support the environment.
      </p>
      <p class="last elem to-fade-in">
        ESCALATE empowers local communities to make their buildings sustainable, reduce pollution, and help Europe become <strong>climate-neutral by 2050</strong> by providing expert training and a clear, easy-to-follow guide.
      </p>
  </div>
</section>

<section id="newsletter">
  <div class="contener yellowbuilding padding-140">
    <div class="text-center padding-bottom-140">
      <h2 class="elem to-fade-in">Partners</h2>
      <div class="partners-grid">
        <?php if( have_rows('partners') ): ?>
            <?php while( have_rows('partners') ): the_row(); 
                $image = get_sub_field('logo');
                $link = get_sub_field('partner_link');
                ?>
                <div class="single-partner elem to-fade-in" style="background-image:url(<?php echo $image; ?>);">
                  <a href="<?php echo $link; ?>" target="_blank"></a>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-grid">
      <div>
        <h3 class="elem to-fade-in">Want to <strong>join the community</strong> and <strong>stay up to date</strong> about this project?</h3>
      </div>
      <div class="elem to-fade-in">
        <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/embed/v2.js"></script>
<script>
  hbspt.forms.create({
    portalId: "4202411",
    formId: "daae44c3-0bb4-48d4-9320-59a273a97beb"
  });
</script>
      </div>
    </div>
    
  </div>
</section>


<?php get_footer(); ?>
<?php
/*
 Template Name: Archive
*/
?>

<?php get_header(); ?>

<main role="main" class="wrapper">

  <section class="mobile-info hide-desktop container" id="mobile_info">
    <div class="cross-icon"><div class="cross-icon-inner"><img src="<?php echo get_template_directory_uri(); ?>/library/img/cross_icon.svg"></div></div>
    <p>
      Graphic and Media Design<br>
      Degree Show 2018
      <br><br>
      Wednesday 20 –<br>
      Saturday 23 June
    </p>
    <?php the_field('overlay_info'); ?>
  </section>

  <!-- Landing -->
  <section id="landing">
    <div class="container">
      <div id="landing_inner">
        <div class="row">
          <span class="exhibition-title-word col8"><?php $title = the_field('title_word_1'); ?></span>
          <div class="cross-icon col4"><div class="cross-icon-inner"><img src="<?php echo get_template_directory_uri(); ?>/library/img/cross_icon.svg"></div></div>
        </div>
        <div class="row">
          <span class="exhibition-title-word offset3 col5"><?php $title = the_field('title_word_2'); ?></span>
          <p class="exhibition-info col4">
            <?php the_field('year'); ?>
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- /Landing -->


<?php get_footer(); ?>

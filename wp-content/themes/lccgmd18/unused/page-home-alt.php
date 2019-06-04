<?php
/*
 Template Name: Homepage Alt
*/
?>

<?php get_header(); ?>

<script>alt = true;</script>

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
            <?php the_field('exhibition_info'); ?>
            <a href="#exhibition">More Info</a><span class="arrow"> →</span>
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- /Landing -->

  <!-- Thumbnails -->
  <section id="thumbnails">
    <div class="container row">
      <?php
        $args = [
          'posts_per_page' => -1,
          'post_type' => 'post',
          'orderby'          => 'rand',          //<-- Our custom ordering!
          'order'            => 'ASC',
          'post_status' => 'publish'
        ];

        $posts = new WP_Query( $args );
        $index = 0;

        while ($posts->have_posts()): $posts->the_post(); ?>
          <?php $image = get_field('featured_image');

            $r = rand(0, 6);
            $r2 = rand(0, 2);
            $i = 0;
          ?>
            <?php if($image): ?>
              <?php while($i < $r2): ?>
                <?php $z = rand(0, 6); if($z > 5): ?>
                  <div class='thumb col4'></div>
                <?php else: ?>
                  <div class='thumb col2'></div>
                <?php endif; ?>
              <?php $i++; endwhile; ?>

              <?php if($r > 5 && $index < 90): ?>
                <div class='thumb col4'><a href="<?php the_permalink(); ?>"><img src="<?php echo $image['sizes']['student-thumb-large']; ?>" alt="<?php the_title(); ?>"></a></div>
              <?php else: ?>
                <div class='thumb col2'><a href="<?php the_permalink(); ?>"><img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php the_title(); ?>"></a></div>
              <?php $index++; endif; ?>
            <?php endif; ?>
        <?php endwhile; wp_reset_query();?>

        <div class="crosses">
          <img src="<?php echo get_template_directory_uri(); ?>/library/img/circle_icon_blue.svg">
        </div>
    </div>

    <div id="thumbnail-icons">
      <button onclick="scrollTo(document.body, 0, 750);" class="to-top">↑</button>
      <a href="#index" class="index-icon"><img src="<?php echo get_template_directory_uri(); ?>/library/img/index_icon.svg"></a>
    </div>
  </section>
  <!-- /thumbnails -->

  <dialog class="overlay" id="exhibition">
    <header class="row container">
      <div class="left-nav col6">
        <a href="/">Graphic and Media Design<br>
        Degree Show 2018</a>
      </div>

      <div class="right-nav col6">
        <button onclick="toggleOverlay('exhibition');"><img src="<?php echo get_template_directory_uri(); ?>/library/img/close_overlay.svg"></button>
      </div>
    </header>

    <div class="container row overlay-inner">
      <div class="col3 overlay-info">
        <?php the_field('overlay_info'); ?>
      </div>
      <div class="col3 offset3">
        <?php if( have_rows('credits') ): ?>
        	<?php $i = 1; while( have_rows('credits') && $i < 6 ): the_row(); $creditTitle = get_sub_field('credit_title'); ?>
            <div class="credit">
              <span class="credit-title"><?php echo $creditTitle ?></span>
              <?php if( have_rows('credit_names') ): ?>
                <?php while( have_rows('credit_names') ): the_row(); $name = get_sub_field('credit_name');?>
                    <span class="credit-name"><?php echo $name ?></span>
                <?php endwhile; ?>
              <?php endif; ?>
            </div>
        	<?php $i++; endwhile; ?>
        <?php endif; ?>
      </div>
      <div class="col3">
        <?php if( have_rows('credits') ): ?>
          <?php while( have_rows('credits') ): the_row(); $creditTitle = get_sub_field('credit_title'); ?>
            <div class="credit">
              <span class="credit-title"><?php echo $creditTitle ?></span>
              <?php if( have_rows('credit_names') ): ?>
                <?php while( have_rows('credit_names') ): the_row(); $name = get_sub_field('credit_name');?>
                    <span class="credit-name"><?php echo $name ?></span>
                <?php endwhile; ?>
              <?php endif; ?>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>
        <div class="credit">
          <?php the_field('extra_credits'); ?>
        </div>
      </div>
    </div>
  </dialog>

<?php get_footer(); ?>

<?php
/*
 Template Name: Homepage
*/
?>

<?php get_header(); ?>

<main role="main" class="wrapper">

  <section class="mobile-info hide-desktop container" id="mobile_info">
   <div class="cross-icon"><div class="cross-icon-inner slash"></div></div>
    <p>
      Graphic and Media Design<br>
      Degree Show 2018
      <br><br>
      Wednesday 20 –<br>
      Saturday 23 June
    </p>
    <?php the_field('overlay_info'); ?>
  </section>

  <!-- Top section -->
  <!-- Landing -->
  <section id="landing">
    <div class="container">
      <div id="landing_inner">
        <div class="row">
          <span class="exhibition-title-word col8"><?php $title = the_field('title_word_1'); ?></span>
          <div class="cross-icon col4"><div class="cross-icon-inner slash">/</div></div>
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

  <!-- Categories -->
  <section id="categories" class="unsticky">
    <div class="categories container row">
      <?php
      $allcategories = get_categories();
      ?>
      <div class="categorylist">
        <div id="filters" class="button-group filter-button-group">
          <button class="button is-checked all" data-filter="*">All</button><span class="categoryslash">/</span>
          <?php
          $numItems = count($allcategories);
          $i = 0;
          foreach ($allcategories as $category) {
            // we remove the last category 'uncategorised'
            // in functions.php we hide 'uncategorised' from the wpadmin area
            if ($category->slug != 'uncategorised'){
              print '<button class="button ' . $category->slug . '" data-filter=".' . $category->slug . '">' . $category->name. '</button>';
              if(++$i !== $numItems-1) {
                print '<span class="categoryslash">/</span> ';
              }
            }
          }
          ?>
        </div>
      </div>
    </div>
  </section>
  <!-- /Categories -->
  <!-- Thumbnails -->
  <section id="thumbnails">
    <div class="container row">
      <div class="grid">
      <?php
        $args = [
          'posts_per_page' => -1,
          'post_type' => 'post',
          'orderby'          => 'title',          //<-- Our custom ordering!
          'order'            => 'ASC',
          'post_status' => 'publish'
        ];
        $posts = new WP_Query( $args );
        while ($posts->have_posts()): $posts->the_post();

        // print_r("<pre>");
        // print_r($posts);
        // print_r("</pre>");
        $categories = get_the_category(get_the_id());
        // print_r("<pre>");
        // print_r($categories);
        // print_r("</pre>");
        $category_classes = '';
        foreach ($categories as $category) {
          // print_r("<pre>");
          // print_r($category->slug);
          if ($category->slug != 'uncategorised'){
            $category_classes .= $category->slug . ' ';
          }
          // print_r("</pre>");
        }


        ?>
          <?php $image = get_field('featured_image');
          // print_r("<pre>");
          // // print_r(get_the_id());
          // print_r(get_the_category(get_the_id()));
          // print_r("</pre>");
            $i = 0;
            $thing = 'not set';
          ?>
            <?php if($image && get_the_ID() != 17035):
              $imageurl = $image['sizes']['thumbnail'];

              $filetype = wp_check_filetype($imageurl);

              if ($filetype[ext] == 'gif'){
                $thing = 'gif';
                $imageurl = $image['url'];
                // print '<pre>';
                // print_r($image);
                // print '</pre>';
              } else{
                  $thing = 'notgif';
              }
              ?>
            <a class="home-grid-item" href="<?php the_permalink(); ?>">
              <div class="grid-item <?php print $category_classes ?>"  data-category="lanthanoid" style="background-image: url('<?php echo $imageurl ?>')" alt="<?php the_title(); ?>')">
                <div class='student'>
                  <div class="home-studentname">
                    <span class="studentslash">/</span><?php the_title(); ?>
                  </div>
                  <div class="home-studentcategories">
                    <ul>
                      <?php
                      foreach ($categories as $category) {
                        if ($category->slug != 'uncategorised'){
                          // print_r("<pre>");
                          // print_r($category->slug);
                          print "<li>";
                          print $category->name;
                          print "</li>";
                        }
                      }
                      ?>
                    </ul>
                  </div>
              </div>
            </div>
            </a>
            <?php endif; ?>
        <?php endwhile; wp_reset_query();?>

        <div class="crosses">
          <img src="<?php echo get_template_directory_uri(); ?>/library/img/circle_icon_blue.svg">
        </div>
      </div>
    </div>

    <!-- <div id="thumbnail-icons">
      <button onclick="scrollTo(document.body, 0, 750);" class="to-top">↑</button>
      <a href="#index" class="index-icon"><img src="<?php echo get_template_directory_uri(); ?>/library/img/index_icon.svg"></a>
    </div> -->
  </section>
  <!-- /thumbnails -->

  <dialog class="overlay" id="exhibition">
    <header class="row container">
      <div class="left-nav col6">
        <a href="/">Graphic and Media Design<br>
        Degree Show 2018</a>
      </div>

      <div class="right-nav col6 closebutton">
        <button onclick="toggleOverlay('exhibition');"><img src="<?php echo get_template_directory_uri(); ?>/library/img/close_x.svg"></button>
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

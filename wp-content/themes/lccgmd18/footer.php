<dialog class="overlay" id="index">
  <header class="row container">
    <div class="left-nav col6">
      <a href="/">Graphic and Media Design<br>
      Degree Show 2018</a>
    </div>

    <div class="right-nav col6">
      <button class="header-icon" onclick="toggleOverlay('index');"><img src="<?php echo get_template_directory_uri(); ?>/library/img/close_x.svg"></button>
    </div>
    <!--<button class="header-icon hide-desktop filter-icon"><img src="<?php echo get_template_directory_uri(); ?>/library/img/filter_icon.svg"></button> -->

    <select onchange="selectFilter(this)" class="hide-desktop mobile-header-title">
      <option class="mobile-filter" value="filter">Filter</option>
      <?php
        $categories = get_categories( array(
          'orderby' => 'name',
          'parent'  => 0
        ) );

        foreach ( $categories as $category ) {
          if ($category->cat_name != 'Uncategorised') {
            echo "<option class='mobile-filter' value=\"$category->name\">$category->name</option>";
          }
        }
      ?>
    </select>
  </header>

  <div class="container">
    <div class="index-inner index-categories">
      <?php
        $numItems = count($categories);
        $i = 0;
        foreach ( $categories as $category ) {
          if ($category->cat_name != 'Uncategorised') {
            print "<div class='index-el index-el-filter'><button onclick='filterIndex(\"$category->name\", this);'>$category->name</a></div>";
// print 'hell';
            if(++$i !== $numItems-1) {
              print '<span class="categoryslash">/</span> ';
            }
          }
        }
      ?>
    </div>
    <div class="index-inner index-people">
      <p>
      <?php
        $args = [
          'posts_per_page' => -1,
          'post_type' => 'post',
          'orderby'          => 'title',
          // 'orderby'          => 'wpse_last_word',          //<-- Our custom ordering!
          'order'            => 'ASC',
          'post_status' => 'publish'
         ];

        $posts = new WP_Query( $args );
        while ($posts->have_posts()): $posts->the_post(); ?>

        <?php
        $categories = get_the_category();
        $cats = '';

        foreach ( $categories as $category ) {
          $cats .= ' cat-' . str_replace(' ', '-', $category->name);
        }
        if(get_the_ID() != 17035):
        ?>
          <a href="<?php the_permalink(); ?>" class='index-el index-el-people<?php echo $cats ?>'><?php the_title(); ?></a>
        <?php
        endif;
      endwhile;
      wp_reset_query();?>
      </p>
    </div>
  </div>
</dialog>

<footer>
  <div class="container row">
    <div class="footer-directions col2">
     <?php echo get_theme_mod( 'lcc_footer_column1' ); ?>
    </div>

    <div class="footer-private-view col3 offset4">
      <?php echo get_theme_mod( 'lcc_footer_column2' ); ?>
    </div>

    <div class="col3">
      <?php echo get_theme_mod( 'lcc_footer_column3' ); ?>
    </div>
  </div>
</footer>
</main>
<?php wp_footer(); ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-78900339-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>

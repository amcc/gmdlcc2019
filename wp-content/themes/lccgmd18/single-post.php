<?php get_header(); ?>

<main role="main" class="student-page container">
  <div class="student-meta row">
    <div class="student-info">
    <?php

    // $ip = $_SERVER['REMOTE_ADDR'];
    // $part_ip = substr($ip, 0, strrpos( $ip, '.') );

    // $links = true;
    // if($part_ip == '195.195.80' || '127.0.0'){
    //   $links = false;
    // }

    ?>
      <div class="student-name-container">
        <div class="student-name"><span class="studentslash">/</span><?php the_field('display_name') ?></div>
      </div>
      <?php $url = preg_replace('#^https?://#', '', get_field('website_url')['url']);
            $urlText = $url;
            if(strlen($url) > 30) {
              $urlText = "Portfolio";
            }
            ?>
        <div class="student-website"><a target="_blank" href="<?php echo get_field('website_url')['url'] ?>"><?php echo $urlText ?></a></div>
        <?php if(get_the_ID() != 17035): ?>
        <div class="student-email"><a target="_blank" href="mailto:<?php the_field('email') ?>"><?php the_field('email') ?></a></div>
      <?php endif; ?>
    </div>
    <div class="student-bio col6"><?php the_field('biography') ?></div>
  </div>




  <?php
  // project id
  $p = 0;
  if (have_rows('projects')) : while (have_rows('projects')) : the_row();
  //
  ?>
    <div class="student-project row">
      <div class="student-project-meta col6">
        <div class="student-project-title"><?php the_sub_field('project_title'); ?></div>
        <p class="student-project-description"><?php the_sub_field('project_description'); ?></p>
      </div>
      <!-- <div class="student-project-images col8 offset1"> -->
      <div class="student-project-images row">
        <?php
          $i = 0;
          if (have_rows('images/video')) : while (have_rows('images/video')) : the_row();
          // reset video links
          $vimeo_link = get_sub_field('vimeo_link');
          $youtube_link = get_sub_field('youtube_link');
          // correct vimeo url
          if (substr( get_sub_field('vimeo_link'), 0, 4 ) === "http"){
            $id = substr(get_sub_field('vimeo_link'), strrpos(get_sub_field('vimeo_link'), '/') + 1);
            $vimeo_link = $id;
          } else if (get_sub_field('vimeo_link')) {
            $vimeo_link = get_sub_field('vimeo_link');
          }
          // correct youtube url
          if (substr( get_sub_field('youtube_link'), 0, 4 ) === "http"){
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', get_sub_field('youtube_link'), $match);
            $youtube_link = $match[1];
          } else if (get_sub_field('youtube_link')) {
            $youtube_link = get_sub_field('youtube_link');
          }

          //$vimeo_link = get_sub_field('vimeo_link');
          //$youtube_link = get_sub_field('youtube_link');
        ?>

          <?php if($vimeo_link) : ?>
            <div class="student-project-video-wrapper">
              <iframe class="student-project-video" src="https://player.vimeo.com/video/<?php echo $vimeo_link ?>"frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
          <?php elseif($youtube_link) : ?>
            <div class="student-project-video-wrapper">
              <iframe class="student-project-video" type="text/html" src="https://www.youtube.com/embed/<?php echo $youtube_link ?>?autoplay=0&origin=http://gmdlcc.com&modestbranding=1" frameborder="0" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" /></iframe>
            </div>
          <?php else :
            // image
            $imageurl = get_sub_field('project_image')['sizes']['large'];

            $filetype = wp_check_filetype($imageurl);

            if ($filetype[ext] == 'gif'){
              $thing = 'gif';
              $imageurl = get_sub_field('project_image')['url'];
              // print '<pre>';
              // print_r($image);
              // print '</pre>';
            } else{
                $thing = 'notgif';
            }
            // print $thing;
            // print '<pre>';
            // print_r(get_sub_field('project_image'));
            // print '</pre>';
            ?>

            <div class="student-project-image-wrapper ng"><img id="image<?php echo $p . '-' . $i ?>" class="student-project-image fullscreen" data-normal="<?php echo $imageurl; ?>"></div>

          <?php endif; ?>
        <?php
        $i++;
        endwhile; endif; ?>
      </div>
    </div>
  <?php
  $p++;
  endwhile; endif; ?>


</main>

<?php get_footer(); ?>

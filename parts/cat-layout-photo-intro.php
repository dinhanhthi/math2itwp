<?php // Idea of layout: https://blog.ghost.org ?>

<?php if ( $list_posts ) {?>

<section class="layout-photo-intro <?php if($customSecClass){echo $customSecClass;} ?>">

  <div class="container">

    <?php if ($typeTitle){ ?>
    <div class="row justify-content-center">
      <?php get_template_part( 'parts/sec-title' ); ?>
    </div>
    <?php } ?>

    <div class="row row-eq-height justify-content-center">

      <?php foreach($list_posts as $post) : ?>
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="item">
          <a class="no-a-effect" href="<?php echo get_permalink($post->ID) ?>">

          <?php 
            $first_cat = get_the_category($post->ID);
            $rand_number = rand(0,count($first_cat)-1);
          ?>

            <div class="post-image">
              <?php
                if ( has_post_thumbnail($post->ID) ) {
                  $postThumbnail = get_the_post_thumbnail($post->ID,'medium' );
                  echo $postThumbnail;
                }else{
                  $postThumbnail = get_field('default_posts_feature_image',$first_cat[$rand_number]);
                  echo wp_get_attachment_image( $postThumbnail['id'],'medium');
                }
              ?>
            </div>
          </a>
          <a class="no-a-effect" href="<?php echo esc_url( get_category_link( $first_cat[$rand_number]->term_id ) ) ?>">
            <div class="post-cat" style="background: <?php echo get_field('dark_color', $first_cat[$rand_number]); ?>;">
                <?php echo esc_html( $first_cat[$rand_number]->name ); ?>
            </div>
          </a>
          <div class="post-title">
            <a class="no-a-effect" href="<?php echo get_permalink($post->ID) ?>">
              <?php echo $post->post_title; ?>
            </a>
          </div>
          <div class="post-date">
            <i class="icon-clock"></i>
            <?php 
							date_default_timezone_set('Asia/Ho_Chi_Minh
							');
							$from = strtotime($post->post_date);
							$today = time();
							$difference = floor(($today - $from)/86400); // day
							if ($difference == 0):
								echo 'Vừa mới đăng';
							elseif ($difference < 7):
								echo $difference.' ngày trước';
							else:
								echo date('d-m-y', strtotime($post->post_date));
							endif;
						?>
          </div>
          <div class="post-excerpt">
            <?php
              if (get_field('abstract',$post->ID)):
                echo get_field('abstract',$post->ID);
              else:
                the_excerpt();
              endif;
            ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    </div>
  </div>
</section>

<?php }?>
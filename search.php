<?php get_header(); ?>

<?php 
  $search_query = get_search_query();
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $posts_per_page = 16;
  $list_post_args = array(
    's'                => $search_query,
		'paged'            => $paged,
    'post_status'      => 'publish',
    'suppress_filters' => false,
		'posts_per_page'   => $posts_per_page
  );
  $list_posts = get_posts($list_post_args);
  // pagination
  $custom_query = new WP_Query( $list_post_args );
  $found_posts = $custom_query->found_posts;
  $number_of_pages = ceil($found_posts / $posts_per_page);
	
  $big = 999999999; // need an unlikely integer
  $pag_arg = array(
    'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    'format'    => '?paged=%#%',
    'prev_text' => __('«'),
    'next_text' => __('»'),
    'current'   => max( 1, get_query_var('paged') ),
    'total'     => $number_of_pages
  );
?>

<section class="section">
  <div class="container">
    <div class="row justify-content-center">
      
      <div class="col-12">
        <h2 class="search-title">
          <span class="default_query">Kết quả tìm kiếm cho</span> <span class="keyword_quey">"<?php echo get_search_query(); ?>"</span>
        </h2>
      </div>

      <div class="col-12 col-lg-11">
        <div class="result-list">
        <?php /* Start the Loop */ ?>
        <?php if ( $list_posts ) : ?>
        <?php foreach($list_posts as $post) : 
          $post_id = $post->ID;
        ?>
          <div class="item">
            <div class="content">
              <div class="meta">
                <?php
                  $first_cat = get_the_category($post_id);
                  $rand_number = rand(0,count($first_cat)-1);
                  $cat_id = $first_cat[$rand_number]->term_id;
                ?>
                <a class="cat-title-<?php echo $cat_id; ?>" href="<?php echo esc_url( get_category_link($cat_id) ) ?>">
                  <?php echo $first_cat[$rand_number]->name; ?>
                </a>
                <span class="dot">&#9679;</span>
                <span>
                  <?php 
                    date_default_timezone_set('Asia/Ho_Chi_Minh
                    ');
                    $from = strtotime(get_the_date());
                    $today = time();
                    $difference = floor(($today - $from)/86400); // day
                    if ($difference == 0):
                      echo 'Vừa mới đăng';
                    elseif ($difference < 7):
                      echo $difference.' ngày trước';
                    else:
                      echo get_the_date('d-m-Y');
                    endif;
                  ?> 
                </span>
              </div>
              <a class="title-excerpt" href="<?php the_permalink(); ?>" >
                <h2 class="title">
                  <?php echo get_the_title($post_id); ?>
                </h2>
                <div class="excerpt">
                  <?php if (has_excerpt($post_id)){
                    echo esc_attr(get_the_excerpt($post_id));
                  }else{
                    setup_postdata( $post );
                    echo get_the_excerpt();
                  } ?>
                </div>
              </a>
            </div>
            <a href="<?php the_permalink(); ?>" >
              <div class="photo">
                <?php
                  if ( has_post_thumbnail($post_id) ) {
                    $postThumbnail = get_the_post_thumbnail($post_id,'medium' );
                    echo $postThumbnail;
                  }else{
                    $first_cat = get_the_category($post_id);
                    $postThumbnail = get_field('default_posts_feature_image',$first_cat[$rand_number]);
                    echo wp_get_attachment_image( $postThumbnail['id'],'small');
                  }
                ?>
              </div>
            </a>
          </div> <!-- /div item -->
        <?php endforeach; ?>
        <?php else: ?>
          <p>Rất tiếc, không tìm thấy kết quả bạn cần tìm.</p>
        <?php endif; ?>
        </div>
      </div>

    </div> <!-- /div row -->
  </div> <!-- /div container -->
</section>

<!-- pagination -->
<?php
if ($number_of_pages > 1):?>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12">
      <?php
        echo '<div class="paginate-links mb-5">';
          echo paginate_links( $pag_arg );
        echo '</div>';
      ?>
    </div>
  </div>
</div>
<?php
endif;
?>

<?php get_footer(); ?>
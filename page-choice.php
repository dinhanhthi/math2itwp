<!-- header -->
<!-- ====================================== -->
<?php get_header(); ?>


<main role="main">

<header class="header-page bg-black">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-md-10 col-lg-8">
				<div class="img-avatar">
          <i class="icon-star-circled" style="color: #f3bb34;"></i>
        </div>
				<h2 class="page-title">
					Math2IT tuyển chọn
				</h2>
				<h4 class="page-subtitle">
					Dựa trên tiêu chí bổ ích và hay được xem lại nhiều nhất
        </h4>
        <div class="idx-social">
          <a class="mr-s" href="<?php echo get_bloginfo( 'wpurl' ) ?>/gioi-thieu"><i class="icon-heart"></i><span class="hide-on-xs"> Giới thiệu</span></a>
          <a class="mr-s" target="_blank" href="<?php echo get_option('facebook-group'); ?>"><i class="icon-group"></i><span class="hide-on-xs"> Nhóm Math2IT</span></a>
          <a class="mr-s" target="_blank" href="<?php echo get_option('facebook'); ?>"><i class="icon-facebook-squared"></i><span class="hide-on-xs"> FB Math2IT</span></a>
        </div>
			</div> <!-- /.col -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->
</header>

<?php get_template_part( 'parts/subscribe-bar' ); ?>


<?php
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $posts_per_page = 16;
  $list_post_args = array(
    'meta_key'         => 'top_choice',
    'meta_value'       => 1,
		'paged'            => $paged,
		'post_status'      => 'publish',
		'posts_per_page'   => $posts_per_page
  );
  $list_posts = get_posts($list_post_args);
	set_query_var('typeTitle', ''); 
  set_query_var('list_posts', $list_posts);
  set_query_var('customSecClass', '');
  set_query_var('display_category', true);

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

<div style="padding: 5rem 0;">

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

<!-- list of posts -->
<?php get_template_part( 'parts/cat-layout-photo-title' ); ?>

<!-- pagination -->
<?php
if ($number_of_pages > 1):?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <?php
          echo '<div class="paginate-links mt-5">';
            echo paginate_links( $pag_arg );
          echo '</div>';
        ?>
      </div>
    </div>
  </div>
<?php
endif;
?>

</div>

<?php wp_reset_query() ?>

</main>


<!-- footer -->
<!-- ====================================== -->
<?php get_footer(); ?>
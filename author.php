<?php get_header(); ?>

<header class="header-page bg-black">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-md-10 col-lg-8">
        <div class="author-avatar">
          <?php 
						if (get_field('user_avatar','user_'.get_the_author_meta('ID'))):
							$avatar = get_field('user_avatar','user_'.get_the_author_meta('ID'));
							echo wp_get_attachment_image( $avatar['id'],'thumbnail');
						elseif(get_avatar_url(get_the_author_meta('ID'),50) !== FALSE): 
							$avatar = get_avatar_url(get_the_author_meta('ID'),array("size"=>200));
						?>
							<img src="<?php echo $avatar; ?>" alt="<?php the_author() ?>'s avatar'">
					<?php else: ?>
							<img src="<?php echo get_template_directory_uri() ?>/img/author.svg">
					<?php endif; ?>
				</div>
				<h1 class="page-title">
          <?php 
            $fname = get_the_author_meta('first_name');
            $lname = get_the_author_meta('last_name');
            $full_name = '';
            if( empty($fname)){
                $full_name = $lname;
            } elseif( empty( $lname )){
                $full_name = $fname;
            } else {
                //both first name and last name are present
                $full_name = "{$lname} {$fname}";
            }
            echo $full_name;
          ?>
				</h1>
				<h2 data-toc-skip class="page-subtitle">
          <?php
						if (get_the_author_meta('description')){
							echo nl2br(get_the_author_meta('description')); 
						}else{
							echo "Một tác giả của Math2IT.";
						}
          ?>
        </h2>
        <div class="idx-social">
          <a class="mr-s" href="mailto:<?php echo get_the_author_meta('user_email') ?>"><i class="fa fa-envelope" aria-hidden="true"></i><span class="hide-on-xs"> Email cho <?php if ($fname){echo $fname;}else{ the_author();} ?></span></a>
        </div>
			</div> <!-- /.col -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->
</header>

<?php // get_template_part( 'parts/subscribe-bar' ); ?>

<?php
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $posts_per_page = 16;
  $list_post_args = array(
    'paged'            => $paged,
    'author'           => get_the_author_meta('ID'),
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

  // for pagination
  set_query_var('pag_arg', $pag_arg);
  set_query_var('number_of_pages', $number_of_pages);
?>


<div class="all-posts">
  <?php get_template_part( 'parts/cat-layout-photo-title' ); ?>
  <?php get_template_part( 'parts/pagination' ); ?>
</div>


<?php wp_reset_query() ?>

<?php get_footer(); ?>
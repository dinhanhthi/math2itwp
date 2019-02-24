<?php get_header(); ?>

<main role="main">

<?php
  $taxonomy_id = get_queried_object()->term_id;
  set_query_var('cat_id', $taxonomy_id);
?>
<?php get_template_part( 'parts/sec-cat-header' ); ?>
<?php wp_reset_query(); ?> <!-- reset -->

<?php get_template_part( 'parts/subscribe-bar' ); ?>


<!-- List of posts -->
<!-- ====================================== -->
<?php
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $posts_per_page = 16;
  // list of posts
  if (is_category()){
    $list_post_args = array(
      'category'          => $taxonomy_id,
      'posts_per_page'    => $posts_per_page,
      'paged'             => $paged,
      'post_status'       => 'publish'
    );
  }elseif (is_tag()){
    $list_post_args = array(
      'tag_id'            => $taxonomy_id,
      'posts_per_page'    => $posts_per_page,
      'paged'             => $paged,
      'post_status'       => 'publish'
    );
  }
  
  $list_posts = get_posts($list_post_args);
  set_query_var('typeTitle', ''); 
  set_query_var('list_posts', $list_posts);
  set_query_var('customSecClass', '');
  if (!is_category()){
    set_query_var('display_category', true);
  }

  // pagination
  if (is_category()){
    $cat_count = get_category($taxonomy_id);
  }elseif (is_tag()){
    $cat_count = get_tag($taxonomy_id);
  }
  $found_posts = $cat_count->count;
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
<?php get_template_part( 'parts/cat-layout-tool' ); ?>

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

<?php get_footer(); ?>
<?php
/* Template Name: Dress Catalog */


get_header();
?>
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">Daweddy Catalogs</h1>
        <p class="text-muted">Here are the dresses That Can inspire you.</p>
    </div>
<div class="container my-5">
  <!-- <h1 class="text-center mb-4">Dresses Ideas </h1> -->
  <div class="row">
    <?php
    $dress_query = new WP_Query([
        'post_type' => 'dress',
        'posts_per_page' => -1
    ]);
    if ( $dress_query->have_posts() ) :
        while ( $dress_query->have_posts() ) : $dress_query->the_post();
    ?>

        <div class="col-md-3 mb-4 ">
          <div class="card h-100">
            <?php if ( has_post_thumbnail() ) : ?>
              <div >
              <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                <?php the_post_thumbnail('large', ['class' => 'card-img-top']); ?>
              </a>  
              </div>
            <?php endif; ?>
            <div class="card-body text-center d-flex justify-content-between align-items-center">
              <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                <h5 class="card-title"><?php the_title(); ?></h5>
              </a>

              <?php
              $is_favorited = function_exists('is_post_favorited_by_user') 
                  ? is_post_favorited_by_user(get_the_ID()) 
                  : false;
              ?>

              <span class="heart-icon" data-post-id="<?php echo get_the_ID(); ?>">
                <i class="bi <?php echo $is_favorited ? 'bi-heart-fill big-heart text-danger' : 'bi-heart big-heart'; ?>"></i>
              </span>


            </div>
          </div>
        </div>
    <?php
        endwhile;
        wp_reset_postdata();
    else :
    ?>
      <p class="text-center">No dresses found.</p>
    <?php endif; ?>
  </div>
</div>
<?php
get_footer();

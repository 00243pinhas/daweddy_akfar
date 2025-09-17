<?php get_header(); ?>

<div class="container my-5">
  <div class="row">
    
    <!-- Left Column: Text -->
    <div class="col-md-6">
      <h1><?php the_title(); ?></h1>
      
      <p><?php the_field('short_description'); ?></p>

            <div class="row">
            <?php if ($collection = get_field('collection')): ?>
                <div class="col-6 mb-2"><strong>Collection:</strong> <?php echo esc_html($collection); ?></div>
            <?php endif; ?>

            <?php if ($line = get_field('line')): ?>
                <div class="col-6 mb-2"><strong>Line:</strong> <?php echo esc_html($line); ?></div>
            <?php endif; ?>

            <?php if ($color = get_field('color')): ?>
                <div class="col-6 mb-2"><strong>Color:</strong> <?php echo esc_html($color); ?></div>
            <?php endif; ?>

            <?php if ($style = get_field('style')): ?>
                <div class="col-6 mb-2"><strong>Style:</strong> <?php echo esc_html($style); ?></div>
            <?php endif; ?>

            <?php if ($silhouette = get_field('silhouette')): ?>
                <div class="col-6 mb-2"><strong>Silhouette:</strong> <?php echo esc_html($silhouette); ?></div>
            <?php endif; ?>

            <?php if ($fabric = get_field('fabric')): ?>
                <div class="col-6 mb-2"><strong>Fabric:</strong> <?php echo esc_html($fabric); ?></div>
            <?php endif; ?>
            </div>


    </div>

    <!-- Right Column: Images -->
    <div class="col-md-6">
      <div class="row">
        <!-- Featured Image -->
        <!-- <?php if (has_post_thumbnail()) : ?>
          <div class="col-9 mb-3">
            <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
          </div>
        <?php endif; ?> -->

        <!-- Extra Images -->
        <?php if ($img2 = get_field('image_2')): ?>
          <div class="col-6 mb-3">
            <img src="<?php echo esc_url($img2); ?>" class="img-fluid" alt="">
          </div>
        <?php endif; ?>

        <?php if ($img3 = get_field('image_3')): ?>
          <div class="col-6 mb-3">
            <img src="<?php echo esc_url($img3); ?>" class="img-fluid" alt="">
          </div>
        <?php endif; ?>

        <?php if ($img4 = get_field('image_4')): ?>
          <div class="col-6 mb-3">
            <img src="<?php echo esc_url($img4); ?>" class="img-fluid" alt="">
          </div>
        <?php endif; ?>


        <?php if ($img5 = get_field('image_5')): ?>
          <div class="col-6 mb-3">
            <img src="<?php echo esc_url($img5); ?>" class="img-fluid" alt="">
          </div>
        <?php endif; ?>

      </div>
    </div>

  </div>
</div>

<?php get_footer(); ?>

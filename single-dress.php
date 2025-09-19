<?php get_header(); ?>

<div class="container my-5">
  <div class="row">
    
    <!-- Left Column: Text -->
    <div class="col-md-6">

      <div class="d-flex justify-content-between align-items-center mb-3 ">

        <h1><?php the_title(); ?></h1>
        <span><i class="bi bi-heart big-heart"></i></span>
      </div>
      
      <p><?php the_field('short_description'); ?></p>

            <div class="row m-4 ">

              <h5 class="mt-4"> About the Dress</h5>

              <div  class="col-12 d-flex flex-wrap mb-4 mt-2">

                <?php if ($collection = get_field('collection')): ?>
                    <div class="col-6 mb-2 ">Collection </div>
                    <span><strong><?php echo esc_html($collection); ?></strong></span>
                <?php endif; ?>

                <?php if ($line = get_field('line')): ?>
                    <div class="col-6 mb-2">Line </div>
                    <span><strong><?php echo esc_html($line); ?></strong></span>
                <?php endif; ?>

                <?php if ($color = get_field('color')): ?>
                    <div class="col-6 mb-2">Color </div>
                    <span><strong><?php echo esc_html($color); ?></strong></span>
                <?php endif; ?>

                <?php if ($style = get_field('style')): ?>
                    <div class="col-6 mb-2">Style </div>
                    <span><strong><?php echo esc_html($style); ?></strong></span>
                <?php endif; ?>

                <?php if ($silhouette = get_field('silhouette')): ?>
                    <div class="col-6 mb-2">Silhouette </div>
                    <span><strong><?php echo esc_html($silhouette); ?></strong></span>
                <?php endif; ?>

                <?php if ($fabric = get_field('fabric')): ?>
                    <div class="col-6 mb-2">Fabric </div>
                    <span><strong><?php echo esc_html($fabric); ?></strong></span>
                <?php endif; ?>

              </div>


                <button type="button" class="btn btn-dark">Request an Appointment</button>

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
              <img src="<?php echo esc_url($img2); ?>" 
                  class="img-fluid img-clickable" 
                  alt=""
                  data-bs-toggle="modal" 
                  data-bs-target="#imageModal" 
                  data-img="<?php echo esc_url($img2); ?>">
            </div>
          <?php endif; ?>


            <?php if ($img3 = get_field('image_3')): ?>
              <div class="col-6 mb-3">
                <img src="<?php echo esc_url($img3); ?>" 
                    class="img-fluid img-clickable" 
                    alt=""
                    data-bs-toggle="modal" 
                    data-bs-target="#imageModal" 
                    data-img="<?php echo esc_url($img3); ?>">
              </div>
            <?php endif; ?>


        <?php if ($img4 = get_field('image_4')): ?>
          <div class="col-6 mb-3">
            <img src="<?php echo esc_url($img4); ?>" 
                class="img-fluid img-clickable" 
                alt=""
                data-bs-toggle="modal" 
                data-bs-target="#imageModal" 
                data-img="<?php echo esc_url($img4); ?>">
          </div>
        <?php endif; ?>

          <?php if ($img5 = get_field('image_5')): ?>
            <div class="col-6 mb-3">
              <img src="<?php echo esc_url($img5); ?>" 
                  class="img-fluid img-clickable" 
                  alt=""
                  data-bs-toggle="modal" 
                  data-bs-target="#imageModal" 
                  data-img="<?php echo esc_url($img5); ?>">
            </div>
          <?php endif; ?>


          <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content bg-transparent border-0 shadow-none">
                <div class="modal-body p-0 text-center">
                  <img id="modalImage" src="" class="img-fluid rounded" alt="">
                </div>
                <div class="modal-footer justify-content-center border-0">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          
          <script>
                document.addEventListener("DOMContentLoaded", function() {
                  const modal = document.getElementById('imageModal');
                  const modalImage = document.getElementById('modalImage');
                  document.querySelectorAll('.img-clickable').forEach(img => {
                    img.addEventListener('click', function() {
                      const imgSrc = this.getAttribute('data-img');
                      modalImage.src = imgSrc;
                    });
                  });
                });
          </script>


      </div>
    </div>

  </div>
</div>

<?php get_footer(); ?>

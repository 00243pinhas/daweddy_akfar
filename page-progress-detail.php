<?php
/* Template Name: Dress Progress Detail */

get_header();


global $wpdb;
$table_name = $wpdb->prefix . "dress_progress";
$step_id = isset($_GET['progress_id']) ? intval($_GET['progress_id']) : 0;

$step = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $step_id) );

if ( $step ) :
    
    
  $gallery_images = !empty($step->gallery_images) ? explode(',', $step->gallery_images) : [];
 ?>

<div class="container py-5">


    <div class="card mb-4 shadow-sm">
        <div class="card-body text-center">
            <h2 class="card-title mb-1"><?php echo esc_html($step->stage); ?></h2>
            <p class="text-muted mb-0"> <?php echo esc_html( date_i18n('F j, Y', strtotime($step->created_at)) ); ?></p>
            <span class=" mt-5">In Progress</span>
        </div>
    </div>


    <?php if ( !empty($gallery_images) ) : ?>
    <div class="row g-3 mb-4">
        <?php foreach ( $gallery_images as $img ) : ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="<?php echo esc_url($img); ?>" class="card-img-top" alt="Progress Image"
                         data-bs-toggle="modal" data-bs-target="#imageModal" data-img="<?php echo esc_url($img); ?>">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>


    <?php if ( !empty($step->description) ) : ?>
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title center">Hello </h5>
            <p class="card-text"><?php echo wp_kses_post( wpautop($step->description) ); ?></p>
        </div>
    </div>
    <?php endif; ?>


    <?php if ( !empty($step->video_url) ) : ?>
    <!-- <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Take a Good Look </h5>
            <div class="ratio ratio-16x9">
                <iframe src="<?php echo esc_url($step->video_url); ?>" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div> -->

                        <!-- Video section -->
  <div class="card mb-4">
    <div class="card-body text-center">

      <!-- Thumbnail / Cover image -->
      <div class="position-relative d-inline-block" style=" height: 500px; overflow: hidden; object-fit: cover border-0;">
        <img src="/wp-content/uploads/2022/07/D267pb-scaled.jpg" 
             alt="Video Cover" 
             class="img-fluid rounded shadow"
             style="  object-fit: cover; object-position: center;">
             >

        <!-- Play button overlay -->
        <button type="button" 
                class="btn btn-light position-absolute top-50 start-50 translate-middle"
                data-bs-toggle="modal" 
                data-bs-target="#videoModal">
          ▶ Play
        </button>
      </div>
    </div>
  </div>

  <!-- Modal with video -->
  <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-0">
          <div class="ratio ratio-16x9">
            <iframe 
              src="<?php echo esc_url( $step->video_url ); ?>" 
              allow="autoplay" 
              allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
    <?php endif; ?>

</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <img src="" id="modalImage" class="img-fluid rounded" alt="">
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const modalImage = document.getElementById('modalImage');
  document.querySelectorAll('[data-bs-target="#imageModal"]').forEach(img => {
    img.addEventListener('click', () => {
      modalImage.src = img.getAttribute('data-img');
    });
  });
});
</script>

<?php
else :
    echo '<div class="container py-5"><div class="alert alert-warning">Progress not found.</div></div>';
endif;

                        
 get_footer(); 

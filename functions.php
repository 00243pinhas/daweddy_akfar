<?php
function afkar_child_enqueue_styles() {
    wp_enqueue_style('afkar-parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('afkar-child-style', get_stylesheet_uri(), array('afkar-parent-style'));
    wp_enqueue_style('afkar-child-assets-style', get_stylesheet_directory_uri() . '/assets/css/style.css', array('afkar-parent-style', 'afkar-child-style'), null);
}

// This should be outside the function!
add_action('wp_enqueue_scripts', 'afkar_child_enqueue_styles', 20);

add_filter('get_custom_logo', function($html) {
    $custom_logo_url = get_stylesheet_directory_uri() . '/assets/img/logo.png';
    return '<a href="' . esc_url(home_url('/')) . '" rel="home"><img src="' . esc_url($custom_logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" /></a>';
});
?>


<?php


// ***********************start For the backend of the progress page management ***********************

// Add Dress Progress menu in WP admin
function dress_progress_admin_menu() {
    add_menu_page(
        'Dress Progress',
        'Dress Progress',
        'manage_options',
        'dress-progress',
        'dress_progress_admin_page',
        'dashicons-admin-customizer',
        6
    );
}
add_action('admin_menu', 'dress_progress_admin_menu');

// Admin page content
function dress_progress_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . "dress_progress";

    // Save progress if form submitted
if ( isset($_POST['save_dress_progress']) && check_admin_referer('save_dress_progress', 'dress_progress_nonce') ) {
    
    $user_id       = intval($_POST['user_id']);
    $dress_name    = sanitize_text_field($_POST['dress_name']);
    $sample_image  = esc_url_raw($_POST['sample_image']);
    $gallery_images = sanitize_textarea_field($_POST['gallery_images']); // comma separated
    $description   = sanitize_textarea_field($_POST['description']);
    $video_url     = esc_url_raw($_POST['video_url']);  

    $wpdb->insert(
        $table_name,
        array(
            'user_id'       => $user_id,
            'dress_name'    => $dress_name,
            'sample_image'  => $sample_image,
            'gallery_images'=> $gallery_images,
            'description'   => $description,
            'video_url'     => $video_url,
        )
    );

        echo "<div class='updated'><p> Progress added successfully for user ID: $user_id</p></div>";

    }
    

    ?>
     <div class="wrap">
        <h1>Dress Progress</h1>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('save_dress_progress', 'dress_progress_nonce'); ?>

            <p>
                <label>Dress Name:</label><br>
                <input type="text" name="dress_name" required />
            </p>

            <p>
                <label>Sample Image (URL):</label><br>
                <input type="text" name="sample_image" placeholder="https://example.com/sample.jpg" />
            </p>

            <p>
                <label>Gallery Images (comma separated URLs):</label><br>
                <textarea name="gallery_images" rows="3" placeholder="https://... , https://..."></textarea>
            </p>

            <p>
                <label>Description:</label><br>
                <textarea name="description" rows="5"></textarea>
            </p>

            <p>
                <label>Video URL (YouTube, Vimeo, etc):</label><br>
                <input type="text" name="video_url" placeholder="https://youtube.com/..." />
            </p>

            <p>
                <label>Assign to User:</label><br>
                <select name="user_id" required>
                    <option value="">-- Select a User --</option>
                    <?php
                    $users = get_users(array('role__in' => array('customer','subscriber','contributor','author','editor','administrator')));
                    foreach ($users as $user) {
                        echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name . ' (' . $user->user_email . ')') . '</option>';
                    }
                    ?>
            </p>

            <p><input type="submit" name="save_dress_progress" class="button button-primary" value="Save Progress" /></p>
        </form>
    </div>
    <?php
}


// Helper: render a video/embed or fallback link
function dp_render_media( $url ) {
    if ( empty( $url ) ) {
        return '';
    }

    $url = esc_url_raw( $url );

    // direct video file (mp4/webm/ogg)
    if ( preg_match( '/\.(mp4|webm|ogg)(\?.*)?$/i', $url ) ) {
        return '<video controls style="width:100%;border-radius:8px;max-height:480px;"><source src="' . esc_url( $url ) . '"></video>';
    }

    // try WordPress oEmbed (YouTube, Vimeo, etc.)
    $embed = wp_oembed_get( $url );
    if ( $embed ) {
        return '<div class="dp-embed-wrapper">' . $embed . '</div>';
    }

    // fallback: plain link
    return '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener">Open media</a>';
}


// *********************** End for the backend of the progress page management ***********************




// ********************** Start bootstrap installation **********************

function daweddy_child_enqueue_bootstrap() {
    wp_enqueue_style(

        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(),
        '5.3.3'

    );
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        array('jquery'),
        '5.3.3',
        true
    );
}

add_action('wp_enqueue_scripts', 'daweddy_child_enqueue_bootstrap');



///********************** End bootstrap installation **********************


///********************** Start Font Awesome installation **********************
function daweddy_child_enqueue_font_awesome(){
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        [],
        '6.4.0'
    );
}
add_action('wp_enqueue_scripts', 'daweddy_child_enqueue_font_awesome', 25);
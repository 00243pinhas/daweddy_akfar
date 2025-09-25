<?php
function afkar_child_enqueue_styles() {
    wp_enqueue_style('afkar-parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('afkar-child-style', get_stylesheet_uri(), array('afkar-parent-style'));
    wp_enqueue_style('afkar-child-assets-style', get_stylesheet_directory_uri() . '/assets/css/style.css', array('afkar-parent-style', 'afkar-child-style'), null);

        wp_enqueue_script(
        'favorites-js',
        get_stylesheet_directory_uri() . '/js/favorites.js',
        array(),
        '1.0',
        true
    );

    wp_localize_script('favorites-js', 'favoritesObj', array(
        'ajax_url'           => admin_url('admin-ajax.php'),
        'nonce'              => wp_create_nonce('favorites_nonce'),
        'login_url'          => wp_login_url(), 
        'is_user_logged_in'  => is_user_logged_in() ? 1 : 0,
    ));
}


//  ************************ Load child theme textdomain *************************

add_action( 'after_setup_theme', 'child_theme_setup' );
function child_theme_setup() {
    load_child_theme_textdomain( 'afkar-child', get_stylesheet_directory() . '/languages' );
}


/// ************************ Enqueue styles *************************



// This should be outside the function!
add_action('wp_enqueue_scripts', 'afkar_child_enqueue_styles', 20);



// AJAX handler for toggling favorite dresses

function my_toggle_favorite_ajax() {
    check_ajax_referer('favorites_nonce', 'nonce');

   
    if (! is_user_logged_in()) {
        wp_send_json_error( array(
            'message'   => 'login_required',
            'login_url' => wp_login_url( wp_get_referer() ?: home_url() )
        ), 403 );
    }

    $user_id = get_current_user_id();
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    if (! $post_id) {
        wp_send_json_error( array('message' => 'invalid_post') );
    }

    $meta_key = 'favorite_dresses';
    $favorites = get_user_meta($user_id, $meta_key, true);
    if (! is_array($favorites)) $favorites = array();

    if ( in_array($post_id, $favorites, true) ) {
        // remove
        $favorites = array_values(array_diff($favorites, array($post_id)));
        update_user_meta($user_id, $meta_key, $favorites);
        wp_send_json_success( array('status' => 'removed', 'favorites' => array_values($favorites)) );
    } else {
        // add
        $favorites[] = $post_id;
        $favorites = array_values(array_unique($favorites));
        update_user_meta($user_id, $meta_key, $favorites);
        wp_send_json_success( array('status' => 'added', 'favorites' => array_values($favorites)) );
    }
}
add_action('wp_ajax_toggle_favorite', 'my_toggle_favorite_ajax');


function is_post_favorited_by_user($post_id, $user_id = null) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    if (!$user_id) {
        return false; 
    }

    $favorites = get_user_meta($user_id, 'favorite_posts', true);
    if (!is_array($favorites)) {
        $favorites = [];
    }

    return in_array($post_id, $favorites);
}


// Customize the site logo

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


add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css',
        [],
        '1.11.3'
    );
}, 30);

///********************** End bootstrap installation **********************


///********************** Db booking **********************

// Run on theme/plugin activation
// function my_booking_create_table() {
//     global $wpdb;
//     $table = $wpdb->prefix . 'bookings';

//     $charset_collate = $wpdb->get_charset_collate();

//     $sql = "CREATE TABLE $table (
//         id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
//         name VARCHAR(100) NOT NULL,
//         phone VARCHAR(30) NOT NULL,
//         email VARCHAR(100) NOT NULL,
//         service VARCHAR(100) NOT NULL,
//         date DATE NOT NULL,
//         time VARCHAR(20) NOT NULL,
//         created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
//         UNIQUE KEY unique_slot (date, time), 
//         PRIMARY KEY  (id)
//     ) $charset_collate;";

//     require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
//     dbDelta($sql);
// }
// add_action('after_switch_theme', 'my_booking_create_table');
//********************** End Db booking **********************

//********************** Start Ajax booking **********************


function my_submit_booking() {
    check_ajax_referer('submit_booking_nonce', 'nonce');

    global $wpdb;
    $table = $wpdb->prefix . 'bookings';

    $name    = sanitize_text_field($_POST['name']);
    $phone   = sanitize_text_field($_POST['phone']);
    $email   = sanitize_email($_POST['email']);
    $service = sanitize_text_field($_POST['service']);
    $date    = sanitize_text_field($_POST['date']);
    $time    = sanitize_text_field($_POST['timeSlot']);

    $inserted = $wpdb->insert($table, [
        'name'    => $name,
        'phone'   => $phone,
        'email'   => $email,
        'service' => $service,
        'date'    => $date,
        'time'    => $time
    ]);


    if ($inserted) {
        wp_send_json_success(['id' => $wpdb->insert_id]);
    } else {
        error_log('Booking insert error: ' . $wpdb->last_error);
        wp_send_json_error('Time slot already taken.');
}
}
add_action('wp_ajax_submit_booking', 'my_submit_booking');
add_action('wp_ajax_nopriv_submit_booking', 'my_submit_booking');
//********************** End Ajax booking **********************s

// ********************** enqueue booking js **********************

function my_booking_scripts() {
    wp_enqueue_script(
        'booking-js',
        get_stylesheet_directory_uri() . '/js/booking.js',
        array('jquery'), // or [] if you don't use jQuery
        null,
        true
    );
    wp_localize_script('booking-js', 'booking_vars', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('submit_booking_nonce')
    ]);
}
add_action('wp_enqueue_scripts', 'my_booking_scripts');
// ********************** End enqueue booking js **********************

/// ************* Start time slots **********************

function my_get_time_slots() {
    check_ajax_referer('submit_booking_nonce', 'nonce');

    global $wpdb;
    $table = $wpdb->prefix . 'bookings';

    $date = sanitize_text_field($_POST['date']);

    // Define your working hours
    $all_slots = ['09:00', '10:00', '11:00', '12:00',
                  '13:00', '14:00', '15:00', '16:00'];

    // Get taken slots from DB
    $taken = $wpdb->get_col(
        $wpdb->prepare("SELECT time FROM $table WHERE date = %s", $date)
    );

    // Calculate available ones
    $available = array_values(array_diff($all_slots, $taken));

    wp_send_json_success($available);
}
add_action('wp_ajax_get_time_slots', 'my_get_time_slots');
add_action('wp_ajax_nopriv_get_time_slots', 'my_get_time_slots');

// ************* End time slots **********************



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

// function dress_progress_admin_menu() {
//     add_menu_page(
//         'Dress Progress',
//         'Dress Progress',
//         'manage_options',
//         'dress-progress',
//         'dress_progress_admin_page',
//         'dashicons-admin-customizer',
//         6
//     );
// }
// add_action('admin_menu', 'dress_progress_admin_menu');


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
    if ( isset($_POST['submit_progress']) && !empty($_POST['user_id']) ) {
        $user_id = intval($_POST['user_id']);
        $stage   = sanitize_text_field($_POST['stage']);
        $video   = esc_url_raw($_POST['video_url']);

        $wpdb->insert(
            $table_name,
            array(
                'user_id'   => $user_id,
                'stage'     => $stage,
                'video_url' => $video,
            )
        );

        echo "<div class='updated'><p> Progress added successfully for user ID: $user_id</p></div>";
    }

    ?>
    <div class="wrap">
        <h1>Dress Progress</h1>
        <form method="post">
            
            <label for="user_id"><strong>Select Client:</strong></label><br>
            <?php
                wp_dropdown_users( array(
                'name'             => 'user_id',
                'show_option_none' => '— Select a User —',
                'selected'         => 0, // none preselected
            ) );
            ?>
            <br><br>

            <label for="stage"><strong>Progress Stage:</strong></label><br>
            <input type="text" name="stage" required style="width: 300px;"><br><br>

            <label for="video_url"><strong>Video URL:</strong></label><br>
            <input type="url" name="video_url" style="width: 300px;"><br><br>

            <input type="submit" name="submit_progress" class="button-primary" value="Add Progress">
        </form>
    </div>
    <?php
}

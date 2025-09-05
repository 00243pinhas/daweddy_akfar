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



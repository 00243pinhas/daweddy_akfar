<?php
// Enqueue parent theme stylesheet
function afkar_child_enqueue_styles() {
    wp_enqueue_style('afkar-parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('afkar-child-style', get_stylesheet_directory_uri() . '/style.css', array('afkar-parent-style'));
}
add_action('wp_enqueue_scripts', 'afkar_child_enqueue_styles');

// You can add custom functions or modifications specific to the child theme below
?>
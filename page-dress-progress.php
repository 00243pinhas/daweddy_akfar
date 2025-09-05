<?php
/* Template Name: Dress Progress Portal */

get_header();

    // if(! is_user_logged_in()) {
    //     wp_redirect( hwc_get_page_permalink('/my-account'));
    //     exit;
    // }

       if ( is_page('my-dress-progress') && ! is_user_logged_in() ) {
        wp_safe_redirect( wc_get_page_permalink('/my-account/') );
        exit;
    }

echo '<div> hello pinhas </div>';


get_footer();

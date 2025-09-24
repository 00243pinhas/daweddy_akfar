<?php
/* Template Name: Favorites Page */



get_header();

    if (! is_user_logged_in()){
        echo" <p> PPlease login first </p>";

        get_footer ();
        exit;
    }

    $user_id = get_current_user_id();
    $favorites = get_user_meta($user_id, 'favorite_dresses', true);


    if(!empty($favorites)){
        $args = [
            'post__in' => $favorites,
            'post_type' => 'dress', 
            'orderby' => 'post__in',
            'posts_per_page' => -1,
        ];

        $query = new WP_Query($args);

        if($query -> have_posts()){
            echo '<div class="container my-5">';
            echo '<div class="text-center mb-5">';
            echo '<h1 class="display-5 fw-bold">Ideas Recorded</h1>';
            echo '<p class="text-muted">Here are the dresses you saved to favorites.</p>';
            echo '</div>';
            echo '<div class="row">';
            while($query -> have_posts()){
                $query->the_post();
                echo '<div class="col-md-3 mb-4">';
                echo '<div class="card h-100">';
                if(has_post_thumbnail()){
                    echo '<a href="' . get_permalink() . '" class="text-decoration-none">';
                    echo get_the_post_thumbnail(get_the_ID(), 'large', ['class' => 'card-img-top']);
                    echo '</a>';
                }
                echo '<div class="card-body text-center d-flex justify-content-between align-items-center">';
                echo '<a href="' . get_permalink() . '" class="text-decoration-none">';
                echo '<h5 class="card-title">' . get_the_title() . '</h5>';
                echo '</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo '<p>You have no favorite posts yet.</p>';
        }

    } else {
        echo '<p>You have no favorite posts yet.</p>';
    }

        get_footer();
        ?>  


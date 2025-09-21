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
            'orderby' => 'post__in'
        ];

        $query = new WP_Query($args);

        if($query -> have_posts()){
            echo '<div class="row">';

            while($query -> have_posts()){
                $query->the_post(); ?>

                <div class="col-md-3 mb-4 ">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('medium', ['class' => 'img-fluid']);
                        } ?>
                        <h4><?php the_title(); ?></h4>
                    </a>
                </div>

                  <?php }

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


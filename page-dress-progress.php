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

        global $wpdb;
        $user_id = get_current_user_id();
        $table_name = $wpdb->prefix . "dress_progress";

        // Fetch progress data for the logged-in user
        $progress = $wpdb->get_results( $wpdb->prepare(
                    "SELECT * FROM $table_name WHERE user_id = %d ORDER BY created_at ASC",
                    $user_id
                ) );
                
                // echo '<script>var progressData = ' . json_encode($progress) . '; console.log(progressData);</script>';

                
                // Display the progress data
                if ( $progress ) {
                    echo '<div class="dress-progress">';
                    foreach ( $progress as $step ) {
                        $media_html = dp_render_media( $step->video_url );
                        ?>
                            <article class="dress-card card">
                                <?php if ( $media_html ) : ?>
                                    <div class="dress-card-media">
                                        <?php echo $media_html; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="dress-card-body card-body">
                                    <h3 class="dress-card-title card-title"><?php echo esc_html( $step->stage ); ?></h3>
                                    <p class="dress-card-meta">Updated: <?php echo esc_html( date_i18n( 'F j, Y', strtotime( $step->created_at ) ) ); ?></p>
                                    <?php if ( ! empty( $step->notes ) ) : // optional notes field ?>
                                        <div class="dress-card-notes"><?php echo wp_kses_post( wpautop( $step->notes ) ); ?></div>
                                    <?php endif; ?>
                                </div>
                            </article>
                            <?php
                        }
                        echo '</div>';
                } else {
                    echo "<p>No progress found.</p>";
                }
                echo "</div>";
                
            




get_footer();

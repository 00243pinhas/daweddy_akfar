<?php
/**
 * Template part for displaying posts in loop
 *
 * @package Bravisthemes
 */
$post_tag = afkar()->get_theme_opt( 'post_tag', true );
$post_navigation = afkar()->get_theme_opt( 'post_navigation', false );
// $post_social_share = afkar()->get_theme_opt( 'post_social_share', false );
$post_author_box_info = afkar()->get_theme_opt( 'post_author_box_info', false );
$align_content_post = afkar()->get_page_opt( 'align_content_post', 'content-left' );
$post_feature_image_on = afkar()->get_page_opt( 'post_feature_image_on', true );
$post_title_on = afkar()->get_page_opt( 'post_title_on', true );
?>
<article id="pxl-post-<?php the_ID(); ?>" <?php post_class( 'pxl-item-single-post'.' '.$align_content_post ); ?>>
    <?php if($post_title_on) { ?>
        <h2 class="pxl-item--title"><?php the_title(); ?></h2>
    <?php } ?>
    <?php afkar()->blog->get_post_metas(); ?>
    <?php if($post_feature_image_on) { ?>
        <?php if (has_post_thumbnail()) {
            echo '<div class="pxl-item--image">'; ?>
                <?php the_post_thumbnail('afkar-lager'); ?>
            <?php echo '</div>';
        } 
    } ?>

    <div class="pxl-item--holder">
        <!-- <?php if($post_social_share) { afkar()->blog->get_socials_share(); } ?> -->
        <div class="pxl-item--content clearfix">
            <?php
                the_content();
                wp_link_pages( array(
                    'before'      => '<div class="page-links">',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                ) );
            ?>
        </div>
    </div>

    <?php if( $post_tag ) {  ?>
        <div class="pxl--post-footer">
            <?php if($post_tag) { afkar()->blog->get_tagged_in(); } ?>
        </div>
    <?php } ?>

    <?php if($post_navigation) { afkar()->blog->get_post_nav(); } ?>
    <?php if($post_author_box_info) : ?>
        <div class="pxl--author-info">
            <div class="entry-author-avatar">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 160 ); ?>
            </div>
            <div class="entry-author-meta">
                <h3 class="author-name">
                    <?php the_author_posts_link(); ?>
                </h3>
                <div class="author-description">
                    <?php the_author_meta( 'description' ); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</article><!-- #post -->
<?php
if ( ! empty( $settings['logo_link']['url'] ) ) {
    $widget->add_render_attribute( 'logo_link', 'href', $settings['logo_link']['url'] );

    if ( $settings['logo_link']['is_external'] ) {
        $widget->add_render_attribute( 'logo_link', 'target', '_blank' );
    }

    if ( $settings['logo_link']['nofollow'] ) {
        $widget->add_render_attribute( 'logo_link', 'rel', 'nofollow' );
    }
}

$custom_logo_id = get_theme_mod( 'custom_logo' );
$logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );
if ( $logo_url ) :
    ?>
    <div class="pxl-logo <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>">
        </a>
    </div>
<?php
elseif(!empty($settings['logo']['id'])) : 
    $img  = pxl_get_image_by_size( array(
        'attach_id'  => $settings['logo']['id'],
        'thumb_size' => 'full',
    ) );
    $thumbnail    = $img['thumbnail'];
    ?>
    <div class="pxl-logo <?php echo esc_attr($settings['pxl_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['pxl_animate_delay']); ?>ms">
        <?php if ( ! empty( $settings['logo_link']['url'] ) ) { ?><a <?php pxl_print_html($widget->get_render_attribute_string( 'logo_link' )); ?>><?php } ?>
            <?php echo wp_kses_post($thumbnail); ?>
        <?php if ( ! empty( $settings['logo_link']['url'] ) ) { ?></a><?php } ?>
    </div>
<?php endif; ?>
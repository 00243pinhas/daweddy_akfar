<?php 
$default_settings = [
    'title' => '',
    'image' => '',
    'img_size' => '',
    'image_link' => '',
    'notification' => '',
    'notification_label' => '',
];
$settings = array_merge($default_settings, $settings);
extract($settings);
$size = 'full';
if(!empty($img_size)) {
    $size = $img_size;
} else {
    $size = 'full';
}
$img  = pxl_get_image_by_size( array(
    'attach_id'  => $image['id'],
    'thumb_size' => $size,
) );

if ( ! empty( $settings['link']['url'] ) ) {
    $widget->add_render_attribute( 'link', 'href', $settings['link']['url'] );
    $icon_tag = 'a';

    if ( $settings['link']['is_external'] ) {
        $widget->add_render_attribute( 'link', 'target', '_blank' );
    }

    if ( $settings['link']['nofollow'] ) {
        $widget->add_render_attribute( 'link', 'rel', 'nofollow' );
    }
}
if ( ! empty( $settings['link2']['url'] ) ) {
    $widget->add_render_attribute( 'link2', 'href', $settings['link2']['url'] );
    $icon_tag = 'a';

    if ( $settings['link2']['is_external'] ) {
        $widget->add_render_attribute( 'link2', 'target', '_blank' );
    }

    if ( $settings['link2']['nofollow'] ) {
        $widget->add_render_attribute( 'link2', 'rel', 'nofollow' );
    }
}
$link_attributes = $widget->get_render_attribute_string( 'link' );
$link_attributes2 = $widget->get_render_attribute_string( 'link2' );
?>
<div class="pxl-showcase layout1">
    <div class="inner-box">
        <div class="item-feature">
            <div class="pxl-item-links">
                <?php if( ! empty($settings['btn_text1']) || ! empty( $settings['link']['url'] ) ) { ?>
                    <a class="link-1 btn-hover active" <?php pxl_print_html($widget->get_render_attribute_string( 'link' )); ?>>
                        <span><?php echo pxl_print_html($settings['btn_text1']); ?></span>
                    </a>
                <?php } ?>
                <?php if( ! empty($settings['btn_text2']) || ! empty( $settings['link2']['url'] ) ) { ?>
                    <a class="link-2 btn-hover" <?php pxl_print_html($widget->get_render_attribute_string( 'link2' )); ?>>
                        <span><?php echo pxl_print_html($settings['btn_text2']); ?></span>
                    </a>
                <?php } ?>
            </div>
        </div>
        <h3 class="item-title">
            <?php if ( ! empty( $image_link['url'] ) ) { ?><a <?php pxl_print_html($widget->get_render_attribute_string( 'image_link' )); ?>><?php } ?>
                <?php echo pxl_print_html($title); ?>
            <?php if ( ! empty( $image_link['url'] ) ) { ?></a><?php } ?>
            <?php if ( $settings['notification'] == 'true' ) { ?>
                <?php if( ! empty($settings['notification_label']) ) { ?>
                    <span class="notification"><?php echo pxl_print_html($settings['notification_label']); ?></span>
                <?php } ?>
            <?php } ?>
        </h3>
    </div>
</div>
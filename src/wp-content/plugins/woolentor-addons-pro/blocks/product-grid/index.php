<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$uniqClass 	 = 'woolentorblock-'.$settings['blockUniqId'];
$areaClasses = array( $uniqClass, 'woolentor_block_product_grid' );
!empty( $settings['align'] ) ? $areaClasses[] = 'align'.$settings['align'] : '';
!empty( $settings['className'] ) ? $areaClasses[] = esc_attr( $settings['className'] ) : '';

!empty( $settings['columns']['desktop'] ) ? $areaClasses[] = 'woolentor-grid-columns-'.$settings['columns']['desktop'] : 'woolentor-grid-columns-4';
!empty( $settings['columns']['laptop'] ) ? $areaClasses[] = 'woolentor-grid-columns-laptop-'.$settings['columns']['laptop'] : 'woolentor-grid-columns-laptop-3';
!empty( $settings['columns']['tablet'] ) ? $areaClasses[] = 'woolentor-grid-columns-tablet-'.$settings['columns']['tablet'] : 'woolentor-grid-columns-tablet-2';
!empty( $settings['columns']['mobile'] ) ? $areaClasses[] = 'woolentor-grid-columns-mobile-'.$settings['columns']['mobile'] : 'woolentor-grid-columns-mobile-1';

// Slider Options
$slider_settings = [];
if( $settings['slider'] === true ){
    $is_rtl = is_rtl();
    $direction = $is_rtl ? 'rtl' : 'ltr';
    $slider_settings = [
        'arrows' => ( true === $settings['arrows'] ),
        'dots' => ( true === $settings['dots'] ),
        'autoplay' => ( true === $settings['autoplay'] ),
        'autoplay_speed' => absint( $settings['autoplaySpeed'] ),
        'animation_speed' => absint( $settings['animationSpeed'] ),
        'pause_on_hover' => ( true === $settings['pauseOnHover'] ),
        'rtl' => $is_rtl,
    ];

    $slider_responsive_settings = [
        'product_items' => $settings['sliderItems'],
        'scroll_columns' => $settings['scrollColumns'],
        'tablet_width' => $settings['tabletWidth'],
        'tablet_display_columns' => $settings['tabletDisplayColumns'],
        'tablet_scroll_columns' => $settings['tabletScrollColumns'],
        'mobile_width' => $settings['mobileWidth'],
        'mobile_display_columns' => $settings['mobileDisplayColumns'],
        'mobile_scroll_columns' => $settings['mobileScrollColumns'],

    ];
    $slider_settings = array_merge( $slider_settings, $slider_responsive_settings );
}

// For Short code settings
$additional_settings = [
    'product_layout' => 'grid',
    'column' => $settings['columns']['desktop'],
    'gridcolumn' => 'yes',
    'slider_on' => $settings['slider'] === true ? 'yes' : 'no',
    'slider_settings' => $slider_settings,
    'grid_style' => $settings['gridStyle'],
    'no_gutters' => $settings['noGutter'] === true ? 'yes' : 'no',
    'product_limit' => $settings['perPage'],
    'categories' => $settings['taxonomy'],
    'cat_operator' => $settings['catOperator'],
    'orderby' => $settings['orderBy'],
    'paginate' => $settings['paginate'] === true ? 'yes' : 'no',
    'allow_order' => $settings['allowOrder'] === true ? 'yes' : 'no',
    'show_result_count' => $settings['showResultCount'] === true ? 'yes' : 'no',
    'product_ids_manually' => $settings['productType'] === 'show_byid_manually' ? $settings['productIdsManually'] : '',
    'add_to_cart_text' => ( $settings['gridStyle'] == 1 || $settings['gridStyle'] == 2 ) ? $settings['addToCartText'] : '',
    'image_layout_type' => $settings['imageLayoutType'],
    'hide_category' => $settings['hideCategory'] === true ? 'yes' : 'no',
    'hide_rating' => $settings['hideRating'] === true ? 'yes' : 'no',
];

if( !empty( $settings['addToCartIcon'] ) ) {
    $additional_settings['buttonIcon'] = $settings['addToCartIcon'];
}

$settings = array_merge( $settings, $additional_settings );

echo '<div class="'.implode(' ', $areaClasses ).'">';

    $type = woolentorBlocks_Product_type( $settings['productType'] );
    $filterable = $settings['filterable'];

    $shortcode = new \WooLentor_WC_Shortcode_Products( $settings, $type, $filterable );
    $content = $shortcode->get_content( 'grid' );
    $not_found_content = woolentor_pro_products_not_found_content();

    if ( true === $filterable ) {
        $wrap_class = 'wl-filterable-products-wrap';
        $content_class = 'wl-filterable-products-content';
        $wrap_attributes = 'data-wl-widget-name="wl-product-grid"';
        $wrap_attributes .= ' data-wl-widget-settings="' . esc_attr( htmlspecialchars( wp_json_encode( $settings ) ) ) . '"';
        ?>
        <div class="<?php echo esc_attr( $wrap_class ); ?>"<?php echo $wrap_attributes; ?>>
            <div class="<?php echo esc_attr( $content_class ); ?>">
                <?php
                    if ( strip_tags( trim( $content ) ) ) {
                        echo $content;
                    } else{
                        echo $not_found_content;
                    }
                ?>
            </div>
        </div>
        <?php
    } else {
        if ( strip_tags( trim( $content ) ) ) {
            echo $content;
        } else{
            echo $not_found_content;
        }
    }

echo '</div>';
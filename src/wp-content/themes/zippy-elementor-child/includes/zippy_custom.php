<?php
add_action('wp_enqueue_scripts', 'shin_scripts');

function shin_scripts()
{
    $version = time();

    wp_enqueue_style('main-style-css', THEME_URL . '-child' . '/assets/dist/css/main.min.css', array(), $version, 'all');

    wp_enqueue_script('main-scripts-js', THEME_URL . '-child' . '/assets/dist/js/main.min.js', array('jquery'), $version, true);
}

function custom_category_menu_shortcode()
{
    ob_start();
?>
    <div class="bot_nav_cat_inner">
        <div class="bot_nav_cat">
            <button class="bot_cat_button close">
                <div class="cat_ico">
                    <div class="cat_ico_block"><span></span></div>
                    <span class="text-button">Categories</span>
                </div>
                <span class="arrow-icon"></span>
            </button>

            <nav class="bot_nav_cat_wrap cat_open_default" style="display: none;">
                <div class="menu-category-navigation-container">
                    <ul id="cat_menu" class="cat_menu">
                        <?php
                        $args = array(
                            'taxonomy'     => 'product_cat',
                            'parent'       => 0,
                            'orderby'      => 'name',
                            'show_count'   => false,
                            'pad_counts'   => false,
                            'hierarchical' => 1,
                            'hide_empty'   => true,
                        );
                        $categories = get_categories($args);
                        foreach ($categories as $category) {
                            $sub_args = array(
                                'taxonomy'   => 'product_cat',
                                'parent'     => $category->term_id,
                                'hide_empty' => true,
                            );
                            $sub_cats = get_categories($sub_args);
                        ?>
                            <li class="menu-item menu-item-type-taxonomy menu-item-object-product_cat <?php echo !empty($sub_cats) ? 'menu-item-has-children' : ''; ?>">
                                <a href="<?php echo get_term_link($category); ?>">
                                    <span class="nav_item_wrap"><?php echo $category->name; ?></span>
                                </a>
                                <?php if (!empty($sub_cats)) : ?>
                                    <ul class="sub-menu">
                                        <?php foreach ($sub_cats as $sub_cat) : ?>
                                            <li class="menu-item menu-item-type-taxonomy menu-item-object-product_cat">
                                                <a href="<?php echo get_term_link($sub_cat); ?>">
                                                    <span class="nav_item_wrap"><?php echo $sub_cat->name; ?></span>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('category_menu_layout', 'custom_category_menu_shortcode');

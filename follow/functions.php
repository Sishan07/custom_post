<?php
function followandrew_theme_support(){

    //add dynamic title tag support

    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme','followandrew_theme_support');


function followandrew_menus() {
    $locations = array(
        'primary' => "Desktop Primary Left Sidebar",
        'footer' => "Footer Menu Items"
    );
    register_nav_menus($locations);
}
add_action('init','followandrew_menus');


function followandrew_register_styles(){
    wp_enqueue_style('followandrew-style', get_template_directory_uri() . "/style.css", array('followandrew-bootstrap'), "1.0", 'all');
    wp_enqueue_style(
        'followandrew-bootstrap',
        "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css",
        array(),
        "4.4.1",
        'all'
    );
    wp_enqueue_style(
        'followandrew-font-awosome',
        "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css",
        array(),
        "5.13.0",
        'all'
    );
}
add_action('wp_enqueue_scripts', 'followandrew_register_styles');


function followandrew_register_scripts(){
    wp_enqueue_script(
        'followandrew-jquery',
        "https://code.jquery.com/jquery-3.4.1.slim.min.js",
        array('followandrew-bootstrap'),
        "1.0",
        'all'
    );
    wp_enqueue_script(
        'followandrew-popper',
        "https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js",
        array(),
        "4.4.1",
        'all'
    );
    wp_enqueue_script(
        'followandrew-bootstrap',
        "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js",
        array(),
        "5.13.0",
        'all'
    );
    wp_enqueue_script(
        'followandrew-js',
        get_template_directory_uri() . "/assets/js/main.js",
        array(),
        "1.0",
        'all'
    );
}
add_action('wp_enqueue_scripts', 'followandrew_register_scripts');


function followandrew_widget_areas() {
    register_sidebar(
        array(
            'before_title' => '',
            'after_title' => '',
            'before_widget' => '',
            'after_widget' => '',
            'name' => 'Sidebar Area',
            'id' => 'sidebar-1',
            'decsription' => 'Sidebar Widget Area'
        )
    );
    
    register_sidebar(
        array(
            'before_title' => '',
            'after_title' => '',
            'before_widget' => '',
            'after_widget' => '',
            'name' => 'Footer Area',
            'id' => 'footer-1',
            'decsription' => 'Footer Widget Area'
        )
    );
}

add_action( 'widgets_init', 'followandrew_widget_areas');


function create_custom_post_type() {

    $labels = array(
        'name' => 'portfolio',
        'singular_name' => 'portfolio',
        'add_new' => 'Add Item',
        'all_items' => 'All Items',
        'add_new_item' => 'Add Item',
        'edit_item' => 'Edit Item',
        'new_item' => 'New Item',
        'view_item' => 'View Item',
        'search_item' => 'Search Portfolio',
        'not_found' => 'No Item Found',
        'not_found_in_trash' => 'No items found in trash',
        'parent_item_colon' => 'Parent Item',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' =>'post',
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'revision',
        ),
        // 'taxonomies' => array('category', 'post_tag'),
        'menu_position' => 5,
        'exclude_from_search' => false
    );
     
    register_post_type( 'portfolio',$args);
    }
add_action( 'init', 'create_custom_post_type');

function awosome_custom_taxonomies() {
    //add new hiererchical taxonomies
    $labels = array(
        'name' => 'Fields',
        'singular_name' => 'Fields',
        'serach_items' => 'Search Fields',
        'all_items' => "ALL Fields",
        'parent_item' => "Parent Field",
        'parent_item_colon' => 'Parent Field: ',
        'edit-item' => 'Edit Field',
        'update_item' => 'Update Field',
        'add_new_item' => 'Add New Field',
        'nav_item_menu' => 'New Field Name',
        'menu_name' => 'Fields'
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'fields')
    );
    register_taxonomy('field', array('portfolio'), $args);

    //add taxonomy not hierrchical
    register_taxonomy('software' , 'portfolio', array(
        'label' => 'Software',
        'rewrite' => array( 'slug' => 'software'),
        'hierarchical' => false
    ));
}
add_action('init', 'awosome_custom_taxonomies' );

function awosome_get_terms( $postID, $term) {
    $terms_list = wp_get_post_terms($postID, $term);
    $output = '';
    $i = 0;
    foreach ($terms_list as $term) {
        $i++;
        if ($i > 1) {
            $output .= ', ';
        }
        $output .= '<a href="' . get_term_link( $term ) .'">'. $term->name . '</a>';
    }
    return $output;

}

<?php
/*
 * Adds a Feature content type
 */

// Add Issue post type and taxonomies
$typeFeature = new Type_Feature();
add_action( 'init', array($typeFeature, 'register_cpt_feature') ); 

class Type_Feature {
    function register_cpt_feature() {

        $labels = array( 
            'name' => _x( 'Features', 'feature' ),
            'singular_name' => _x( 'Feature', 'feature' ),
            'add_new' => _x( 'Add New', 'feature' ),
            'add_new_item' => _x( 'Add New Feature', 'feature' ),
            'edit_item' => _x( 'Edit Feature', 'feature' ),
            'new_item' => _x( 'New Feature', 'feature' ),
            'view_item' => _x( 'View Feature', 'feature' ),
            'search_items' => _x( 'Search Features', 'feature' ),
            'not_found' => _x( 'No features found', 'feature' ),
            'not_found_in_trash' => _x( 'No features found in Trash', 'feature' ),
            'parent_item_colon' => _x( 'Parent Feature:', 'feature' ),
            'menu_name' => _x( 'Features', 'feature' ),
            );

        $args = array( 
            'labels' => $labels,
            'hierarchical' => true,
            'description' => 'Features, distinct from blog posts or other content',
            'supports' => array( 
                'title', 
                'author', 
                'editor', 
                'excerpt', 
                'thumbnail', 
                'custom-fields', 
                'page-attributes', 
                'comments', 
                'post-thumbnails'
                ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            
            
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => true,
            'capability_type' => 'post'
            );

        register_post_type( 'feature', $args );
    }
}

<?php

// Enable wp_gear and media library
function media_upload_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('media-library', get_bloginfo('template_directory') . '/assets/js/media-library.js', array('jquery', 'thickbox'));
    wp_enqueue_media();
}

function media_upload_styles() {
    wp_enqueue_style('thickbox');
}

add_action('admin_print_scripts', 'media_upload_scripts');
add_action('admin_print_styles', 'media_upload_styles');
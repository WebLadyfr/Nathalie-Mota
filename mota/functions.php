<?php

function mota_enqueue_styles() {
    wp_enqueue_style( 'style-css', get_stylesheet_directory_uri(). '/style.css' );
    
}
add_action( 'wp_enqueue_scripts', 'mota_enqueue_styles' );
<?php

function mota_enqueue_styles() {
    wp_enqueue_style( 'style-css', get_stylesheet_directory_uri(). '/style.css' );
    
}
add_action( 'wp_enqueue_scripts', 'mota_enqueue_styles' );

// Enregistrement des emplacements de menu
function register_custom_menus() {
    register_nav_menus( array(
        'primary' => 'Main menu', // Emplacement du menu principal
        'footer'  => 'Menu footer', // Emplacement du menu pied de page
    ) );
}
add_action( 'after_setup_theme', 'register_custom_menus' );

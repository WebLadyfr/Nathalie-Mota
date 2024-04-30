<?php
// Enregistrement des emplacements de menu
function register_custom_menus() {
    register_nav_menus( array(
        'primary' => 'Main menu', // Emplacement du menu principal
        'footer'  => 'Menu footer', // Emplacement du menu pied de page
    ) );
}
add_action( 'after_setup_theme', 'register_custom_menus' );

function mota_enqueue_scripts()
{
// CSS
wp_enqueue_style( 'style-css', get_template_directory_uri(). '/style.css' );
//JS
wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0', true);
//Lightbox
wp_enqueue_script('lightbox', get_template_directory_uri() . '/assets/js/lightbox.js');
// Script ajax
wp_enqueue_script('ajax', get_template_directory_uri() . '/assets/js/ajax.js', array('jquery'), '1.0', true);
wp_localize_script('ajax', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

// Bibliothèque Font Awesome
wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array());

// Bibliothèque Select2 pour les selects de tri
wp_enqueue_script('select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);
wp_enqueue_style('select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', array());
    // Initialiser Select2 avec dropdownPosition: 'below'
    wp_add_inline_script('select2-js', '
        jQuery(document).ready(function($) {
            $(".js-example-basic-single").select2({
                dropdownPosition: "below"
            });
        });
    ');

}
add_action('wp_enqueue_scripts', 'mota_enqueue_scripts');

// AJAX handler for loading more photos
function load_more_photos() {

    $paged = isset($_POST['page']) ? intval($_POST['page']) + 1 : 1;

    // Vérifier et sécuriser les valeurs des filtres
    $cat_filter = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : '';
    $format_filter = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $annee_filter = isset($_POST['annee']) ? sanitize_text_field($_POST['annee']) : '';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 12,
        'paged' => $paged,
        'tax_query' => array(),
        'meta_query' => array(),
    );

    if (!empty($cat_filter)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $cat_filter,
        );
    }

    if (!empty($format_filter)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format_filter,
        );
    }

    if (!empty($annee_filter)) {
        $args['meta_query'][] = array(
            'key' => 'annee',
            'value' => $annee_filter,
            'compare' => '=',
        );
    }

    $photos_query = new WP_Query($args);

    ob_start();

    if ($photos_query->have_posts()) {
        while ($photos_query->have_posts()) {
            $photos_query->the_post();
            // Structure du catalogue
            get_template_part('template-parts/post/catalogue-photos');
        }
    }

    wp_reset_postdata();

    $response = ob_get_clean();
    echo $response;
    exit;
}

add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');
<?php get_header();?>

<?php
//* //* Récupérer les champs ACF
$reference = get_field('reference');
$types = get_field('type');

// Vérifier si le champ ACF a des valeurs
if ($types) {
    foreach ($types as $type) {
        // Récupérer le nom de chaque type qu'on stocke dans la $type_name
        $type_name = $type;
    }
}
$annee = get_field('annee');


//* Récupérer les termes de la taxonomie "catégorie"
$categories = get_the_terms(get_the_ID(), 'categorie');
// Vérifier si des catégories existent
if ($categories && !is_wp_error($categories)) {
    foreach ($categories as $categorie) {
        // Récupérer le nom de chaque catégorie dans $categorie_name
        $categorie_name = $categorie->name;
    }
}
//* Récupérer les termes de la taxonomie "format"
$formats = get_the_terms(get_the_ID(), 'format');
// Vérifier si des formats existent
if ($formats && !is_wp_error($formats)) {
    foreach ($formats as $format) {
        // Récupérer le nom de chaque format dans $format_name
        $format_name = $format->name;
    }
}


?>
<!-- descriptif photo -->
<section class="container">
    <article class="content">
        <div class="meta-photo">
            <h2 class="title-photo"><?php the_title(); ?></h2>
            <div class="meta">
            <p>Référence : <?php echo $reference; ?></p>
            <p>Catégorie : <?php echo $categorie_name; ?> </p>
            <p>Format : <?php echo $format_name; ?> </p>
            <p>Type : <?php echo $type_name; ?> </p>
            <p>Année : <?php echo $annee; ?></p>
            </div>
       </div>
               <!-- photo -->
               <div class="photo-container">
            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
        </div>
        <!-- bouton contact -->
        <div class="contact">
            <p>Cette photo vous intéresse ?</p>
            <button class="btn btn-contact " data-reference="<?php echo $reference; ?>">Contact</button>
        </div>
        <!-- slider miniature -->
        <div class="navigation-miniature">
            <div class="thumbnails-container-prev">
            <?php
            $prev_post = get_previous_post();							
            if($prev_post) {
                $prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
                $prev_post_id = $prev_post->ID;
                echo '<a rel="prev" href="' . get_permalink($prev_post_id) . '" title="' . $prev_title. '" class="previous_post">';
                if (has_post_thumbnail($prev_post_id)){
                    ?>
                    <div>
                        <?php echo get_the_post_thumbnail($prev_post_id, array(77,60));?></div>
                    <?php
                    }
                    else{
                        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/img/no-image.jpeg" alt="Pas de photo" width="77px" ><br>';
                    }							
                    echo '<img src="'. get_stylesheet_directory_uri() .'/assets/img/precedent.png" alt="Photo précédente" ></a>';
                }
                ?>
        </div>
        <div class="thumbnails-container-next">
            <?php
                $next_post = get_next_post();
                if($next_post) {
                    $next_title = strip_tags(str_replace('"', '', $next_post->post_title));
                    $next_post_id = $next_post->ID;
                    echo  '<a rel="next" href="' . get_permalink($next_post_id) . '" title="' . $next_title. '" class="next_post">';
                    if (has_post_thumbnail($next_post_id)){
                    ?>
                    <div>
                        <?php echo get_the_post_thumbnail($next_post_id, array(77,60));?></div>
                    <?php
                    }
                    else{
                        echo '<img src="'. get_stylesheet_directory_uri() .'/assets/img/no-image.jpeg" alt="Pas de photo" width="77px" ><br>';
                    }							
                    echo '<img src="'. get_stylesheet_directory_uri() .'/assets/img/suivant.png" alt="Photo suivante" ></a>';
                }
            ?>
            </div>
        </div>

        <!-- photos apparentée à la categorie -->
        <div class="photo-apparentee">
            <h3>Vous aimerez aussi</h3>
            <div class="catalogue-photos">

                <?php
                // Nouvelle instance de WP_Query pour récupérer 2 posts de la meme catégorie que le post actuel 
                $args_related_photos = array(
                    'post_type' => 'photo',
                    'posts_per_page' => 2,
                    'orderby' => 'rand',
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'categorie',
                            'field' => 'slug',
                            'terms' => $categorie_name,
                        ),
                    ),
                    'post__not_in' => array(get_the_ID()), // Exclure l'id de la publication actuelle
                );

                $related_photos = new WP_Query($args_related_photos);

                if ($related_photos->have_posts()) {
                    while ($related_photos->have_posts()) {
                        $related_photos->the_post();

                        // structure du catalogue
                        get_template_part('template-parts/post/catalogue-photos');
                    }
                    wp_reset_postdata();
                }
                ?>
            </div>
        </div>
    </article>
</section>
<?php get_footer();?>

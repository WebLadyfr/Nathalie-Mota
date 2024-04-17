<?php get_header();?>

<main id="main" class="site-main" role="main">

    <!-- Banner -->
    <section class="banner">
    <?php
    // Récupérer une liste d'articles avec des images mises en avant
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS',
            ),
        ),
    );
    $posts = get_posts($args);

    // Choisir aléatoirement un article parmi ceux récupérés
    $random_post = $posts[array_rand($posts)];

    // Récupérer l'URL de l'image mise en avant de l'article choisi
    $thumbnail_url = get_the_post_thumbnail_url($random_post->ID);

    if ($thumbnail_url) {
        ?>
        <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo get_the_title($random_post->ID); ?>">
    <?php } ?>

    <h1 class="title">Photographe event</h1>
</section>

<section class="photos">
    <?php
    // Arguments de la requête pour récupérer les publications de votre type de contenu personnalisé
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => -1, // Récupérer toutes les publications
    );

    // Effectuer la requête
    $query = new WP_Query($args);

    // Vérifier si des publications ont été trouvées
    if ($query->have_posts()) :
        // Commencer la boucle
        while ($query->have_posts()) :
            $query->the_post();

            // Récupérer l'URL de l'image mise en avant
            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID());

            // Afficher l'image si une URL est disponible
            if ($thumbnail_url) :
                ?>
                <div class="post-container">
                    <img class="" src="<?php echo $thumbnail_url; ?>" alt="<?php the_title(); ?>">
                </div>
            <?php
            endif;
        endwhile;

        // Réinitialiser les données de la publication
        wp_reset_postdata();
        endif;
    ?>
</section>


    <!-- filtres + catalogue -->
    <section class="container">
        <?php
        //* Nouvelle instance wp_query pour recuperer les filtres (taxonomies et champs ACF année)
        $args_filters = array(
            'post_type' => 'photo',
            'posts_per_page' => -1,
        );
        $get_custom_filtres = new WP_Query($args_filters);

        // Récupérer les termes de la taxonomie "catégorie" qui renvoie un tableau
        $categories = get_terms('categorie');

        // Récupérer les termes de la taxonomie "format" qui renvoie un tableau
        $formats = get_terms('format');

        // on définit un tableau pour les années
        $annees = array();

        if ($get_custom_filtres->have_posts()) {
            while ($get_custom_filtres->have_posts()) {
                $get_custom_filtres->the_post();

                // Récupére la valeur du champ ACF "année" pour chaque post dans la boucle
                $annee = get_field('annee');
                // si la variable n'est pas vide et n'existe pas dans le tableau années
                if (!empty($annee) && !in_array($annee, $annees)) {
                    // on ajoute les valeurs année au tableau
                    $annees[] = $annee;
                }
                // Trier les années par ordre croissant
                sort($annees);
            }
            wp_reset_postdata();
        }
        ?>
<?php get_footer(); ?>

<?php get_header();?>

<main id="main" class="site-main" role="main">

    <!-- Banner -->
    <section class="banner">
        <?php
        $post_id = 92; // ID du post pour afficher son image dans la bannière
        $thumbnail_banner = get_the_post_thumbnail_url($post_id);

        if ($thumbnail_banner) {
        ?>
            <img src="<?php echo $thumbnail_banner; ?>" alt="<?php echo  get_the_title($post_id); ?>">

        <?php } ?>

        <h1 class="title">Photographe event</h1>
    </section>


    <!-- filtres + catalague -->
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

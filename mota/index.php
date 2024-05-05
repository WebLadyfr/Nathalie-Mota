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

    <!-- filtres + catalogue -->
    <section class="container">
        <?php
        // Nouvelle instance wp_query pour recuperer les filtres (taxonomies et champs ACF année)
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
        <!-- Filtres -->
        <div class="filter">
            <form action="" method="post" id="filters-posts">
                <div class="select-wrapper">
                    <div class="categories">
                        <!-- Menu déroulant pour la taxonomie "catégorie"  -->
                        <?php if (!empty($categories)) : ?>
                            <select name="categorie" id="categories" class="js-example-basic-single select2-dropdown-below">
                                <option value="">CATÉGORIES</option>
                                <?php foreach ($categories as $categorie) : ?>
                                    <option value="<?php echo $categorie->slug; ?>"><?php echo $categorie->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                    <div class="formats">
                        <!-- Menu déroulant pour la taxonomie "format  -->
                        <?php if (!empty($formats)) : ?>
                            <select name="format" id="formats" class="js-example-basic-single select2-dropdown-below">
                                <option value="">FORMATS</option>
                                <?php foreach ($formats as $format) : ?>
                                    <option value="<?php echo $format->slug; ?>"><?php echo $format->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>

                    <div class="annee">
                        <!-- Menu déroulant pour la tri par année (champs ACF)"  -->
                        <select name="annee" id="annee" class="js-example-basic-single select2">
                            <option value="">TRIER PAR</option>
                            <?php foreach ($annees as $annee) : ?>
                                <option value="<?php echo $annee; ?>"><?php echo $annee; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
            </form>
        </div>
        
        </section>
<section class="photos" data-page="1">
    <?php
    // Arguments de la requête pour récupérer les publications du type de contenu personnalisé
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8, // Récupérer toutes les publications
        'paged' => $paged
    );

    // Effectuer la requête
    $query = new WP_Query($args);

    // Vérifier si des publications ont été trouvées
    if ($query->have_posts()) {
        // Commencer la boucle
        while ($query->have_posts()) {
            $query->the_post();

            // structure du catalague
            get_template_part('template-parts/post/catalogue-photos');
        
        }
        // Réinitialiser les données de la publication
        wp_reset_postdata();
    };
    ?>
</section>

<button class="btn-load" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>">Charger plus<?php wp_nonce_field('charger_plus', 'charger_plus_nonce'); ?></button>
    </section>
    </main>
<?php get_footer(); ?>

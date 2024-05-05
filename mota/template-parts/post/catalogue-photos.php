<?php
// récupere les infos : image mise en avant(thumbnail_url), url du post, titre, categorie, réf
$thumbnail_url = get_the_post_thumbnail_url();
$post_url = get_permalink();
$post_title = get_the_title();
$reference = get_field('reference');
$categories = get_the_terms(get_the_ID(), 'categorie');
$categorie_names = array();

if ($categories && !is_wp_error($categories)) {
    foreach ($categories as $categorie) {
        // Stocker les noms de catégorie dans un tableau
        $categorie_names[] = $categorie->name;
    }
}

?>
<div class="post-container">
    <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $post_title; ?>">
    <div class="overlay">
        <div class="reference"><?php echo $reference; ?></div>
        <div class="categorie"><?php echo implode(', ', $categorie_names); ?></div>
        <div class="eye-icon">
            <a href="<?php echo $post_url; ?>">
                <i class="fa fa-eye"></i>
            </a>
        </div>
        <div class="expand-icon">
            <a class="icon" href=" #" data-reference="<?php echo $reference ?>" data-categorie="<?php echo implode(', ', $categorie_names); ?>" data-thumbnail-url="<?php echo $thumbnail_url; ?>">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>
</div>

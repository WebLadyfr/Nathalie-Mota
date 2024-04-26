console.log("ajax.js est chargé");

function loadMorePosts() {
    var catalogue = jQuery(".photos");
    var currentPage = parseInt(catalogue.data("page"));
    var categorie = jQuery("#categories").val();
    var format = jQuery("#formats").val();
    var annee = jQuery("#annee").val();

    // Effectuer la requête Ajax
    jQuery.ajax({
      url: myAjax.ajaxurl,
      type: "POST",
      dataType: "html",
      data: {
        action: "load_more_photos",
        page: currentPage,
        categorie: categorie,
        format: format,
        annee: annee,
      },

      success: function (response) {
        if (response) {
          // Ajouter les nouvelles images au catalogue
          catalogue.append(response);
          // Mettre à jour le numéro de page dans le conteneur
          catalogue.data("page", currentPage + 1);
          // Rétablir le texte du bouton "Charger plus"
          jQuery(".btn-load").text("Charger plus");
        } else {
          // Aucune nouvelle image disponible, cacher le bouton
          jQuery(".btn-load").hide();
        }
      },
      error: function () {
        // Gérer les erreurs
        jQuery(".btn-load").text("Erreur lors du chargement");
      },
    });
  }

  jQuery(document).ready(function($) {

 // Écoute des changements de valeur des filtres
 $("#categories, #formats, #annee").on("change", loadMorePosts);
    // Écoute du clic sur le bouton "Charger plus"
    $(".btn-load").on("click", function () {
      loadMorePosts();
    });
});
